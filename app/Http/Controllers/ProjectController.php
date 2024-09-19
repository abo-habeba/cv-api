<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Projects\ProjectResource;
use App\Http\Requests\Projects\StoreProjectRequest;
use App\Http\Requests\Projects\DeleteProjectRequest;
use App\Http\Requests\Projects\UpdateProjectRequest;

class ProjectController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        if ($user) {
            $items = $user->Projects()->with('photos')->get();
            return ProjectResource::collection($items);
        } else {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
    }

    public function show($id)
    {
        $items = Project::with('photos')->findOrFail($id);
        return new ProjectResource($items);
    }

    public function store(StoreProjectRequest $request)
    {
        DB::beginTransaction();
        try {
            $items = Project::create($request->validated());

            if ($request->hasFile('photos')) {
                $items->savePhotos($request->file('photos'));
            }
            DB::commit();
            return new ProjectResource($items);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e], 500);
        }
    }


    public function update(UpdateProjectRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $items = Project::findOrFail($id);

            $items->update($request->validated());

            if ($request->hasFile('photos')) {
                $items->savePhotos($request->file('photos'));
            }

            DB::commit();
            return new ProjectResource($items);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['ُFailed to update Error' => $e], 500);
        }
    }

    public function destroy(DeleteProjectRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $ids = $data['id'];
            $items = Project::whereIn('id', $ids)->get();
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
