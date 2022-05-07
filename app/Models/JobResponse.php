<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobResponse extends Model
{
    use HasFactory;
    protected $table = 'job_responses';
    protected $fillable = ['applied_job_id', 'question_id', 'answer'];
    public $incrementing = true;

    public function setAnswerAttribute($value)
    {
        if(is_array($value)){
            $this->attributes['answer'] = json_encode($value);
        }else{
            $this->attributes['answer'] = $value;
        }
    }

    public function getAnswerAttribute($value)
    {
        json_decode($value);

        if(json_last_error() === JSON_ERROR_NONE){
            return json_decode($value);
        }
        return $value;
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
