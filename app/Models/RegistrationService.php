<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationService extends Model
{
    use HasFactory;

    protected $table = 'registration_service';
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
