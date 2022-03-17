<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    const IMG_PATH = 'avatar';
    const COVER_PATH = 'cover';


    public function setAvatarAttribute($value)
    {
        $this->attributes['avatar'] = Str::remove(self::IMG_PATH . '/' , $value);
    }

    public function setCoverAttribute($value)
    {
        $this->attributes['cover'] = Str::remove(self::COVER_PATH . '/' , $value);
    }
    public function avatar()
    {
        return !empty($this->attributes['avatar']) && file_exists(public_path('img'  . DIRECTORY_SEPARATOR . self::IMG_PATH . DIRECTORY_SEPARATOR . $this->attributes['avatar']))
            ? url('img' . DIRECTORY_SEPARATOR . self::IMG_PATH . DIRECTORY_SEPARATOR . $this->attributes['avatar'])
            : url('img'. DIRECTORY_SEPARATOR . 'avatar-placeholder1.png');
    }

    public function cover()
    {
        return !empty($this->attributes['cover']) && file_exists(public_path('img'  . DIRECTORY_SEPARATOR . self::COVER_PATH . DIRECTORY_SEPARATOR . $this->attributes['cover']))
            ? url('img' . DIRECTORY_SEPARATOR . self::COVER_PATH . DIRECTORY_SEPARATOR . $this->attributes['cover'])
            : url('img'. DIRECTORY_SEPARATOR . 'cover-placeholder.png');
    }

    public function getBirthdayAttribute($value)
    {
        return $value ? (new Carbon($value))->format('F d, Y') : null;
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
