<?php
 
namespace App\Events;
 
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use App\Disposition;

 
class NewCommentNotification implements ShouldBroadcastNow
{
    use SerializesModels;
 
    public $disposition;
 
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Disposition $disposition)
    {
        $this->disposition = $disposition;
    }
 
    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {   
        return new Channel('dispositions');
    }
}