<?php

namespace App\Models\Contacts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class OperatingHours extends Model
{
    use HasFactory;
    
    protected $fillable = ['from', 'to', 'time', 'department_id'];
    
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
