<?php

namespace App\Http\Controllers;

use App\Models\Social;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Socials\SocialResource;
use App\Http\Requests\Socials\DeleteSocialRequest;
use App\Http\Requests\Socials\StoreSocialRequest;
use App\Http\Requests\Socials\UpdateSocialRequest;

class SocialController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $itmes = $user->socials;
        return SocialResource::collection($itmes);
    }

    public function store(StoreSocialRequest $request)
    {

        $social = Social::create($request->validated());

        return new SocialResource($social);
    }

    public function show(Social $social)
    {
        return new SocialResource($social);
    }

    public function update(UpdateSocialRequest $request, $id)
    {
        $social = Social::findOrFail($id);
        $social->update($request->validated());

        return new SocialResource($social);
    }

    public function destroy(DeleteSocialRequest $request)
    {
        $data = $request->validated();
        $itmes = Social::whereIn('id', $data['id'])->delete();
        return $itmes;
    }
}
