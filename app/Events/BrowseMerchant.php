<?php

namespace App\Events;

use App\Entities\MerchantCount;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BrowseMerchant
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $merchant_id;
    public $type; // 1-浏览量 2-成交量
    public $num;

    /**
     * Create a new event instance.
     * @param $type 统计类型
     * @param $merchant_id 商户id
     * @param $num 增加或删除的数量
     * @return void
     */
    public function __construct($merchant_id, $type, $num = 1)
    {
        $this->merchant_id = $merchant_id;
        $this->type = $type;
        $this->num = intval($num);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
