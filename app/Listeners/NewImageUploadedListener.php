<?php

namespace App\Listeners;

use App\Events\NewImageUploadedEvent;
use App\Events\NewThumbnailEvent;
use App\Helpers\ImageThumbnail;
use App\Models\ImageDimension;

class NewImageUploadedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param NewImageUploadedEvent $event
     * @return void
     */
    public function handle(NewImageUploadedEvent $event)
    {
        $dimensionImages = ImageDimension::where('type', $event->image->type)->get();

        foreach ($dimensionImages as $dimension) {
            NewThumbnailEvent::dispatch(new ImageThumbnail($dimension, $event->image));
        }
    }
}
