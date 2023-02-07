<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetImageRequest;

use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as ImageIntervention;

/**
 * @group Get Image and Thumbnails endpoints
 */
class GetImageController extends Controller
{

    /**
     * Get Image and Thumbnails endpoints
     * @response status=200 scenario="File found and will be redirected"
     * @response status=401 scenario="Not found error"
     */
    public function __invoke(Project $project, $imageType, GetImageRequest $request)
    {
        $fileName = $imageType . '/' . substr(strrchr($request->url(), '/'), 1);
        $fileExtension = substr(strrchr($fileName, '.'), 1);
        $fileName = str_replace(["." . $fileExtension], [""], $fileName);
        $fileName = str_replace([$imageType . "/"], [""], $fileName);

        $originalFileUrl = "public/" . $project->id . '/'
            . $imageType . '/' . $fileName . '.' . $fileExtension;

        $thumbnailUrl = "public/" . $project->id . '/'
            . $imageType . '/' . $fileName;


        $httpCode = 0;

        $isImageScale = true;
        $imageScaleDownType = 'none';
        $thumbnailFileNameAddition = '';

        if ($request->has('width') && $request->has('height')) {
            $imageScaleDownType = 'both';
            $thumbnailFileNameAddition = '_w'
                . $request->width . '_x_h'
                . $request->height
                . '.webp'; //. $fileExtension;
            $thumbnailUrl = $thumbnailUrl . $thumbnailFileNameAddition;

        } elseif ($request->has('width')) {
            $imageScaleDownType = 'width';
            $thumbnailFileNameAddition = '_x_w' . $request->width . '.webp';// . $fileExtension;
            $thumbnailUrl = $thumbnailUrl . $thumbnailFileNameAddition;

        } elseif ($request->has('height')) {
            $imageScaleDownType = 'height';
            $thumbnailFileNameAddition = '_x_h' . $request->height . '.webp'; //. $fileExtension
            $thumbnailUrl = $thumbnailUrl . $thumbnailFileNameAddition;

        } else {
            $isImageScale = false;
        }


        if ($isImageScale) {
            //$httpCode = self::checkFileExistence($thumbnailUrl);

            //if ($httpCode != 200) {
            if (!Storage::disk("local")->exists($thumbnailUrl)) {
                // image doesn't exist
                //$httpCode = self::checkFileExistence($originalFileUrl);

                if (Storage::disk("local")->exists($originalFileUrl)) {
                    // get the image
                    //$img = ImageIntervention::make(
                    //    file_get_contents($originalFileUrl)
                    //);

                    $img = ImageIntervention::make(
                        Storage::disk("local")->get($originalFileUrl)
                    );

                    // create the thumbnail
                    if ($imageScaleDownType == 'both') {
                        if (($img->height() * ($request->width / $img->width())) < $request->height) {
                            // scale by height
                            $img->resize(
                                null,
                                $request->height,
                                function ($constraint) {
                                    $constraint->aspectRatio();
                                }
                            );

                        } else {
                            //scale by width
                            $img->resize(
                                $request->width,
                                null,
                                function ($constraint) {
                                    $constraint->aspectRatio();
                                }
                            );

                        }
                    } elseif ($imageScaleDownType == 'width') {
                        $img->resize(
                            $request->width,
                            null,
                            function ($constraint) {
                                $constraint->aspectRatio();
                            }
                        );
                    } elseif ($imageScaleDownType == 'height') {
                        $img->resize(
                            null,
                            $request->height,
                            function ($constraint) {
                                $constraint->aspectRatio();
                            }
                        );
                    }

                    $imageName = $fileName . $thumbnailFileNameAddition;

                    $s3 = Storage::disk('local');
                    $filePath = "public/" . $project->id . "/" . $imageType . "/" . $imageName;

                    $s3->put($filePath, $img->encode('webp'), 'public');
                }
            }

        } else {
            $thumbnailUrl = $thumbnailUrl . '.' . $fileExtension;
        }

        if (Storage::disk("local")->exists($thumbnailUrl)) {
            return redirect(Storage::disk("local")->url($thumbnailUrl));
        } else {
            return response()->json([
                'message' => 'File not found',
            ], 401);
        }

        /**
         * if ($httpCode == 200) {
         * header('Location: ' . $thumbnailUrl);
         * exit;
         * } else {
         * return response()->json([
         * 'error' => 404,
         * 'message' => 'Not Found!',
         * ], 404);
         * }
         */
    }


    /**
     * @param string $thumbnailUrl
     * @return int
     *
     * public static function checkFileExistence(string $thumbnailUrl): int
     * {
     * $ch = curl_init();
     * curl_setopt($ch, CURLOPT_URL, $thumbnailUrl);
     * curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     * curl_setopt($ch, CURLOPT_NOBODY, true);
     * curl_setopt($ch, CURLOPT_HEADER, true);
     *
     * $response = curl_exec($ch);
     * if (curl_errno($ch)) {
     * echo 'Error:' . curl_error($ch);
     * exit();
     * }
     * curl_close($ch);
     *
     * return (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
     * }
     *
     */

}
