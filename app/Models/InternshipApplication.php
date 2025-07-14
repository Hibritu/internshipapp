<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory; // ✅ Correct
use Illuminate\Database\Eloquent\Model;

class InternshipApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cover_letter',
        'category',
        'telegram_username',
        'portfolio_link',
        'cv_path',
        'type',
        'status',
    ];
public function interview()
{
    return $this->hasOne(Interview::class);
}

    // Relationship (optional, assuming you have User model)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
