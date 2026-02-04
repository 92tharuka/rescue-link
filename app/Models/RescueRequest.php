<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RescueRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'phone', 
        'type', 
        'description', 
        'latitude', 
        'longitude', 
        'status'
    ];

    // Automatically assign priority based on incident type
    public static function boot() {
        parent::boot();
        static::creating(function ($model) {
            $model->priority = match($model->type) {
                'Medical', 'Trapped' => 1, // High Priority
                'Flood', 'Fire'     => 2, // Medium
                default              => 3  // Low
            };
        });
    }
}
