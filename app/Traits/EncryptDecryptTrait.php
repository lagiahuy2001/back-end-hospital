<?php
namespace App\Traits;

use Illuminate\Support\Facades\Crypt;

trait EncryptDecryptTrait
{
    public function encryptData($data, $key)
    {
        return Crypt::encrypt($data, false, ['key' => $key]);
    }

    public function decryptData($encryptedData, $key)
    {
        return Crypt::decrypt($encryptedData, false, ['key' => $key]);
    }
}