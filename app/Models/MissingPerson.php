<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MissingPerson extends Model
{
    protected $fillable = ['name', 'description', 'photo_path', 'contact_phone', 'status'];
}
