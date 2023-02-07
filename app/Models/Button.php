<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static paginate()
 * @method static create(mixed $validated)
 */
class Button extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slide_id',
        'left',
        'top',
        'width',
        'height',
        'type',
        'link_slide_id',
    ];

    protected $casts = [
        'left' => 'integer',
        'top' => 'integer',
        'width' => 'integer',
        'height' => 'integer',
        'type' => 'integer',
    ];


    /**
     * Get the slide that owns the button.
     */
    public function slide(): BelongsTo
    {
        return $this->belongsTo(Slide::class);
    }

    /**
     * Get the linked slide for the button.
     */
    public function linkSlide(): BelongsTo
    {
        return $this->belongsTo(Slide::class, 'link_slide_id');
    }
}
