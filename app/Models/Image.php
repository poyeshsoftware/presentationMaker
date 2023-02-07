<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\URL;

/**
 * @property mixed id
 * @property mixed type
 * @property mixed address
 * @property mixed file_name
 * @property mixed format
 * @method static create(array $array)
 * @method static get()
 */
class Image extends Model
{
    use HasFactory;

    const SRC_SLIDES = "slides";

    const SRC_SLIDE_THUMBNAIL = "slideThumbnails";


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id',
        'parent_id',
        'type',
        'file_name',
        'address',
        'width',
        'height',
        'format',
        'alt',
    ];

    protected $casts = [
        'width' => 'integer',
        'height' => 'integer',
    ];


    public static function getAddress($image): ?string
    {
        if ($image != null) {
            return URL::to('/') . '/api/images/get' . $image->address;
        } else {
            return null;
        }
    }

    /**
     * Get the project that owns the image.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the parent image for the image.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'parent_id');
    }

    /**
     * Get the child images for the image.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Image::class, 'parent_id');
    }
}
