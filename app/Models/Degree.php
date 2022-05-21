<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    protected $fillable = ['name', 'degree_category_id'];
    use HasFactory;

    public function degreeCategory(){
        return $this->belongsTo(DegreeCategory::class);
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
