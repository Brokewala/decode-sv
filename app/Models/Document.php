<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Document extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'country',
        'format',
        'description',
        'price',
        'file_path',
        'preview_path',
        'is_verified',
        'downloads',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_verified' => 'boolean',
        'price' => 'integer',
        'downloads' => 'integer',
    ];

    /**
     * Get the user that uploaded the document.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the users that downloaded this document.
     */
    public function downloaders(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_documents')
                    ->withPivot('downloaded_at');
    }

    /**
     * Get the ratings for this document.
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Calculate the average rating for this document.
     */
    public function getAverageRatingAttribute(): float
    {
        return $this->ratings()->avg('rating') ?: 0;
    }

    /**
     * Check if the document is a PDF.
     */
    public function isPdf(): bool
    {
        return strtolower($this->format) === 'pdf';
    }

    /**
     * Check if the document is a Word or Excel file.
     */
    public function isOfficeDocument(): bool
    {
        $format = strtolower($this->format);
        return in_array($format, ['doc', 'docx', 'xls', 'xlsx']);
    }
}
