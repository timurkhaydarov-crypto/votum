<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contacts\SocialMediaRequest;
use App\Models\Contacts\SocialMedia;

class SocialMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return SocialMedia::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SocialMediaRequest $request)
    {
        $validatedData = $request->validated();
        $socialMedia = new SocialMedia([
            'icon' => $validatedData['icon'],
            'platform' => $validatedData['platform'],
            'url' => $validatedData['url'],
        ]);
        $socialMedia->save();

        return response()->json(['message' => 'messages.success.create', 'social_media' => $socialMedia], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(SocialMedia $social_medium)
    {
        return $social_medium;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SocialMediaRequest $request, SocialMedia $social_medium)
    {
        $validatedData = $request->validated();
        $social_medium->update($validatedData);

        return response()->json(['message' => 'messages.success.update', 'social_media' => $social_medium]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SocialMedia $social_medium)
    {
        $social_medium->delete();

        return response()->json(['message' => 'messages.success.delete']);
    }
}
