<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RowCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {}

    public function broadcastOn(): Channel
    {
        return new Channel('created');
    }

    public function broadcastAs(): string
    {
        return 'rows';
    }

    public function broadcastWith(): array
    {
        return [
            'message' => __('events.rows.created')
        ];
    }
}
