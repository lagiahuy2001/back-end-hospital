<?php
namespace App\Http\Controllers\HospitalControllers\Auth;

use App\Http\Controllers\HospitalControllers\Controller;
use App\Models\Registration;
use App\Models\RegistrationService;
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

class TesterController extends Controller
{
    public function __construct()
    {
        $this->middleware('roleTester');
    }

    public function detailRegistrationService($id)
    {
        return $this->respond([
            'success' => true,
            'registration' => RegistrationService::query()->find($id),
        ], 200);
    }
    public function updateResultRegistrationService(Request $request)
    {
        try {
            $idRegistrationService = $request->input('id_registration_service', 0);

            $registrationService = RegistrationService::query()->find($idRegistrationService);

            if(!$registrationService){
                return $this->respondWithError('Can not find RegistrationService', 401);
            }

            $additional_information = $request->input('additional_information', []);
            $user = Auth::user();

            $registrationService->update([
                'additional_information' => json_encode($additional_information),
                'tester_id' => $user->id,
                'advise' => $request->input('advise', ''),
                'status' => 1,
            ]);


            $regis = Registration::query()->find($registrationService->registration_id);
            $regis->status = 3;
            $regis->save();

            return true;
        } catch (\Exception $e) {
            Log::error('Function updateResultRegistrationService: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }

    public function listRegistrationService()
    {
        return $this->respond([
            'success' => true,
            'registration_service' => RegistrationService::query()->where('status', 0)->orderBy('id', 'desc')->get(),
        ], 200);
    }
}