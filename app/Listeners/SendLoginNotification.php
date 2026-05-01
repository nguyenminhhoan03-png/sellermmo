<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\LoginNotification;
use Illuminate\Support\Facades\Mail;

class SendLoginNotification
{
    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user;


        // Gửi email
        Mail::to($user->email)->send(new LoginNotification($user));
    }
}