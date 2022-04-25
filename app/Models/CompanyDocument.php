<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CompanyDocument extends Model
{
    use HasFactory;

    protected $fillable = ['company_id_image', 'certificate', 'certificate_image', 'status'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function valid_id_image_front()
    {
        return !empty($this->attributes['valid_id_image_front']) && Storage::disk('company_id')->exists($this->attributes['valid_id_image_front'])
            ? Storage::disk('company_id')->url($this->attributes['valid_id_image_front'])
            : null;
    }

    public function valid_id_image_back()
    {
        return !empty($this->attributes['valid_id_image_back']) && Storage::disk('company_id')->exists($this->attributes['valid_id_image_back'])
            ? Storage::disk('company_id')->url($this->attributes['valid_id_image_back'])
            : null;
    }

    public function certificate_image()
    {
        return !empty($this->attributes['certificate_image']) && Storage::disk('company_certificate')->exists($this->attributes['certificate_image'])
            ? Storage::disk('company_certificate')->url($this->attributes['certificate_image'])
            : null ;
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
