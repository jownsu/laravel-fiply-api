<?php

namespace App\Models;

use App\Http\Requests\user\UploadResumeRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
            'valid_id',
            'valid_id_image_front',
            'valid_id_image_back',
            'resume',
            'status'
        ];

    const RESUME_PATH = 'resume';
    const VALID_ID_PATH = 'id';

    public function setResumeAttribute($value)
    {
        $this->attributes['resume'] = Str::remove(self::RESUME_PATH . '/' , $value);
    }

    public function resume()
    {
        return !empty($this->attributes['resume']) && Storage::disk('resume')->exists($this->attributes['resume'])
            ? Storage::disk('resume')->url($this->attributes['resume'])
            : null ;
    }

    public function setValidIdImageFrontAttribute($value)
    {
        $this->attributes['valid_id_image_front'] = Str::remove(self::VALID_ID_PATH . '/' , $value);
    }

    public function valid_id_image_front()
    {
        return !empty($this->attributes['valid_id_image_front']) && file_exists(public_path('files'  . DIRECTORY_SEPARATOR . self::VALID_ID_PATH . DIRECTORY_SEPARATOR . $this->attributes['valid_id_image_front']))
            ? url('files' . DIRECTORY_SEPARATOR . self::VALID_ID_PATH . DIRECTORY_SEPARATOR . $this->attributes['valid_id_image_front'])
            : null;
    }

    public function setValidIdImageBackAttribute($value)
    {
        $this->attributes['valid_id_image_back'] = Str::remove(self::VALID_ID_PATH . '/' , $value);
    }

    public function valid_id_image_back()
    {
        return !empty($this->attributes['valid_id_image_back']) && file_exists(public_path('files'  . DIRECTORY_SEPARATOR . self::VALID_ID_PATH . DIRECTORY_SEPARATOR . $this->attributes['valid_id_image_back']))
            ? url('files' . DIRECTORY_SEPARATOR . self::VALID_ID_PATH . DIRECTORY_SEPARATOR . $this->attributes['valid_id_image_back'])
            : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
