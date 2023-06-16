<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Firebasetoken extends Model
{
    use HasFactory;

    public $table = 'firebasetokens';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'firebasekey',
        'model',
        'os_type'
    ];

    public function users(){
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
