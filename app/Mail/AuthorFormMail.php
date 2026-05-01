<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuthorFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    /**
     * Tạo một thể hiện mới của đối tượng Mailable.
     *
     * @param $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Xây dựng thông tin email.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Thông Báo Đơn Đăng Ký Người Bán Hàng')
                    ->view('emails.author_forms');
    }
}
