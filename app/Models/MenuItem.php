<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MenuItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'menu_category_id', 'order_num', 'link_slide_id', 'type', 'style',
    ];

    /**
     * Get the menu category that owns the menu item.
     */
    public function menu_category(): BelongsTo
    {
        return $this->belongsTo(MenuCategory::class);
    }

    /**
     * Get the slide that the menu item links to, if any.
     */
    public function link_slide(): BelongsTo
    {
        return $this->belongsTo(Slide::class);
    }
}
