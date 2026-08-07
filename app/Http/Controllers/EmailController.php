<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contacts\EmailRequest;
use App\Models\Contacts\Email;
use App\Models\Department;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Logic to retrieve email contacts
        return Department::with('emails')->has('emails')->get()->map(function ($department) {
            return [
                'id' => $department->id,
                'name' => $department->department_name,
                'contacts' => $department->emails->map(fn ($email) => [
                    'id' => $email->id,
                    'email' => $email->email,
                ])->values(),
            ];
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmailRequest $request)
    {
        $validatedData = $request->validated();
        $department = Department::findOrFail($validatedData['department_id']);
        $email = new Email([
            'email' => $validatedData['email'],
        ]);
        $department->emails()->save($email);

        return response()->json(['message' => 'messages.success.create', 'email' => $email], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmailRequest $request, Email $email)
    {
        $validatedData = $request->validated();
        $email->update($validatedData);

        return response()->json(['message' => 'messages.success.update', 'email' => $email]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Email $email)
    {
        $email->delete();

        return response()->json(['message' => 'messages.success.delete']);
    }
}
