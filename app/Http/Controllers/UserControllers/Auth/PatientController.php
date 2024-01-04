<?php
namespace App\Http\Controllers\UserControllers\Auth;



use App\Http\Controllers\UserControllers\Controller;
use App\Models\Registration;
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

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function createRegistration(Request $request)
    {
        try {
            $user = Auth::user();
            $data = $request->all();
            $data['patient_id'] = $user->id;
            $data['status'] = 0;
            Registration::create($data);

            return true;

        } catch (\Exception $e) {
            Log::error('Function createRegistration: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }

    public function patientGetListRegistration()
    {
        try {
            $user = Auth::user();

            return $this->respond([
                'success' => true,
                'registration' => Registration::query()
                    ->where('patient_id', $user->id)
                    ->orderBy('id', 'desc')
                    ->get(),
            ], 200);

        } catch (\Exception $e) {
            Log::error('Function patientGetListRegistration: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }

    public function patientGetDetailRegistration($id)
    {
        try {
            $user = Auth::user();

            return $this->respond([
                'success' => true,
                'registration' => Registration::query()->where('id', $id)
                    ->where('patient_id', $user->id)
                    ->first(),
            ], 200);

        } catch (\Exception $e) {
            Log::error('Function patientGetDetailRegistration: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }
}