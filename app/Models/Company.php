<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class  Company extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'registration_no', 'telephone_no', 'location', 'avatar', 'cover', 'bio'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function companyDocument()
    {
        return $this->hasOne(CompanyDocument::class);
    }

    public function applicantPreference()
    {
        return $this->hasOne(ApplicantPreference::class);
    }

    public function hiringManagers()
    {
        return $this->hasMany(HiringManager::class);
    }

    public function avatar()
    {
        return !empty($this->attributes['avatar']) && Storage::disk('avatar')->exists($this->attributes['avatar'])
            ? Storage::disk('avatar')->url($this->attributes['avatar'])
            : Storage::disk('placeholder')->url('avatar.png');
    }

    public function cover()
    {
        return !empty($this->attributes['cover']) && Storage::disk('cover')->exists($this->attributes['cover'])
            ? Storage::disk('cover')->url($this->attributes['cover'])
            : Storage::disk('placeholder')->url('cover.png');
    }




}
