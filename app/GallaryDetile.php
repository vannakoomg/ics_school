<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GallaryDetile extends Model
{
    use HasFactory;
    public $table = 'gallary_detail';
    protected $fillable = [
        'gallary_id',
        'filename',
    ];
}