<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantPreference extends Model
{
    use HasFactory;

    protected $fillable = ['level_of_experience', 'field_of_expertise', 'location'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
