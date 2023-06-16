<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnouncementClass extends Model
{
    use HasFactory;

    public $table ='announcement_class';

    protected $fillable = ['announcement_id','class_id'];

}      