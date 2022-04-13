<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'gender',
        'birthday',
        'firstname',
        'middlename',
        'lastname',
        'location',
        'mobile_no',
        'telephone_no',
        'language',
        'status',
        'website',
        'description',
        'avatar',
        'cover'
    ];

    protected $dates = ['birthday'];

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fullname()
    {

        $fullname = $this->firstname . " " .
            ($this->middlename ? $this->middlename . " " : '') .
            $this->lastname;

        return $fullname;
    }

    public function age()
    {
       return $this->birthday
                ? Carbon::parse($this->birthday)->diff(Carbon::now())->y
                : null;
    }

}
