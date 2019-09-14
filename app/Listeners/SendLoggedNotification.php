<?php

namespace App\Listeners;

use App\Events\AdminLogged;
use App\Repositories\interfaces\AdminLogRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendLoggedNotification
{
    protected $adminLogRepository;

    /**
     * Create the event listener.
     * @param $adminLogRepository
     * @return void
     */
    public function __construct(AdminLogRepository $adminLogRepository)
    {
        $this->adminLogRepository = $adminLogRepository;
    }

    /**
     * Handle the event.
     *
     * @param  AdminLogged $event
     * @return void
     */
    public function handle(AdminLogged $event)
    {
        $this->adminLogRepository->create($event->data);
    }
}
