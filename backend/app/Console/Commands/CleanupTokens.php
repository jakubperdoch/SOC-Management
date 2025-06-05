<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RegistrationToken;

class CleanupTokens extends Command
{
    protected $signature = 'tokens:cleanup';
    protected $description = 'Delete expired or fully-used registration tokens';

    public function handle()
    {
        $deleted = RegistrationToken::where('expires_at', '<', now())
            ->orWhereColumn('uses_count', '>=', 'max_uses')
            ->delete();

        $this->info("Cleaned up {$deleted} token(s).");
    }
}
