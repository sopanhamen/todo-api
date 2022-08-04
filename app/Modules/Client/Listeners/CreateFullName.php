<?php

namespace App\Modules\Client\Listeners;

use App\Modules\Client\Events\ClientCreating;

class CreateFullName
{
    public function __construct()
    {
        # code...
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ClientCreating $event)
    {
        return $event->client->full_name = $event->client->first_name . ' ' . $event->client->last_name;
    }
}
