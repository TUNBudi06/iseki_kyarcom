<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KyarComUnitFix extends Model
{
    protected $fillable = [
        'tractor_name',
        'set_hitam',
        'set_merah',
        'hood_merah',
        'set_biru',
        'hood_biru',
        'set_grey',
    ];
}
