<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Contacts\Phone;
use App\Models\Contacts\Email;
use App\Models\Contacts\OperatingHours;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;
    protected $fillable = ['department_name'];

    public function phones():HasMany
    {
        return $this->hasMany(Phone::class);
    }
    public function emails():HasMany
    {
        return $this->hasMany(Email::class);
    }    
    public function operatingHours(): HasMany
    {
        return $this->hasMany(OperatingHours::class);
    }
}
