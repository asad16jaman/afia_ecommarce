<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fastiv extends Model
{
    //
    protected $table = 'tbl_events';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guarded = [];
    protected $casts = [
        'products' => 'array',
    ];

}
