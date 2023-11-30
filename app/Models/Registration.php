<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $table = 'registration';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function registration_services()
    {
        return $this->hasMany(RegistrationService::class, 'registration_id', 'id');
    }

    public function patient()
    {
        return $this->hasOne(User::class, 'id', 'patient_id');
    }
}
