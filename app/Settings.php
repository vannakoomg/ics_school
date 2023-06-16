<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Settings extends Model
{
  

    public $table = 'settings';

    protected $dates = [
        'created_at',
        'updated_at',

    ];


}
