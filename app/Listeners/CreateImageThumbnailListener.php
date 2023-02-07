<?php

namespace App\Listeners;

use App\Events\NewThumbnailEvent;
use App\Http\Controllers\ImageController;
use App\Models\Image;
use App\Models\ImageDimension;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as ImageIntervention;

class CreateImageThumbnailListener implements ShouldQueue
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
     * @param NewThumbnailEvent $event
     * @return void
     */
    public function handle(NewThumbnailEvent $event)
    {
        $img = ImageIntervention::make(file_get_contents(env("EXOSCALE_SPACES_ENDPOINT") . '/'
            . env('EXOSCALE_SPACES_BUCKET') . $event->imageThumbnail->image->address));


        $folder = ImageController::getImageSourceFolder($event->imageThumbnail->image->type);


        if ($event->imageThumbnail->imageDimension->mode == ImageDimension::IMAGE_SCALE_BY_WIDTH) {

            $thumbnailFileNameAddition = '_x_w' . $event->imageThumbnail->imageDimension->dimension_value . '.' . $event->imageThumbnail->image->format;

            $img->resize(
                $event->imageThumbnail->imageDimension->dimension_value,
                null,
                function ($constraint) {
                    $constraint->aspectRatio();
                }
            );


        } elseif ($event->imageThumbnail->imageDimension->mode == ImageDimension::IMAGE_SCALE_BY_HEIGHT) {

            $thumbnailFileNameAddition = '_x_h' . $event->imageThumbnail->imageDimension->dimension_value . '.' . $event->imageThumbnail->image->format;

            $img->resize(
                null,
                $event->imageThumbnail->imageDimension->dimension_value,
                function ($constraint) {
                    $constraint->aspectRatio();
                }
            );

        } else {

            $thumbnailFileNameAddition = '_w'
                . $event->imageThumbnail->imageDimension->dimension_value . '_x_h'
                . $event->imageThumbnail->imageDimension->second_dimension_value
                . '.' . $event->imageThumbnail->image->format;

            if (($img->height() * ($event->imageThumbnail->imageDimension->dimension_value / $img->width())) < $event->imageThumbnail->imageDimension->second_dimension_value) {
                // scale by height
                $img->resize(
                    null,
                    $event->imageThumbnail->imageDimension->second_dimension_value,
                    function ($constraint) {
                        $constraint->aspectRatio();
                    }
                );

            } else {
                //scale by width
                $img->resize(
                    $event->imageThumbnail->imageDimension->dimension_value,
                    null,
                    function ($constraint) {
                        $constraint->aspectRatio();
                    }
                );

            }

        }


        $fileExtension = substr(strrchr($event->imageThumbnail->image->file_name, '.'), 1);
        $fileName = str_replace(["." . $fileExtension], [""], $event->imageThumbnail->image->file_name);
        $imageName = $folder . '/' . $fileName . $thumbnailFileNameAddition;

        $s3 = Storage::disk('exo');
        $filePath = "/" . $imageName;

        $s3->put($filePath, $img->encode(), 'public');
    }


}
