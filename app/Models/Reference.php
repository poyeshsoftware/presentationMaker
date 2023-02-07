<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $all)
 * @method static paginate()
 */
class Reference extends Model
{
    use HasFactory;

    const TYPE_TEXT = 0;
    const TYPE_IMAGE = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slide_id', 'order_num', 'type', 'prefix', 'text',
    ];

    protected $casts = [
        'order_num' => 'integer',
        'type' => 'integer',
    ];

    protected $attributes = [
        'text' => '',
    ];

    /**
     * Get the slide that owns the reference.
     */
    public function slide(): BelongsTo
    {
        return $this->belongsTo(Slide::class);
    }

}
