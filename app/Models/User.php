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

        if(( $this->educationalBackgrounds()->exists() || $this->experiences()->exists() )&& !is_null($this->document->resume)){
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



        return $account_lvl;
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

    public function follows()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'follow_id')
            ->withPivot('accepted');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'follow_id', 'user_id')
            ->withPivot('accepted');
    }
}
