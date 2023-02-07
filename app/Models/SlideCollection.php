<?php

namespace App\Models;

use App\Models\Traits\isSluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static create(array $array)
 */
class SlideCollection extends Model
{
    use HasFactory, isSluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'project_id',
        'order_num',
    ];

    protected $casts = [
        'order_num' => 'integer',
    ];

    protected $with = [
        "project",
        "slides"
    ];

    protected static function boot()
    {
        parent::boot();
        static::created(function ($slideCollection) {
            $slideCollection->slug = $slideCollection->generateSlugByField($slideCollection->name, 'project_id', $slideCollection->project_id);
            $slideCollection->save();
        });
    }

    /**
     * Get the project that owns the slide collection.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the slides for the slide collection.
     */
    public function slides(): HasMany
    {
        return $this->hasMany(Slide::class);
    }

}
