<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\User\UserResource;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\DeleteUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserWithRelationsResource;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('photos')->get();
        return UserResource::collection($users);
    }

    public function store(StoreUserRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = $request->user()->id;

        $user = User::updateOrCreate(['id' => request()->id], $validatedData);

        return new UserResource($user);
    }
    public function update(UpdateUserRequest $request, $id)
    {

        DB::beginTransaction();

        try {


            $items = User::findOrFail($id);

            $validatedData = $request->validated();
            if (isset($validatedData['theme'])) {
                $validatedData['theme'] = json_encode($validatedData['theme']);
            }

            $items->update($validatedData);

            ///   
            if ($request->hasFile('hero')) {
                $items->savePhotos($request->file('hero'), 'hero');
            }

            if ($request->hasFile('profile_image')) {
                if ($items->profile_image) {
                    Storage::delete('public/images/' . basename($items->profile_image));
                }
                $file = $request->file('profile_image');
                $timestamp = now()->format('YmdHis') . uniqid();
                $filename = "{$id}_{$timestamp}.{$file->getClientOriginalExtension()}";

                $path = $file->storeAs('public/photos', $filename);

                $imagePath = Storage::url($path);

                $items->profile_image = $imagePath;
                $items->save();
                // $validatedData['profile_image'] = $imagePath;
            }
            DB::commit();
            return new UserResource($items);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['ُFailed to update Error' => $e], 500);
        }

    }
    public function usersTheme(Request $request, $id)
    {
        DB::beginTransaction();
        try {

            $user = User::findOrFail($id);

            if ($request->has('theme')) {
                $user->theme = json_encode($request->input('theme'));
                $user->save();
            }

            DB::commit();
            return new UserResource($user);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['ُFailed to update Error' => $e], 500);
        }

    }



    public function show($id)
    {
        $user = User::with('photos')->findOrFail($id);
        return new UserResource($user);
    }

    public function showAll($userName)
    {
        $user = User::where('username', $userName)
            ->with([
                'experiences.photos', //done
                'academics.photos', //done
                'credentials.photos', // done
                'projects.photos', //
                'skills.photos',
                'contacts',
                'languages', // done
                'socials'
            ])
            ->first();

        if ($user) {
            return new UserWithRelationsResource($user);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }


    public function destroy(DeleteUserRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $ids = $data['id'];
            $items = User::whereIn('id', $ids)->get();
            foreach ($items as $item) {
                $item->deleteWithPhotos();
                Storage::delete('public/images/' . basename($item->profile_image));
            }
            $deletedCount = count($ids);
            DB::commit();
            return response()->json(['deleted' => $deletedCount], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to delete Items'], 500);
        }
    }
    public function updateThemeForAllUsers()
    {
        User::query()->update(['theme' => json_encode(new \stdClass())]);

        return response()->json(['message' => 'تم تحديث حقل theme لكل المستخدمين بنجاح.']);
    }
}
