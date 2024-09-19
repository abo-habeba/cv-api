<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Skills\SkillResource;
use App\Http\Requests\Skills\StoreSkillRequest;
use App\Http\Requests\Skills\DeleteSkillRequest;
use App\Http\Requests\Skills\UpdateSkillRequest;

class SkillController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user) {
            $items = $user->Skills()->with('photos')->get();
            return SkillResource::collection($items);
        } else {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
    }

    public function show($id)
    {
        $items = Skill::with('photos')->findOrFail($id);
        return new SkillResource($items);
    }

    public function store(StoreSkillRequest $request)
    {
        DB::beginTransaction();
        try {
            $items = Skill::create($request->validated());

            if ($request->hasFile('photos')) {
                $items->savePhotos($request->file('photos'));
            }
            DB::commit();
            return new SkillResource($items);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e], 500);
        }
    }


    public function update(UpdateSkillRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $items = Skill::findOrFail($id);

            $items->update($request->validated());

            if ($request->hasFile('photos')) {
                $items->savePhotos($request->file('photos'));
            }

            DB::commit();
            return new SkillResource($items);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['ُFailed to update Error' => $e], 500);
        }
    }

    public function destroy(DeleteSkillRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $ids = $data['id'];
            $items = Skill::whereIn('id', $ids)->get();
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
