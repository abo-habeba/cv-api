<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Contact\ContactResource;
use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Requests\Contact\UpdateContactRequest;
use App\Http\Requests\Contact\DeleteContactsRequest;

class ContactController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $itmes = $user->contacts;
        return ContactResource::collection($itmes);
    }

    public function store(StoreContactRequest $request)
    {
        $validatedData = $request->validated();
        // $validatedData['user_id'] = $request->user()->id;
        $itme = Contact::updateOrCreate(['id' => request()->id], $validatedData);

        return new ContactResource($itme);
    }

    public function show(Contact $contact)
    {
        return new ContactResource($contact);
    }

    public function destroy(DeleteContactsRequest $request)
    {
        $data = $request->validated();
        $itmes = Contact::whereIn('id', $data['id'])->delete();

        return $itmes;
    }
}
