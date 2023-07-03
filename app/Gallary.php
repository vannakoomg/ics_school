<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallary extends Model
{
    use HasFactory;
    public $table = 'gallary';
    protected $appends = ['full_image','date','time'];
    protected $fillable = [
        'name',
        'description',
    ];
}