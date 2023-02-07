<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 * @property mixed mode
 * @property mixed dimension_value
 * @property mixed second_dimension_value
 */
class ImageDimension extends Model
{
    use HasFactory;

    const IMAGE_SCALE_BY_WIDTH = 0;
    const IMAGE_SCALE_BY_HEIGHT = 1;
    const IMAGE_SCALE_BY_BOTH = 2;

    protected $guarded = [];
}
