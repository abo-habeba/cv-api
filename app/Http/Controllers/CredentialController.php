<?php

namespace App\Http\Controllers;

use App\Models\Credential;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Credential\CredentialResource;
use App\Http\Requests\Credential\StoreCredentialRequest;
use App\Http\Requests\Credential\DeleteCredentialRequest;
use App\Http\Requests\Credential\UpdateCredentialRequest;

class CredentialController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user) {
            $items = $user->credentials()->with('photos')->get();
            return CredentialResource::collection($items);
        } else {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
    }

    public function show($id)
    {
        $items = Credential::with('photos')->findOrFail($id);
        return new CredentialResource($items);
    }

    public function store(StoreCredentialRequest $request)
    {
        DB::beginTransaction();
        try {
            $items = Credential::create($request->validated());

            if ($request->hasFile('photos')) {
                $items->savePhotos($request->file('photos'));
            }
            DB::commit();
            return new CredentialResource($items);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e], 500);
        }
    }


    public function update(UpdateCredentialRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $items = Credential::findOrFail($id);

            $items->update($request->validated());

            if ($request->hasFile('photos')) {
                $items->savePhotos($request->file('photos'));
            }

            DB::commit();
            return new CredentialResource($items);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['ُFailed to update Error' => $e], 500);
        }
    }

    public function destroy(DeleteCredentialRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $ids = $data['id'];
            $items = Credential::whereIn('id', $ids)->get();
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
