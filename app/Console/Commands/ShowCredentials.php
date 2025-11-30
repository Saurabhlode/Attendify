<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ShowCredentials extends Command
{
    protected $signature = 'attendify:credentials';
    protected $description = 'Display default login credentials';

    public function handle()
    {
        $this->info('=== Attendify Default Credentials ===');
        $this->newLine();
        
        $this->line('<fg=red>Admin Access:</>');
        $this->line('Email: admin@attendify.com');
        $this->line('Password: password');
        $this->newLine();
        
        $this->line('<fg=blue>Teacher Access:</>');
        $this->line('Email: john@attendify.com');
        $this->line('Password: password');
        $this->newLine();
        
        $this->line('<fg=green>Student Access:</>');
        $this->line('Email: alice@attendify.com');
        $this->line('Password: password');
        $this->newLine();
        
        $this->info('Visit: http://localhost:8000');
    }
}