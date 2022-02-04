<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'image'];

    const IMG_PATH = 'posts';

    public function setImageAttribute($value)
    {
        $this->attributes['image'] = Str::remove(self::IMG_PATH, $value);
    }

    public function image()
    {
        return file_exists(public_path('img/' . self::IMG_PATH . '/' . $this->image)) && !empty($this->image)
            ? url('img/' . self::IMG_PATH . $this->image)
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
}
