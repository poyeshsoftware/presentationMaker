<?php

namespace App\Events;

use App\Helpers\ImageThumbnail;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewThumbnailEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ImageThumbnail $imageThumbnail;

    /**
     * Create a new event instance.
     *
     * @param ImageThumbnail $imageThumbnail
     */
    public function __construct(ImageThumbnail $imageThumbnail)
    {
        $this->imageThumbnail = $imageThumbnail;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('new-thumbnail');
    }
}
