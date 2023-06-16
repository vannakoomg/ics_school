<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

class HomeworkResultAttachment extends Model
{
    // use SoftDeletes;

    public $table = 'homework_result_attachments';

    protected $dates = [
        'created_at',
        'updated_at',
        // 'deleted_at',
    ];

    protected $appends = ['link'];

    protected $fillable = [
        'homework_result_id',
        'filename',
        'path',
      
    ];

    public function homeworkresult()
    {
        return $this->belongsTo(HomeworkResult::class,'homework_result_id');
    }

    // public function getFilesizeAttribute(){
        
    //     $fileSize =  Storage::exists($this->path) ? Storage::size($this->path):0;
    //     return $fileSize;
    // }
    public function getImageAttribute(){
        
    }

    public function getLinkAttribute(){
        return asset('storage/'.$this->path);
    }
    
    
  
}
