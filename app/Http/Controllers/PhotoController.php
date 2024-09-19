<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PhotoResource;
use App\Http\Requests\Photo\StorePhotoRequest;
use App\Http\Requests\Photo\UpdatePhotoRequest;

class PhotoController extends Controller
{
    public function index()
    {
        $Photos = Photo::all();
        return PhotoResource::collection($Photos);
    }

    public function store(StorePhotoRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['Photo_id'] = $request->Photo()->id;

        $Photo = Photo::updateOrCreate(['id' => request()->id], $validatedData);

        return new PhotoResource($Photo);
    }
    public function update(UpdatePhotoRequest $request, $id)
    {
        $validatedData = $request->validated();
        $Photo = Photo::findOrFail($id);

        if ($request->hasFile('profile_image')) {
            if ($Photo->profile_image) {
                Storage::delete('public/images/' . basename($Photo->profile_image));
            }
            $file = $request->file('profile_image');
            $timestamp = now()->format('YmdHis');
            $filename = "{$id}_{$timestamp}.{$file->getClientOriginalExtension()}";
            $path = $file->storeAs('public/images', $filename);
            $imagePath = Storage::url($path);
            $validatedData['profile_image'] = $imagePath;
        }

        $Photo->update($validatedData);

        return new PhotoResource($Photo);
    }

    public function show($id)
    {
        $Photo = Photo::findOrFail($id);
        return new PhotoResource($Photo);
    }

    public function destroy($photoId)
    {
        DB::beginTransaction();
        try {
            $photo = Photo::find($photoId);
            if (!$photo) {
                return response()->json(['message' => 'Photo not found.'], 404);
            }
            // بناء المسار  
            $filePath = str_replace('/storage', 'public', $photo->path);

            // حذف الصورة 
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
                $photo->delete();
            } else {
                $photo->delete();
                // return response()->json(['message' => 'File does not exist in storage.'], 404);
            }

            // حذف السجل من قاعدة البيانات
            // $photo->delete();

            // تأكيد التعديلات في قاعدة البيانات
            DB::commit();
            return response()->json(['message' => 'Photo deleted successfully.']);
        } catch (\Exception $e) {
            // إلغاء التعديلات في حالة حدوث استثناء
            DB::rollBack();
            return response()->json(['message' => 'An error occurred while deleting the photo.'], 500);
        }
    }
}
