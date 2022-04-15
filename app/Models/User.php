<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_public',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pivot'
    ];

    const SEMI_VERIFIED = 1;
    const VERIFIED = 2;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public static function boot()
    {
        parent::boot();
        self::creating(function ($user) {
            $user->id = IdGenerator::generate(['table' => 'users', 'length' => 11, 'prefix' => date('Yis')]);
        });
    }

    public function account_level()
    {

        $account_lvl = 0;

        if(( $this->educationalBackgrounds()->exists() || $this->experiences()->exists() ) && ($this->document()->exists() && !is_null($this->document->resume))){
            $account_lvl++;
            if(
                $this->document()->exists() &&
                $this->document->status &&
                !is_null($this->document->valid_id_image_front) &&
                !is_null($this->document->valid_id_image_back)
            ){
                $account_lvl++;
            }
        }

        switch ($account_lvl)
        {
            case self::SEMI_VERIFIED:
                $account_level_str = 'Semi-Verified';
                break;
            case self::VERIFIED:
                $account_level_str = 'Verified';
                break;
            default:
                $account_level_str = 'Basic User';
        }

        return [
                "account_level"     => $account_lvl,
                "account_level_str" => $account_level_str
            ];
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function document()
    {
        return $this->hasOne(Document::class);
    }

    public function jobPreference()
    {
        return $this->hasOne(JobPreference::class);
    }

    public function educationalBackgrounds()
    {
        return $this->hasMany(EducationalBackground::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function savedPosts()
    {
        return $this->belongsToMany(Post::class, 'saved_posts');
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function postUpVotes()
    {
        return $this->belongsToMany(Post::class);
    }

    public function jobsApplied()
    {
        return $this->belongsToMany(Job::class, 'applied_jobs');
    }

    public function jobsSaved()
    {
        return $this->belongsToMany(Job::class, 'saved_jobs');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'follow_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'follow_id', 'user_id');
    }

    public function followPendings()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'follow_id');
    }

    public function followerRequests()
    {
        return $this->belongsToMany(User::class, 'follows', 'follow_id', 'user_id');
    }

    //SCOPES

    public function scopeWithSearch($query)
    {
        if(!is_null(\request('search'))){
            $query->whereHas('profile', function($q){
                return $q->where('firstname',  'LIKE','%' . \request('search') . '%')
                        ->orWhere('middlename',  'LIKE','%' . \request('search') . '%')
                        ->orWhere('lastname',  'LIKE','%' . \request('search') . '%');
            });
        }
        return $query;
    }

    public function scopeWithFollowingInfo($query){
        $myId = auth()->id();

        $query->withCount([
            'following AS is_follower' => function($q) use($myId) {
                $q->where('follow_id', $myId)->where('accepted', true);
            },
            'following AS is_follower_pending' => function($q) use($myId) {
                $q->where('follow_id', $myId)->where('accepted', false);
            }
        ]);

        return $query;
    }

    public function scopeWithFollowerInfo($query){
        $myId = auth()->id();

        $query->withCount([
            'followers AS is_following' => function($q) use($myId) {
                $q->where('user_id', $myId)->where('accepted', true);
            },
            'followers AS is_following_pending' => function($q) use($myId) {
                $q->where('user_id', $myId)->where('accepted', false);
            }
        ]);

        return $query;
    }

    public function scopeWithFollowCount($query){
        return $query->withCount([
            'following' => function($q){
                $q->where('accepted', 1);
            },
            'followers' => function($q){
                $q->where('accepted', 1);
            }]);
    }

    public function scopeIsFollowing($query){
        return $query->withCount(['followers AS is_following' => function ($q) {
            $q->where('user_id', auth()->id())->where('accepted', true);
        }]);
    }

    public function scopeWithFilterQueries($query)
    {
        return $query->when(request('q') == 'notFollowing', function ($q) {
            $q->whereDoesntHave('followers', function($q){
                $q->where('user_id', auth()->id());
            });
        });


        /*            ->whereDoesntHave('followers', function($q){
                $q->where('user_id', auth()->id());
            })*/
    }
}
