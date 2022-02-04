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
        'avatar'
    ];

    protected $dates = ['birthday'];

    const IMG_PATH = 'avatar';

    public function setAvatarAttribute($value)
    {
        $this->attributes['avatar'] = Str::remove(self::IMG_PATH, $value);
    }

    public function getAvatarAttribute($value)
    {
        return file_exists(public_path('img/' . self::IMG_PATH . '/' . $value)) && !empty($value)
            ? url('img/' . self::IMG_PATH . '/' . $value)
            : url('img/avatar-placeholder1.png');
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
