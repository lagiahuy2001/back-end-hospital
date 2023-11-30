<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoordinatorTransactionLog extends Model
{
    use HasFactory;

    protected $table = 'coordinator_transaction_log';
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
