<?php

namespace App\Listeners;

use App\Events\HostingSuccessful;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\HostingNotification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendHostingNotification
{
    /**
     * Handle the event.
     *
     * @param  HostingSuccessful  $event
     * @return void
     */
    public function handle(HostingSuccessful $event)
    {
        $hosting = $event->hosting;
        $user = User::find($hosting->user_id);

        Mail::to($user->email)->send(new HostingNotification($hosting, $user));
    }
}
