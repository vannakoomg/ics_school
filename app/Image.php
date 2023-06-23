<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    public $table ="image";
    protected $fillable =[
        'image',
        'folder_id'
    ];
    public function product()
{
  return $this->belongsTo('App\Gallarys', 'folder_id');
}
}