<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DegreeCategory extends Model
{
    use HasFactory;

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
