<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'image'];
    protected $attributes = ['content' => 'fucking default'];
    protected $hidden = ['pivot'];
    const IMG_PATH = 'posts';

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

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function userUpVotes()
    {
        return $this->belongsToMany(User::class);
    }
}
