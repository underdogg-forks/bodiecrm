<?php

namespace App\Http\Middleware;

use Closure;

use Jenssegers\Agent\Agent;

class SpamMiddleware
{

    public function __construct()
    {
        $this->agent = new Agent();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( $this->agent->isRobot()
            || $request->header('user-agent') == ''
            || ! $request->header('user-agent') ) {
            return redirect($_SERVER['HTTP_REFERER']);
        }

        return $next($request);
    }
}
