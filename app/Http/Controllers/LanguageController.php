<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Language\LanguageResource;
use App\Http\Requests\Language\StoreLanguageRequest;
use App\Http\Requests\Language\DeleteLanguageRequest;
use App\Http\Requests\Language\UpdateLanguageRequest;

class LanguageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $itmes = $user->languages;
        return LanguageResource::collection($itmes);
    }

    public function store(StoreLanguageRequest $request)
    {

        $language = Language::create($request->validated());

        return new LanguageResource($language);
    }

    public function show(Language $language)
    {
        return new LanguageResource($language);
    }

    public function update(UpdateLanguageRequest $request, $id)
    {
        $language = Language::findOrFail($id);
        $language->update($request->validated());

        return new LanguageResource($language);
    }

    public function destroy(DeleteLanguageRequest $request)
    {
        $data = $request->validated();
        $itmes = Language::whereIn('id',$data['id'])->delete();
        return $itmes;
    }
}
