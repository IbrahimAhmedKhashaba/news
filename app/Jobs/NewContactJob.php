<?php

namespace App\Jobs;

use App\Models\Admin;
use App\Notifications\NewContactNotify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class NewContactJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private $contact;
    public function __construct($contact)
    {
        //
        $this->contact = $contact;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $admins = Admin::whereHas('authorization', function ($query) {
            $query->where('permissions', 'LIKE' , '%contacts%');
        })->get();

        Notification::send($admins, new NewContactNotify($this->contact));
        
    }
}
