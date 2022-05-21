<?php

namespace App\Models\location;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    protected $keyType = 'string';
    protected $table = 'location_regions';

    public function provinces(){
        return $this->hasMany(Province::class, 'region_id');
    }

    public function cities(){
        return $this->hasManyThrough(
                 City::class,
                Province::class,
                'region_id',
              'province_id');
    }
}
