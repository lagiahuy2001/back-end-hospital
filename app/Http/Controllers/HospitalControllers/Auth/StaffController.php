<?php
namespace App\Http\Controllers\HospitalControllers\Auth;

use App\Http\Controllers\HospitalControllers\Controller;
use App\Models\Registration;
use App\Models\RegistrationService;
use App\Models\Service;
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
use Ramsey\Uuid\Uuid;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('roleStaff');
    }

    public function getAllRegis()
    {
        try {
            $user = Auth::user();

            return Registration::query()->where('staff_id', $user->id)->where('status', 1)->get();

        } catch (\Exception $e) {
            Log::error('Function getAllRegis: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }
    public function createRegistrationService (Request $request)
    {
        try {
            $user = Auth::user();
            $listServiceRegis = $request->input('serviceList', []);
            $idRegistration = $request->input('id_registration', '');

            $registration = Registration::query()->find($idRegistration);

            if(!$registration) {
                return $this->respondWithError( 'Can not find registration', 401);
            }

            $price = 0;

            foreach ($listServiceRegis as $serviceRegis) {
                $service = Service::query()->find($serviceRegis);
                if(!$service)
                    continue;
                $price += (float)$service->price;
                RegistrationService::create([
                    'registration_id' => $registration->id,
                    'service_id' => $service->id,
                    'additional_information' => $service->additional_information,
                    'uuid' => Uuid::uuid4(),
                    'service_name' => $service->service_name,
                    'patient_name' => $registration->user_name,
                    'patient_date' => $registration->user_date,
                    'patient_sex' => $registration->user_sex,
                    'driver_test' => $service->driver_test,
                    'status' => 0,
                ]);
            }

            $registration->update(['status' => 2, 'total_price' => $price, 'staff_id' => $user->id, 'time_take_test' => Carbon::now()]);

            return $this->respond([
                'success' => true,
            ], 200);

        } catch (\Exception $e) {
            Log::error('Function createRegistrationService: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }

}