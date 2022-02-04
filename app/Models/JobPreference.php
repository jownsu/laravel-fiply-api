<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_title',
        'location',
        'employment_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
