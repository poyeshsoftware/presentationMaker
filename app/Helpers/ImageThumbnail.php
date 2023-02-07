<?php


namespace App\Helpers;


use App\Models\Image;
use App\Models\ImageDimension;

class ImageThumbnail
{

    public ImageDimension $imageDimension;
    public Image $image;

    /**
     * ImageThumbnail constructor.
     * @param ImageDimension $imageDimension
     * @param Image $image
     */
    public function __construct(ImageDimension $imageDimension, Image $image)
    {
        $this->imageDimension = $imageDimension;
        $this->image = $image;
    }

}