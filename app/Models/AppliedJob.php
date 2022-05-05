<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AppliedJob extends Pivot
{
    use HasFactory;
    protected $table = 'applied_jobs';
    protected $hidden = [''];
    public $incrementing = true;


    protected $fillable = ['user_id', 'job_id', 'applied_job_id', 'id'];

    public function jobResponses()
    {
        return $this->hasMany(JobResponse::class, 'applied_job_id', 'id' );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
