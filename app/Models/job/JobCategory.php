<?php

namespace App\Models\job;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    use HasFactory;

    public function jobTitles(){
        return $this->hasMany(JobTitle::class);
    }

    public function scopeSearchLimit($query)
    {
        if(!is_null(\request('search'))){
            $query->where('name', 'LIKE','%' . \request('search') . '%');
        }

        if(!is_null(\request('limit')) && is_numeric(\request('limit'))){
            $query->limit(\request('limit'));
        }

        return $query;
    }
}
