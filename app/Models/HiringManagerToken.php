<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HiringManagerToken extends Model
{
    use HasFactory;
    protected $fillable = ['tokenable_type', 'tokenable_id', 'token'];

    public function tokenable()
    {
        return $this->morphTo('tokenable');
    }
}
