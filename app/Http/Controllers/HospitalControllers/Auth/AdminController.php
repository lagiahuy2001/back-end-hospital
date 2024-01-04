<?php
namespace App\Http\Controllers\HospitalControllers\Auth;

use App\Http\Controllers\HospitalControllers\Controller;
use App\Models\Registration;
use App\Models\Role;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('roleAdmin');
    }

    public function statisticsNowYear()
    {
        $currentYear = date('Y');

        $result = Registration::select(
            DB::raw('MONTH(created_at) as date'),
            DB::raw('SUM(total_price) as value')
        )
            ->whereYear('created_at', $currentYear)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();

        $monthlyData = array_fill(1, 12, 0);

        foreach ($result as $item) {
            $monthlyData[$item->date] = $item->value ?: 0;
        }

        // Create an array of objects with the required structure
        $finalResult = [];
        foreach ($monthlyData as $month => $value) {
            $finalResult[] = [
                'date' => $month,
                'value' => $value,
            ];
        }
        return $this->respond([
            'success' => true,
            'finalResult' => $finalResult,
        ], 200);
    }
    public function updateService(Request $request)
    {
        try {
            $request->validate([
                'service_name' => ['required', 'string'],
                'id' => ['required'],
                'price' => ['required'],
            ]);

            $data = $request->all();

            $data['additional_information'] = json_encode($data['additional_information']);
            $service = Service::query()->find($data['id']);
            $service->update($data);
            return $this->respond([
                'success' => true,
                'service' => $service,
            ], 200);

        } catch (\Exception $e) {
            Log::error('Function updateService: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }
    public function createService(Request $request)
    {
        try {
            $request->validate([
                'service_name' => ['required', 'string'],
                'price' => ['required'],
            ]);

            $data = $request->all();

            $data['additional_information'] = json_encode($data['additional_information']);

            Service::create($data);

            return true;

        } catch (\Exception $e) {
            Log::error('Function createService: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }
    public function searchUser($search)
    {
        $roleAdmin = Role::query()->where('role_name', Role::ADMIN)->first();
        $listUser = User::query()
            ->where('role_id', '!=', $roleAdmin->id)
            ->where('name', 'like', "%{$search}%")
            ->orderBy('id', 'desc')
            ->get();
        return $this->respond([
            'success' => true,
            'listUser' => $listUser,
        ], 200);
    }

    public function fillUserByType($id)
    {
        $listUser = User::query()->where('role_id', $id)->orderBy('id', 'desc')->get();
        return $this->respond([
            'success' => true,
            'listUser' => $listUser,
        ], 200);
    }
    public function createUser(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'phone' => ['required', 'string', 'max:15', 'unique:'.User::class],
                'password' => ['required'],
                'role' => ['required'],
            ]);

            $data = $request->all();

            $role = Role::query()->find($data['role']);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
                'sex' => $request->sex,
                'date' => $request->date,
                'role_id' => $role->id,
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Function createUser: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }

    public function updateUser(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            ]);
            $data = $request->all();

            User::where('id', $data['id'])->update($data);

            $user = User::query()->find($data['id']);

            return $this->respond([
                'success' => true,
                'user' => $user,
            ], 200);

        } catch (\Exception $e) {
            Log::error('Function updateUser: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }
    public function listUser()
    {
        try {
            $roleAdmin = Role::query()->where('role_name', Role::ADMIN)->first();
            $listUser = User::query()->where('role_id', '!=', $roleAdmin->id)->orderBy('id', 'desc')->get();

            return $this->respond([
                'success' => true,
                'list_user' => $listUser,
            ], 200);

        } catch (\Exception $e) {
            Log::error('Function getListUser: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }

    public function getServiceDetail($id)
    {
        try {
            $service = Service::query()->find($id);
            $service->additional_information = json_decode($service->additional_information);
            return $this->respond([
                'success' => true,
                'service' => $service,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Function getServiceDetail: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }
    public function getUserDetail($id)
    {
        try {
            return $this->respond([
                'success' => true,
                'user' => User::query()->find($id),
            ], 200);
        } catch (\Exception $e) {
            Log::error('Function getUserDetail: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }

    public function listRole()
    {
        try {
            $listRole = Role::query()->where('role_name', '<>', Role::ADMIN)->get();

            return $this->respond([
                'success' => true,
                'list_role' => $listRole,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Function getAllRole: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }
}