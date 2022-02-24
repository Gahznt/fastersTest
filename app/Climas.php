<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Climas extends Model
{
    protected $table = 'clima';
    public $timestamps = false;

    protected $fillable = [
        'city',
        'temp',
        'insert_at'
    ];
}
