<?php

namespace App\Http\Controllers;
use App\Http\Requests\Contacts\PhoneRequest;
use App\Models\Contacts\Email;
use App\Models\Contacts\OperatingHours;
use App\Models\Contacts\Phone;
use App\Models\Contacts\SocialMedia;
use App\Models\Department;

class ContactsController extends Controller
{
    public function phones()
    {
        // Logic to retrieve phone contacts
        return Department::with('phones')->has('phones')->get()->map(function ($department) {
            return [
                'id' => $department->id,
                'name' => $department->department_name,
                'phones' => $department->phones->map(fn (Phone $phone) => [
                    'id' => $phone->id,
                    'phone' => $phone->phone,
                ])->values(),
            ];
        });
    }
    public function addPhone(PhoneRequest $request)
    {
        $validatedData = $request->validated();
        $department = Department::findOrFail($validatedData['department_id']);
        $phone = new Phone([
            'phone' => $validatedData['phone'],
        ]);
        $department->phones()->save($phone);
        return response()->json(['message' => 'Phone added successfully', 'phone' => $phone], 201);
    }

    public function updatePhone(PhoneRequest $request, Phone $phone)
    {
        $validatedData = $request->validated();
        $phone->update($validatedData);
        return response()->json(['message' => 'Phone updated successfully', 'phone' => $phone]);
    }
    public function deletePhone(Phone $phone)
    {
        $phone->delete();
        return response()->json(['message' => 'Phone deleted successfully']);
    }

    public function emails()
    {
        // Logic to retrieve email contacts
        return Department::with('emails')->has('emails')->get()->map(function ($department) {
            return [
                'name' => $department->department_name,
                'emails' => $department->emails->pluck('email')->toArray(),
            ];
        });
    }

    public function operatingHours()
    {
        // Logic to retrieve operating hours contacts
        return Department::with('operatingHours')->has('operatingHours')->get()->map(function ($department) {
            return [
                'name' => $department->department_name,
                'operating_hours' => $department->operatingHours->map(fn (OperatingHours $hours) => [
                    'from' => $hours->from,
                    'to' => $hours->to,
                    'time' => $hours->time,
                ])->values(),
            ];
        });
    }

    public function socialMedia()
    {
        // Logic to retrieve social media contacts
        return SocialMedia::all();
    }
    public function departments()
    {
        // Logic to retrieve departments
        return Department::all();
    }
}
