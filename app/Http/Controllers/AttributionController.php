<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Jenssegers\Agent\Agent;
use App\Attribution;
use App\Events\AttributionSubmitted;
use App\Http\Requests\Attribution\PixelRequest;

class AttributionController extends Controller
{

    public function __construct()
    {
        $this->agent = new Agent();
    }

    /**
     * Attribution pixel
     *
     * @param  PixelRequest $request
     * @return Image
     */
    public function store(PixelRequest $request)
    {
        $this->agent->setUserAgent($request->header('user-agent'));
        ignore_user_abort(true);
        // Turn off gzip compression
        if (function_exists('apache_setenv')) {
            apache_setenv('no-gzip', 1);
        }
        ini_set('zlib.output_compression', 0);
        // Turn on output buffering if necessary
        if (ob_get_level() == 0) {
            ob_start();
        }
        // Remove any content encoding
        header('Content-encoding: none', true);
        if (!$request->isMethod('post')) {
            // Create attribution entry
            $attribution = Attribution::create([
                'landing_page_id' => $request->get('lp'),
                'email' => $request->get('em'),
                'tracking_id' => $request->get('t'),
                'converting_source' => $request->get('cs'),
                'converting_medium' => $request->get('cm'),
                'converting_keyword' => $request->get('ck'),
                'converting_content' => $request->get('ccn'),
                'converting_campaign' => $request->get('cc'),
                'converting_landing_page' => $request->get('cl'),
                'converting_timestamp' => Carbon::createFromTimeStamp($request->get('ct'))->toDateTimeString(),
                'original_source' => $request->get('os'),
                'original_medium' => $request->get('om'),
                'original_keyword' => $request->get('ok'),
                'original_content' => $request->get('ocn'),
                'original_campaign' => $request->get('oc'),
                'original_landing_page' => $request->get('ol'),
                'original_timestamp' => Carbon::createFromTimeStamp($request->get('ot'))->toDateTimeString(),
                'refer_url' => $request->get('r'),
                'platform' => $this->agent->platform(),
                'device' => $this->agent->device(),
                'browser' => $this->agent->browser(),
                'version' => $this->agent->version($this->agent->browser())
            ]);
            // Link attribution entry to lead
            \Event::fire(new AttributionSubmitted($attribution));
            // Return 1x1 pixel transparent gif
            header("Content-type: image/gif");
            header("Content-Length: 42");
            header("Cache-Control: private, no-cache, no-cache=Set-Cookie, proxy-revalidate");
            header("Pragma: no-cache");
            echo base64_decode('R0lGODlhAQABAID/AMDAwAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEA');
        }
        // Flush output buffers
        ob_flush();
        flush();
        ob_end_flush();
    }
}
