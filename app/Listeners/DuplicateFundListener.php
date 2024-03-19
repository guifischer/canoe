<?php

namespace App\Listeners;

use App\Events\DuplicateFundEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DuplicateFundListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(): void
    {
        // @TODO: Implement handle() method. Not described in the task.
    }
}
