<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffTransactionLog extends Model
{
    use HasFactory;

    protected $table = 'staff_transaction_log';
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
