<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        /*'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],*/
        'App\Events\OrderShipped' => [
            'App\Listeners\SendShipmentNotification'
        ],
        'App\Events\AdminLogged' => [
            'App\Listeners\SendLoggedNotification'
        ],
        'App\Events\BrowseMerchant' => [
            'App\Listeners\RecordMerchantBrowseCounts'
        ],
        'App\Events\BrowseProduct' => [
            'App\Listeners\RecordProductBrowseCounts'
        ],
        'App\Events\SystemMessage' => [
            'App\Listeners\MessageNotification'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        //
    }

}
