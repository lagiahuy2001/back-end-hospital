<?php
namespace App\Http\Controllers\HospitalControllers\Auth;

use App\Http\Controllers\HospitalControllers\Controller;
use App\Models\Registration;
use App\Models\Role;
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

class CoordinatorController extends Controller
{
    public function __construct()
    {
        $this->middleware('roleCoordinator');
    }

    public function refuseRegis($id)
    {
        Registration::where('id', $id)->update([
            'refuse' => true
        ]);

        return Registration::query()->find($id);
    }
    public function updateRegistration(Request $request)
    {
        try {
            $request->validate([
                'user_phone' => 'required',
                'user_name' => 'required',
                'id' => 'required',
                'date_appointment' => 'required',
                'address_appointment' => 'required',
            ]);
            $data = $request->all();

            Registration::where('id', $data['id'])->update($data);

            return Registration::query()->find($data['id']);

        } catch (\Exception $e) {
            Log::error('Function updateRegistration: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }
    public function assignmentRegistration(Request $request)
    {
        try {
            $request->validate([
               'staff_id' => 'required',
               'id' => 'required',
            ]);
            $data = $request->all();
            Registration::where('id', $data['id'])->update([
                'staff_id' => $data['staff_id'],
                'status' => 1,
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Function assignmentRegistration: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }
    public function listRegisNew()
    {
        try {
            return Registration::query()->where('status', 0)->get();
        } catch (\Exception $e) {
            Log::error('Function listRegisNew: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }
    public function listStaff()
    {
        try {
            $roleStaff = Role::query()->where('role_name', Role::STAFF)->first();
            return User::query()->where('role_id', $roleStaff->id)->get();
        } catch (\Exception $e) {
            Log::error('Function getAllStaff: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }

}