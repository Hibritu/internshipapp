<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'internship_application_id',
        'interview_time',
        'interview_link',
        'notes',
    ];
public function internshipApplication()
{
    return $this->belongsTo(InternshipApplication::class);
}

    public function application()
    {
        return $this->belongsTo(InternshipApplication::class);
    }
}
