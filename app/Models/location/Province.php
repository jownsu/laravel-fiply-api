<?php

namespace App\Models\location;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    protected $table = 'location_provinces';

    public function region(){
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function cities(){
        return $this->hasMany(City::class, 'province_id');
    }

}
