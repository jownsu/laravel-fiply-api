<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HiringManager extends Model
{
    use HasFactory;
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'contact_no',
        'username',
        'avatar',
        'code',
    ];

    protected $hidden = [
        'code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function avatar()
    {
        return !empty($this->attributes['avatar']) && Storage::disk('avatar')->exists($this->attributes['avatar'])
            ? Storage::disk('avatar')->url($this->attributes['avatar'])
            : Storage::disk('placeholder')->url('avatar.png');
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function token()
    {
        return $this->morphOne(HiringManagerToken::class, 'tokenable');
    }

}
