<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DomainSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $domainame;
    public $value;
    public $ns;
    /**
     * Tạo một thể hiện mới của đối tượng Mailable.
     * @param $user
     * @param $domainame
     * @param $value
     * @param $ns
     */
    public function __construct($user, $domainame, $value, $ns)
    {
        $this->user = $user;
        $this->domainame = $domainame;
        $this->value = $value;
        $this->ns = $ns;
    }

    /**
     * Xây dựng thông tin email.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Thông Báo Về Tên Miền')
                    ->view('emails.domain_success');
    }
}
