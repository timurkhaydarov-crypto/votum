<?php

namespace App\Http\Controllers;

use App\Models\Department;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function departments()
    {
        // Logic to retrieve departments
        return Department::all();
    }
}
