<?php

namespace App\Trait;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait GlobalTrait
{
    function translation($field)
    {
        return json_decode($field) ?: (object) ['ar' => null, 'en' => null];
    }


    /**
     * Save photos for the experience.
     *
     * @param  array  $photos
     * @return void
     */

    public function savePhotos(array $photos, $type = 'No Type')
    {
        foreach ($photos as $photo) {
            if ($photo instanceof UploadedFile) {
                $timestamp = now()->format('YmdHis') . uniqid();
                $filename = "{$this->id}_{$timestamp}.{$photo->getClientOriginalExtension()}";

                $path = $photo->storeAs("public/photos", $filename);

                $imagePath = Storage::url($path);

                $this->photos()->create([
                    'path' => $imagePath,
                    'type' => $type,
                    'imageable_type' => self::class,
                    'imageable_id' => $this->id,
                ]);
            }
        }
    }


    /**
     * Delete the experience and its associated photos.
     *
     * @return void
     */
    public function deleteWithPhotos()
    {
        foreach ($this->photos as $photo) {
            Storage::disk('public')->delete($photo->path);
        }
        $this->photos()->delete();
        $this->delete();
    }
}
