<?php

namespace App\Http\Controllers;

use App\Models\Academics;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Academics\AcademicResource;
use App\Http\Requests\Academics\StoreAcademicsRequest;
use App\Http\Requests\Academics\DeleteAcademicsRequest;
use App\Http\Requests\Academics\UpdateAcademicsRequest;

class AcademicsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user) {
            $items = $user->academics()->with('photos')->get();
            return AcademicResource::collection($items);
        } else {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
    }

    public function show($id)
    {
        $items = Academics::with('photos')->findOrFail($id);
        return new AcademicResource($items);
    }

    public function store(StoreAcademicsRequest $request)
    {
        DB::beginTransaction();
        try {
            $items = Academics::create($request->validated());

            if ($request->hasFile('photos')) {
                $items->savePhotos($request->file('photos'));
            }
            DB::commit();
            return new AcademicResource($items);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e], 500);
        }
    }


    public function update(UpdateAcademicsRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $items = Academics::findOrFail($id);

            $items->update($request->validated());

            if ($request->hasFile('photos')) {
                $items->savePhotos($request->file('photos'));
            }

            DB::commit();
            return new AcademicResource($items);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['ُFailed to update Error' => $e], 500);
        }
    }

    public function destroy(DeleteAcademicsRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $ids = $data['id'];
            $items = Academics::whereIn('id', $ids)->get();
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
