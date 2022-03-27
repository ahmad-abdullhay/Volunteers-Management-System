<?php

namespace App\Repositories\Eloquent;

use App\Models\TempMedia;
use App\Repositories\MediaRepositoryInterface;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaRepository extends BaseRepository implements MediaRepositoryInterface
{
    /**
     * Create a new instance from tag repository.
     * @constructor
     * @param TempMedia $model
     */
    public function __construct(TempMedia $model)
    {
        parent::__construct($model);
    }

    public function uploadMedia($payload)
    {
        //Create TempModel => (To Assign new Media to it).
        $tempMedia = TempMedia::create();

        //Assign All Files in payload into this tempMedia Model.
        foreach ($payload as $file){
            $tempMedia->addMedia($file)->toMediaCollection('default');
        }

        return $tempMedia->where('id', $tempMedia->id)->with(['media'])->get();
    }

    public function deleteMedia($mediaId)
    {
        //Get Media Record in Database.
        $media = Media::find($mediaId);

        //Resolving Model that has this Media (ex: Product / Category / User).
        $modelClass = resolve($media->model_type);

        //Get Model Object That has this Media.
        $model = $modelClass::where('id', $media->model_id)->first();

        //Delete Media Database record & Delete the media from filesystem.
        $model->deleteMedia($media->id);
    }

    public function uploadMediaFromUrl($urls)
    {
        //Create TempModel => (To Assign new Media to it).
        $tempMedia = TempMedia::create();

        foreach ($urls as $url)
            $tempMedia
                ->addMediaFromUrl($url)
                ->toMediaCollection();

        return $tempMedia->where('id', $tempMedia->id)->with(['media'])->get();
    }
}
