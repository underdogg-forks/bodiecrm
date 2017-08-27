<?php
namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Collection;
use App\Lead;

class LogLeadActivity extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param Lead $lead
     * @param String $activity
     * @param Collection $collection
     * @return void
     */
    public function __construct(Lead $lead, $activity, Collection $collection = null)
    {
        $this->lead = $lead;
        $this->activity = $activity;
        $this->collection = $collection;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
