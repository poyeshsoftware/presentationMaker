<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

/**
 * @method static whereName($name)
 * @method static whereSlug($param)
 */
trait isSluggable
{
    private function generateSlug($name): array|string|null
    {
        if (static::whereSlug($slug = Str::slug($name))->exists()) {
            $max = static::whereName($name)->latest('id')->skip(1)->value('slug');
            if (isset($max[-1]) && is_numeric($max[-1])) {
                return preg_replace_callback('/(\d+)$/', function ($matches) {
                    return $matches[1] + 1;
                }, $max);
            }
            return "{$slug}-2";
        }
        return $slug;
    }

    private function generateSlugByField($name, $field, $value): array|string|null
    {
        if (static::whereSlug($slug = Str::slug($name))->where($field, $value)->exists()
            && static::whereSlug($slug = Str::slug($name))->where($field, $value)->count() > 1) {
            $max = static::where($field, $value)->whereName($name)->latest('id')->skip(1)->value('slug');
            if (isset($max[-1]) && is_numeric($max[-1])) {
                return preg_replace_callback('/(\d+)$/', function ($matches) {
                    return $matches[1] + 1;
                }, $max);
            }
            return "{$slug}-2";
        }
        return $slug;
    }

}
