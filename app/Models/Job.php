<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Job extends Model
{
    use HasFactory;
    const IMG_PATH = 'logo';

    protected $fillable = [
        'title',
        'employment_type',
        'image',
        'company',
        'location',
        'position_level',
        'specialization',
        'job_responsibilities',
        'qualifications'
    ];


    public function setImageAttribute($value)
    {
        $this->attributes['image'] = Str::remove(self::IMG_PATH . '/',$value);
    }

    public function image()
    {
        return !empty($this->attributes['image']) && file_exists(public_path('img'  . DIRECTORY_SEPARATOR . self::IMG_PATH . DIRECTORY_SEPARATOR . $this->attributes['image']))
            ? url('img' . DIRECTORY_SEPARATOR . self::IMG_PATH . DIRECTORY_SEPARATOR . $this->attributes['image'])
            : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
