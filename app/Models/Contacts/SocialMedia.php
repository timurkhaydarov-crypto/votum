<?php

namespace App\Models\Contacts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class SocialMedia extends Model
{
    use HasFactory;
    protected $fillable = ['platform', 'url', 'icon'];
}
