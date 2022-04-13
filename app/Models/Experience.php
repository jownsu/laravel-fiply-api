<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_title',
        'employment_type',
        'company',
        'location',
        'starting_date',
        'completion_date'
    ];

    protected $dates = ['starting_date', 'completion_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
