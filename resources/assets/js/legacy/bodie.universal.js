/*
 *  Project: Attribution Tracking
 *  
 *  @description    Parse custom cookies to populate web-to-lead form inputs
 *  @version        1.22
 *  @author         Henry Tung <henrytung@gmail.com>
 */
var BodieAttribution = function(tracker, config) {
    this.tracker    = tracker;
    this.data       = config;           // for Bodie input fields

    /**
     * Default visitor values
     * 
     * @type {Object}
     */
    this.visitor = {
        'tracking_id':              '',
        'converting_keyword':       '',
        'converting_source':        '',
        'converting_medium':        '',
        'converting_campaign':      '',
        'converting_content':       '',
        'converting_landing_page':  '',
        'converting_timestamp':     '',
        'original_keyword':         '',
        'original_source':          '',
        'original_medium':          '',
        'original_campaign':        '',
        'original_content':         '',
        'original_landing_page':    '',
        'original_timestamp':       '',
        'refer_url':                document.referrer
    };

    this.init();
};

/**
 * Provide plugin name and constructor to analytics.js
 * 
 * @param  {String} pluginName
 * @param  {Object} pluginConstructor
 * @link   {https://developers.google.com/analytics/devguides/collection/analyticsjs/plugins}
 * @link   {https://developers.google.com/analytics/devguides/collection/analyticsjs/field-reference}
 * @return void
 */
function providePlugin(pluginName, pluginConstructor) {
    var ga = window[window['GoogleAnalyticsObject'] || 'ga'];
    if (ga) ga('provide', pluginName, pluginConstructor);
}

/**
 * Parse cookie
 *
 * @param String name
 * @return String
 */
function read_cookie(name) {
    var nameEQ  = name + '=',
        ca      = String(document.cookie).split(';');

    for (var i in ca) {
        var c = String(ca[i]);
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length,c.length);
    }

    return null;
};

/**
 *  Convert UNIX timestamp
 *  
 *  @param Integer timestamp
 *  @return String
 */
function convert_timestamp(timestamp) {
    var t = new Date(timestamp * 1000);

    return (t.getMonth() + 1) + '/' + t.getDate() + '/' + t.getFullYear() + ' ' + t.getHours() + ':' + t.getMinutes() + ':' + t.getSeconds();
};

/**
 * Get session data
 * 
 * @param String type
 */
BodieAttribution.prototype.get_session = function (type) {
    type    = (type != 'original' && type != 'converting') ? 'original' : type;
    s       = (type == 'original') ? JSON.parse(read_cookie('_wmb')) : JSON.parse(read_cookie('_wma'));

    if (s) {
        this.visitor.tracking_id             = s.tracking_id;

        this.visitor[type + '_timestamp']    = convert_timestamp(decodeURIComponent(s.timestamp));
        this.visitor[type + '_keyword']      = decodeURIComponent(s.keyword);
        this.visitor[type + '_source']       = decodeURIComponent(s.source);
        this.visitor[type + '_medium']       = decodeURIComponent(s.medium);
        this.visitor[type + '_content']      = decodeURIComponent(s.content);
        this.visitor[type + '_campaign']     = decodeURIComponent(s.campaign);
        this.visitor[type + '_landing_page'] = decodeURIComponent(s.landing_page);
    }
};

/**
 * Set values into inputs
 */
BodieAttribution.prototype.set_values = function () {
    var e = document.getElementsByTagName('input');

    for (var i in e) {
        if (typeof e[i] === 'object' && typeof e[i] !== null && e[i].type != 'radio' && e[i].type !== undefined) {
            for (var a in this.data) {
                if (e[i].getAttribute('name').toLowerCase() && e[i].getAttribute('name').toLowerCase().indexOf(this.data[a].toLowerCase()) > -1) {
                    e[i].value = this.visitor[a];

                    break;
                }
            }
        }
    }
};

/**
 * Initialize Bodie
 * 
 * @return void
 */
BodieAttribution.prototype.init = function () {
    this.get_session('original');
    this.get_session('converting');

    this.set_values();
};

// Register the plugin.
providePlugin('BodieAttribution', BodieAttribution);