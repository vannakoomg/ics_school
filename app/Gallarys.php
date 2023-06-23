<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Gallarys extends Model
{
    use HasFactory;
    public $table ="gallary";
    protected $fillable =[
        'title'
    ];
     public function images()
    {
    return $this->hasMany('App\image', 'folder_id');
    }
}