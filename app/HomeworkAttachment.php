<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

class HomeworkAttachment extends Model
{
    // use SoftDeletes;

    public $table = 'homework_attachments';

    protected $appends = ['link'];
    
    protected $dates = [
        'created_at',
        'updated_at',
        // 'deleted_at',
    ];

    protected $fillable = [
        'homework_id',
        'filename',
        'path',
      
    ];

    public function homeworks()
    {
        return $this->belongsTo(Homework::class);
    }

    public function getFilesizeAttribute(){
        
        $fileSize =  Storage::exists($this->path) ? Storage::size($this->path):0;
        return $fileSize;
    }

    public function getLinkAttribute(){
        return asset('storage/'.$this->path);
    }
    
    
  
}
