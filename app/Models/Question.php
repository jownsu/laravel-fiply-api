<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'question', 'options'];
    protected $casts = ['options' => 'array'];

    const PARAGRAPH = 1;
    const RADIO_BUTTON = 2;
    const CHECKBOX = 3;

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
