<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $domainame;
    public $value;
    public $ck;
    public $ns;
    public $giagoc;
    /**
     * Tạo một thể hiện mới của đối tượng Mailable.
     *
     * @param $user
     * @param $domainame
     * @param $value
     * @param $ck
     * @param $ns
     * @param $giagoc
     */
    public function __construct($user, $domainame, $value, $ck, $ns, $giagoc)
    {
        $this->user = $user;
        $this->domainame = $domainame;
        $this->value = $value;
        $this->ck = $ck;
        $this->ns = $ns;
        $this->giagoc = $giagoc;
    }

    /**
     * Xây dựng thông tin email.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Thanh toán thành công')
                    ->view('emails.order_confirmation');
    }
}
