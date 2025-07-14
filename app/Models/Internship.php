<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    use HasFactory;

    // Optional: define fillable columns if you want mass assignment
    protected $fillable = [
        'title', 'description', 'requirements', 'location', 'duration', // adjust columns
    ];
}
