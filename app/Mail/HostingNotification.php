<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\HostingPackages;

class HostingNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $hosting;
    public $user;


    public function __construct($hosting, $user)
    {
        $this->hosting = $hosting;
        $this->user = $user;       

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Xác nhận thanh toán thành công')
                    ->markdown('emails.hosting_success')
                    ->with([
                        'hosting' => $this->hosting,
                        'user' => $this->user,
                    ]);
    }
}