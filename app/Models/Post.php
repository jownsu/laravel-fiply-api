<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'image'];
    //protected $attributes = ['content' => 'fucking default'];
    protected $hidden = ['pivot'];

    public function image()
    {
        return !empty($this->attributes['image']) && Storage::disk('post')->exists($this->attributes['image'])
            ? Storage::disk('post')->url($this->attributes['image'])
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

    public function userSavedPosts()
    {
        return $this->belongsToMany(User::class, 'saved_posts');
    }

    //scopes

    public function scopeOrderByUpVoted($query)
    {
        return $query->when(\request('q') == 'mostUpVoted', function ($q){
                    $q->orderBy('total_upVotes', 'DESC');
                })
                    ->when(\request('q') == 'leastUpVoted', function ($q){
                        $q->orderBy('total_upVotes', 'ASC');
                });
    }
}
