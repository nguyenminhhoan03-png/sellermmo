<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\PurchasedHosting;

class HostingSuccessful
{
    use Dispatchable, SerializesModels;

    public $hosting;

    /**
     * Tạo một instance sự kiện mới.
     *
     * @param  PurchasedHosting  $hosting
     * @return void
     */
    public function __construct(PurchasedHosting $hosting)
    {
        $this->hosting = $hosting;
    }
}

