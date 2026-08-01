<?php

namespace App\Http\Controllers;
use App\Http\Requests\Contacts\PhoneRequest;
use App\Http\Requests\Contacts\EmailRequest;
use App\Http\Requests\Contacts\OperatingHoursRequest;
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
                'contacts' => $department->phones->map(fn (Phone $phone) => [
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
        return response()->json(['message' => 'messages.success.create', 'phone' => $phone], 201);
    }

    public function updatePhone(PhoneRequest $request, Phone $phone)
    {
        $validatedData = $request->validated();
        $phone->update($validatedData);
        return response()->json(['message' => 'messages.success.update', 'phone' => $phone]);
    }
    public function deletePhone(Phone $phone)
    {
        $phone->delete();
        return response()->json(['message' => 'messages.success.delete']);
    }

    public function emails()
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

    public function addEmail(EmailRequest $request)
    {
        $validatedData = $request->validated();
        $department = Department::findOrFail($validatedData['department_id']);
        $email = new Email([
            'email' => $validatedData['email'],
        ]);
        $department->emails()->save($email);
        return response()->json(['message' => 'messages.success.create', 'email' => $email], 201);
    }

    public function updateEmail(EmailRequest $request, Email $email)
    {
        $validatedData = $request->validated();
        $email->update($validatedData);
        return response()->json(['message' => 'messages.success.update', 'email' => $email]);
    }

    public function deleteEmail(Email $email)
    {
        $email->delete();
        return response()->json(['message' => 'messages.success.delete']);
    }

    public function operatingHours()
    {
        // Logic to retrieve operating hours contacts
        return Department::with('operatingHours')->has('operatingHours')->get()->map(function ($department) {
            return [
                'id' => $department->id,
                'name' => $department->department_name,
                'contacts' => $department->operatingHours->map(fn (OperatingHours $hours) => [
                    'id' => $hours->id,
                    'from' => $hours->from,
                    'to' => $hours->to,
                    'time' => $hours->time,
                ])->values(),
            ];
        });
    }

    public function addOperatingHours(OperatingHoursRequest $request)
    {
        $validatedData = $request->validated();
        $department = Department::findOrFail($validatedData['department_id']);
        $operatingHours = new OperatingHours([
            'from' => $validatedData['from'],
            'to' => $validatedData['to'],
            'time' => $validatedData['time'],
        ]);
        $department->operatingHours()->save($operatingHours);
        return response()->json(['message' => 'messages.success.create', 'operating_hours' => $operatingHours], 201);
    }

    public function updateOperatingHours(OperatingHoursRequest $request, OperatingHours $operating_hour)
    {
        $validatedData = $request->validated();
        $operating_hour->update($validatedData);
        return response()->json(['message' => 'messages.success.update', 'operating_hours' => $operating_hour]);
    }

    public function deleteOperatingHours(OperatingHours $operating_hour)
    {
        $operating_hour->delete();
        return response()->json(['message' => 'messages.success.delete']);
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
