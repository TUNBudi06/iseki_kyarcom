<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TractorListKyarcom extends Model
{
    protected $table = 'tractor_list_kyarcoms';

    protected $fillable = [
        'instruction',
        'tractor_name',
        'date',
    ];
}
