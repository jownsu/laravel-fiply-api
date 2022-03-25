<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalBackground extends Model
{
    use HasFactory;

    protected $fillable = [
        'university',
        'degree',
        'field_of_study',
        'starting_date',
        'completion_date'
    ];

    protected $dates = ['starting_date', 'completion_date'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
