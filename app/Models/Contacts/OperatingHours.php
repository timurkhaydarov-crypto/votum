<?php

namespace App\Models\Contacts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class OperatingHours extends Model
{
    use HasFactory;
    protected $fillable = ['operating_hours'];
}
