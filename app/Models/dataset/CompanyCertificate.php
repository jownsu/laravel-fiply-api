<?php

namespace App\Models\dataset;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyCertificate extends Model
{
    protected $fillable = ['name'];
    use HasFactory;
}
