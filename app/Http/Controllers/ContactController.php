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
    public function update(UpdateContactRequest $request, $id)
    {
        // return $request->validated();
        $contact = Contact::findOrFail($id);
        $contact->update($request->validated());

        return new ContactResource($contact);
    }
    public function getUnreadContactsCount()
    {
        $user = auth()->user();

        $unreadCount = $user->contacts()->where('read', 0)->count();

        return response()->json(['unread_count' => $unreadCount]);
    }
    public function markAllAsUnread()
    {
        $user = auth()->user();

        $updatedCount = $user->contacts()->where('read', 0)->update(['read' => 1]);

        return response()->json(['updated_count' => $updatedCount]);
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
