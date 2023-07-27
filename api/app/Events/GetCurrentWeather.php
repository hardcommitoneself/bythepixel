<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GetCurrentWeather
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * User Id
     *
     * @var int
     */
    public int $user_id;

    /**
     * Weather data
     *
     * @var mixed
     */
    public mixed $data;

    /**
     * Create a new event instance.
     */
    public function __construct(int $userId, mixed $data)
    {
        $this->user_id = $userId;
        $this->data = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $channel_name = "user-$this->user_id-current";

        return [
            new PrivateChannel($channel_name),
        ];
    }

    public function broadcastAs()
    {
        return 'current-weather-ready';
    }
}