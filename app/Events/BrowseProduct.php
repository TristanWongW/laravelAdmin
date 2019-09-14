<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BrowseProduct
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $product_id;
    public $type; // 1-浏览量 2-成交量
    public $num;

    /**
     * Create a new event instance.
     * @param $type 统计类型
     * @param $product_id 商品id
     * @param $num
     * @return void
     */
    public function __construct($product_id, $type, $num = 1)
    {
        $this->product_id = $product_id;
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
