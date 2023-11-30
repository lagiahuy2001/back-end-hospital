<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public const ADMIN = 'ADMIN';
    public const COORDINATOR = 'COORDINATOR';
    public const TESTER = 'TESTER';
    public const STAFF = 'STAFF';
    public const PATIENT = 'PATIENT';
    public function getRoles()
    {
        return self::all();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
