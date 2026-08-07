<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contacts\PhoneRequest;
use App\Models\Contacts\Phone;
use App\Models\Department;

class PhoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Logic to retrieve phone contacts
        return Department::with('phones')->has('phones')->get()->map(function ($department) {
            return [
                'id' => $department->id,
                'name' => $department->department_name,
                'contacts' => $department->phones->map(fn (Phone $phone) => [
                    'id' => $phone->id,
                    'phone' => $phone->phone,
                ])->values(),
            ];
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PhoneRequest $request)
    {
        $validatedData = $request->validated();
        $department = Department::findOrFail($validatedData['department_id']);
        $phone = new Phone([
            'phone' => $validatedData['phone'],
        ]);
        $department->phones()->save($phone);

        return response()->json(['message' => 'messages.success.create', 'phone' => $phone], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Phone $phone)
    {
        return response()->json(['phone' => $phone]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PhoneRequest $request, Phone $phone)
    {
        $validatedData = $request->validated();
        $phone->update($validatedData);

        return response()->json(['message' => 'messages.success.update', 'phone' => $phone]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Phone $phone)
    {
        $phone->delete();

        return response()->json(['message' => 'messages.success.delete']);
    }
}
