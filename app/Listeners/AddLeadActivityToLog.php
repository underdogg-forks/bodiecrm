<?php
namespace App\Listeners;

use App\Events\LogLeadActivity;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;
use App\Lead_Log;

class AddLeadActivityToLog
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
     * @param  LogLeadActivity $event
     * @return void
     */
    public function handle(LogLeadActivity $event)
    {
        $log = $event->lead->log;
        Lead_Log::create([
            'lead_id' => $event->lead->id,
            'user_id' => Auth::id(),
            'activity' => $event->activity
        ]);
        return true;
    }
}
