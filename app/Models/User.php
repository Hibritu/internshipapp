<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\HasDatabaseNotifications;
use Laravel\Sanctum\HasApiTokens; 
 // Add this import for Sanctum tokens

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasDatabaseNotifications;

    protected $fillable = ['name', 'email', 'password', 'role'];

    // Hide these attributes when serializing
    protected $hidden = ['password', 'remember_token'];

    // Cast attributes to native types
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationship: User has many internship applications
    public function internshipApplications()
    {
        return $this->hasMany(InternshipApplication::class);
    }
}
