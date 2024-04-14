<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Speaker extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'social_media' => 'array',
    ];

    protected $fillable = [
        'name',
        'surname',
        'resume',
        'title',
        'company',
        'image_url',
        'social_media'
    ];

    public function talks(): BelongsToMany
    {
        return $this->belongsToMany(Talk::class, 'talk_speaker');
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->name} {$this->surname}";
    }
}
