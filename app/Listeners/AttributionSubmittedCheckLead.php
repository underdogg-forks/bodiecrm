<?php

/**
 * Attribution data submitted, check if corresponding lead data exists
 */
namespace App\Listeners;

use App\Events\AttributionSubmitted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Lead;

class AttributionSubmittedCheckLead
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AttributionSubmitted  $event
     * @return Boolean
     */
    public function handle(AttributionSubmitted $event)
    {
        $lead = Lead::where('landing_page_id', $event->attribution->landing_page_id)
            ->where('email', $event->attribution->email)
            ->where('has_attribution', 0)
            ->orderBy('created_at', 'DESC')
            ->first();

        // If attribution entry is found already, set the lead id
        if ( ! is_null($lead) ) {
            $event->attribution->lead_id = $lead->id;
            $lead->has_attribution       = true;

            $event->attribution->save();
            $lead->save();
        }

        return true;
    }
}
