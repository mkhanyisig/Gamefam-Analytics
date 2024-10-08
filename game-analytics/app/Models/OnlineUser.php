<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineUser extends Model
{
    use HasFactory;

    protected $table = 'online_users'; 

    protected $fillable = [
        'count',
        'retrieved_at',
    ];

    protected $dates = ['retrieved_at'];
}
