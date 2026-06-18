<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreatorProfile extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'synthetic_voice_used' => 'boolean',
        'synthetic_persona_used' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The public verification badge label, if this page earns one and badges
     * are shown publicly.
     */
    public function verificationBadge(): ?string
    {
        $badges = config('rejoice.verification_badges', []);

        return $badges[$this->verification_status] ?? null;
    }

    public function isPublished(): bool
    {
        return $this->review_status === 'Approved';
    }
}
