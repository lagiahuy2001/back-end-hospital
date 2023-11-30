<?php
namespace App\Http\Controllers\UserControllers\Auth;



use App\Http\Controllers\UserControllers\Controller;
use App\Models\RegistrationService;
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

class AuthControllers extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'patientRegistration']]);
    }

    public function fillResultRegistrationService(Request $request)
    {
        try {
            $request->validate([
                'registration_id' => ['required'],
                'id' => ['required'],
            ]);

            $data = $request->all();
            $results = RegistrationService::query()
                ->where('registration_id', $data['registration_id']);
            if($data['id']){
                $results = $results->where('id', $data['id']);
            }
            $results = $results->where('status', 1)->get();

            $listFill = RegistrationService::query()
                ->where('registration_service.registration_id',  $data['registration_id'])
                ->where('registration_service.status', 1)
                ->select('registration_service.id', 'registration_service.service_name')
                ->get();

            return $this->respond([
                'results' => $results,
                'listFill' => $listFill,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Function fillResultRegistrationService: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }
    public function getResultRegistrationService($id)
    {
        $results = RegistrationService::query()->where('registration_id', $id)->where('status', 1)->get();

        $listFill = RegistrationService::query()
            ->where('registration_service.registration_id', $id)
            ->where('registration_service.status', 1)
            ->select('registration_service.id', 'registration_service.service_name')
            ->get();

        return $this->respond([
            'results' => $results,
            'listFill' => $listFill,
        ], 200);
    }
    public function getUser()
    {
        return Auth::user();
    }
    public function patientRegistration (Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'phone' => ['required', 'string', 'max:15', 'unique:'.User::class],
                'password' => ['required'],
            ]);

            $rolePatient = Role::query()->where('role_name', Role::PATIENT)->first();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
                'sex' => $request->sex,
                'date' => $request->date,
                'role_id' => $rolePatient->id,
            ]);

            return $this->respond([
               'success' => true,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Function patientRegistration: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }

    public function login (Request $request)
    {
        try {
            $request->validate([
                'phone' => ['required'],
                'password' => ['required'],
            ]);

            $credentials = request(['phone', 'password']);

            if (!$token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return $this->respondWithToken($token);
        } catch (\Exception $e) {
            Log::error('Function login: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }

    public function logout()
    {
        try {
            auth()->logout();
            return $this->respond([
                'success' => true,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Function logout: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        $user = Auth::user();
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60 * 10000,
            'user' => $user,
        ]);
    }
    public function listService()
    {
        try {
            $user = Auth::user();

            $listService = Service::query();
            if($user->isPermission(Role::PATIENT)){
                $listService = $listService->select(['id', 'service_name', 'price']);
            }
            $listService = $listService->get();
            return $this->respond([
                'success' => true,
                'list_service' => $listService,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Function getAllService: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }

}