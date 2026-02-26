<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DateKyarCom extends Model
{
    protected $table = 'date_kyar_com';
    protected $fillable = [
        'name',
        'date',
    ];
}
