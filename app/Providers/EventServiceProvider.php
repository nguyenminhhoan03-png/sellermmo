<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login; // Sự kiện đăng nhập
use App\Listeners\SendLoginNotification; // Listener gửi email thông báo
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Danh sách các sự kiện và listener tương ứng.
     *
     * @var array
     */
    protected $listen = [
        // Sự kiện đăng nhập
        Login::class => [
            SendLoginNotification::class, // Listener gửi email thông báo
        ],

    ];

    /**
     * Đăng ký các sự kiện và listener.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}