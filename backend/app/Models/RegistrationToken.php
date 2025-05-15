<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class RegistrationToken extends Model
{

    protected $table = 'registration_tokens';
    
    protected $fillable = ['email', 'token', 'expires_at', 'role', 'max_uses'];

    public function remainingUses(): ?int
    {
        if (is_null($this->max_uses)) {
            return null;
        }
        return max(0, $this->max_uses - $this->uses_count);
    }

    public function canUse(): bool
    {
        return !$this->isExpired()
            && (is_null($this->max_uses) || $this->uses_count < $this->max_uses);
    }

    public function isExpired(): bool
    {
        return $this->expires_at->lt(now());
    }

    public function incrementUses(): void
    {
        $this->increment('uses_count');
    }
}
