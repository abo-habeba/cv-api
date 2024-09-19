<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Experience\ExperienceResource;
use App\Http\Requests\Experience\StoreExperienceRequest;
use App\Http\Requests\Experience\DeleteExperienceRequest;
use App\Http\Requests\Experience\UpdateExperienceRequest;

class ExperienceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user) {
            $items = $user->experiences()->with('photos')->get();
            return ExperienceResource::collection($items);
        } else {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
    }

    public function show($id)
    {
        $experience = Experience::with('photos')->findOrFail($id);
        return new ExperienceResource($experience);
    }

    public function store(StoreExperienceRequest $request)
    {
        DB::beginTransaction();
        try {
            $experience = Experience::create($request->validated());

            if ($request->hasFile('photos')) {
                $experience->savePhotos($request->file('photos'));
            }
            DB::commit();
            return new ExperienceResource($experience);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e], 500);
        }
    }


    public function update(UpdateExperienceRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $experience = Experience::findOrFail($id);

            $experience->update($request->validated());

            if ($request->hasFile('photos')) {
                $experience->savePhotos($request->file('photos'));
            }

            DB::commit();
            return new ExperienceResource($experience);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update experience'], 500);
        }
    }

    public function destroy(DeleteExperienceRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $ids = $data['id'];
            $items = Experience::whereIn('id', $ids)->get();
            foreach ($items as $item) {
                $item->deleteWithPhotos();
            }
            $deletedCount = count($ids);
            DB::commit();
            return response()->json(['deleted' => $deletedCount], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to delete Items'], 500);
        }
    }
}
