<?php
/**
 * Lead submitted, check if corresponding attribution data exists
 */
namespace App\Listeners;

use App\Events\LeadSubmitted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Attribution;

class LeadSubmittedCheckAttribution
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  LeadSubmitted $event
     * @return Boolean
     */
    public function handle(LeadSubmitted $event)
    {
        // Query for attribution entry if available
        $attribution = Attribution::where('landing_page_id', $event->lead->landing_page_id)
            ->where('email', $event->lead->email)
            ->where('lead_id', 0)
            ->orderBy('created_at', 'DESC')
            ->first();
        // If attribution entry is found already, set the lead id
        if (!is_null($attribution)) {
            $attribution->lead_id = $event->lead->id;
            $event->lead->has_attribution = true;
            $attribution->save();
            $event->lead->save();

        }
        return true;
    }
}
