<?php

namespace App\Models;

use App\Models\Traits\isSluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static paginate()
 * @method static create(array $all)
 */
class Slide extends Model
{
    const TYPE_SLIDE = 0;
    const TYPE_POPUP = 1;
    const TYPE_FRAME = 2;

    use HasFactory, isSluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'slide_collection_id',
        'parent_id',
        'image_id',
        'slide_type',
        'order_num',
    ];

    protected $casts = [
        'slide_type' => 'integer',
        'order_num' => 'integer',
    ];

    protected $with = [
        'image',
        "references",
        "buttons",
        "children.image",
        "children.references",
        "children.buttons",
    ];

    protected static function boot()
    {
        parent::boot();
        static::created(function ($slide) {
            $slide->slug = $slide->generateSlugByField($slide->name, 'slide_collection_id', $slide->slide_collection_id);
            $slide->save();
        });
    }

    /**
     * Get the slide collection that owns the slide.
     */
    public function slideCollection(): BelongsTo
    {
        return $this->belongsTo(SlideCollection::class);
    }


    /**
     * Get the parent slide for the slide.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Get the child slides for the slide.
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Get the popup slides for the slide.
     */
    public function popups(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->where('slide_type', self::TYPE_POPUP);
    }

    /**
     * Get the frame slides for the slide.
     */
    public function frames(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->where('slide_type', self::TYPE_FRAME);
    }

    /**
     * Get the image for the slide.
     */
    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    /**
     * Get the buttons for the slide.
     */
    public function buttons(): HasMany
    {
        return $this->hasMany(Button::class);
    }

    /**
     * Get the references for the slide.
     */
    public function references(): HasMany
    {
        return $this->hasMany(Reference::class);
    }

}
