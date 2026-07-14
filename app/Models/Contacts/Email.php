<?php

namespace App\Models\Contacts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Department;

class Email extends Model
{
    use HasFactory;
    protected $fillable = ['email', 'department_id'];
    
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
