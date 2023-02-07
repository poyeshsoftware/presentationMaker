<?php

namespace App\Models;

use App\Models\Traits\isSluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static create(array $array)
 * @property mixed $id
 * @property mixed $user_id
 * @property mixed $project_user_id
 * @property mixed $parent_id
 */
class Project extends Model
{
    use HasFactory, isSluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'slug',
    ];

    protected $with = [
        "user",
        "projectUser"
    ];

    protected static function boot()
    {
        parent::boot();
        static::created(function ($project) {
            $project->slug = $project->generateSlug($project->name);
            $project->save();
        });
    }

    /**
     * Get the user that created the project.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Return users who can access the project.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get the user that owns the project.
     */
    public function projectUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'project_user_id');
    }

    /**
     * Get the slide collections for the project.
     */
    public function slideCollections(): HasMany
    {
        return $this->hasMany(SlideCollection::class);
    }

    /**
     * Get the images for the project.
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    /**
     * Get the slides for the project.
     */
    public function slides(): HasManyThrough
    {
        return $this->hasManyThrough(Slide::class, SlideCollection::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }
}
