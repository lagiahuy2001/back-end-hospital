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

class AuthControllers extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function searchService($search)
    {
        try {
            return $this->respond([
                'success' => true,
                'service' => Service::query()
                    ->where('id', 'like', "%{$search}%")
                    ->orWhere('service_name', 'like', "%{$search}%")
                    ->orderBy('id', 'desc')
                    ->get(),
            ], 200);
        } catch (\Exception $e) {
            Log::error('Function searchService: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }
    public function searchRegis($search)
    {
        try {
            return $this->respond([
                'success' => true,
                'registration' => Registration::query()
                    ->where('id', 'like', "%{$search}%")
                    ->orWhere('user_phone', 'like', "%{$search}%")
                    ->orderBy('id', 'desc')
                    ->get(),
            ], 200);
        } catch (\Exception $e) {
            Log::error('Function searchRegis: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }
    public function fillRegisByType($type)
    {
        try {
            return $this->respond([
                'success' => true,
                'registration' => Registration::query()->where('status', $type)->orderBy('id', 'desc')->get(),
            ], 200);
        } catch (\Exception $e) {
            Log::error('Function fillRegisByType: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }
    public function detailRegistration($id)
    {
        try {
            return $this->respond([
                'success' => true,
                'registration' => Registration::query()->find($id),
            ], 200);

        } catch (\Exception $e) {
            Log::error('Function detailRegistration: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }
    public function listRegistration()
    {
        try {
            return $this->respond([
                'success' => true,
                'registration' => Registration::query()->orderBy('id', 'desc')->get(),
            ], 200);

        } catch (\Exception $e) {
            Log::error('Function listRegistration: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }

    public function getDetailRegistrationService($id)
    {
        try {
            if(!Auth::check())
                return $this->respondWithError('Unauthorized', 404);

            $registrationService = RegistrationService::query()->find($id);

            return $this->respond([
                'success' => true,
                'registration_service' => $registrationService,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Function getDetailRegistrationService: ' . $e->getMessage());
            return $this->respondWithError($e->getMessage(), 500);
        }
    }

    public function cancelRegis($id)
    {
        Registration::where('id', $id)->update([
            'status' => 5
        ]);

        return true;
    }
}