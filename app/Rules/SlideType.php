<?php

namespace App\Rules;

use App\Models\Slide;
use Closure;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class SlideType implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure(string): PotentiallyTranslatedString $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail): void
    {
        $value = intval($value);
        if (Slide::TYPE_SLIDE === $value || Slide::TYPE_POPUP === $value || Slide::TYPE_FRAME === $value) {
            return;
        } else {
            $fail('wrong slide type. Available types: slide=0, popup=1, frame=2');
        }
    }
}
