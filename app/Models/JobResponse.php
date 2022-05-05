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

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
