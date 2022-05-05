<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'employment_type',
        'location',
        'position_level',
        'specialization',
        'job_responsibilities',
        'qualifications'
    ];

    protected $hidden = ['pivot'];

    const IMG_PATH = 'logo';


    public function setImageAttribute($value)
    {
        $this->attributes['image'] = Str::remove(self::IMG_PATH . '/',$value);
    }

    public function image()
    {
        return !empty($this->attributes['image']) && Storage::disk('logo')->exists($this->attributes['image'])
            ? Storage::disk('logo')->url($this->attributes['image'])
            : Storage::disk('placeholder')->url('logo.png');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userAppliedJobs()
    {
        return $this->belongsToMany(User::class, 'applied_jobs')
            ->withPivot('id')
            ->withTimestamps()
            ->using(AppliedJob::class);
    }

    public function userSavedJobs()
    {
        return $this->belongsToMany(User::class, 'saved_jobs');
    }

    public function hiringManager()
    {
        return $this->belongsTo(HiringManager::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'applied_jobs')->withTimestamps()->withPivot('id');
    }

    //SCOPES

    public function scopeWithUserApplied($query){
        return $query->with(['userAppliedJobs' => function($q){
            return $q->where('user_id', auth()->id())->select('user_id');
        },]);
    }

    public function scopeWithUserSaved($query){
        return $query->with(['userSavedJobs' => function($q){
            return $q->where('user_id', auth()->id())->select('user_id');
        }]);
    }


}
