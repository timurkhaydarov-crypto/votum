<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contacts\OperatingHoursRequest;
use App\Models\Contacts\OperatingHours;
use App\Models\Department;

class OperatingHourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(OperatingHoursRequest $request)
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

    /**
     * Display the specified resource.
     */
    public function show(OperatingHours $operating_hour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OperatingHoursRequest $request, OperatingHours $operating_hour)
    {
        $validatedData = $request->validated();
        $operating_hour->update($validatedData);

        return response()->json(['message' => 'messages.success.update', 'operating_hours' => $operating_hour]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OperatingHours $operating_hour)
    {
        $operating_hour->delete();

        return response()->json(['message' => 'messages.success.delete']);
    }
}
