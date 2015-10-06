/**
 * Project: Attribution Tracking
 *  
 * @description    Track visitor activity
 * @version        1.5
 * @link           https://developers.google.com/analytics/devguides/collection/analyticsjs/advanced
 * @author         Henry Tung <henrytung@gmail.com>
 */

/**
 * Attribution Constructor
 * 
 * @param {Object} tracker
 * @param {Object} config
 */
var Attribution = function( tracker, config ) {
    this.tracker            = tracker;
    this.current_timestamp  = Math.round( new Date().getTime() / 1000 );
    this.domain_name        = this.tracker.get('cookieDomain') || document.domain;

    // Calculate session and campaign timeouts
    this.session_timeout    = parseInt((config.hours || 0) * 60 * 60, 10) + parseInt((config.minutes || 30) * 60, 10);
    this.campaign_timeout   = parseInt((config.days || 0), 10) + parseInt((config.months || 6) * 30, 10);

    // Get other relevant values
    this.landing_page_id    = parseInt(document.getElementsByName(config.landing_page_id)[0].value);
    this.auth_key           = document.getElementsByName(config.auth_key)[0].value;
    this.email              = config.email;
    this.form_id            = config.form_id;

    /**
     * Define organic sources
     *
     * @link {https://developers.google.com/analytics/devguides/collection/gajs/gaTrackingTraffic?hl=en#searchEngine}
     * @type {Array}
     */
    this.organic_sources = [
        'google',
        'daum',
        'eniro',
        'naver',
        'yahoo',
        'msn',
        'bing',
        'aol',
        'lycos',
        'ask',
        'altavista',
        'netscape',
        'cnn',
        'about',
        'mamma',
        'alltheweb',
        'voila',
        'virgilio',
        'live',
        'baidu',
        'alice',
        'yandex',
        'najdi',
        'mama',
        'seznam',
        'search',               // potential false positive
        'wirtulana polska',
        'onetcenter',
        'szukacz',
        'yam',
        'pchome',
        'kvasir',
        'sesam',
        'ozu',
        'terra',
        'mynet',
        'ekolay',
        'rambler'
    ];

    /**
     * Define social sources
     *
     * Note: the current list is unpublished from Google
     *
     * @link {https://developers.google.com/analytics/devguides/socialdata/?csw=1}
     * @link {https://developers.google.com/analytics/devguides/collection/gajs/gaTrackingSocial}
     * @type {Array}
     */
    this.social_sources = [
        'facebook',
        'pinterest',
        'twitter',
        'buzzfeed',
        'linkedin',
        'blogger',
        'blogspot',
        'reddit',
        'tumblr',
        'stumbleupon',
        'tinyurl',
        'polyvore',
        'youtube',
        'yelp',
        'cafemom',
        'flickr',
        'paper.li',
        'wordpress',
        'getpocket',
        'weebly',
        'delicious',
        'netvibes',
        'plurk',
        'typepad',
        'vk',
        'allvoices',
        'badoo',
        'disqus',
        'livefyre',
        'd.hatena'
    ];

    /**
     * Define custom social sources to avoid false positives
     *
     * Check intersecting array values here first
     * 
     * @type {Array}
     */
    this.custom_social = [
        't.co',
        'plus.google.com',
        'plus.url.google.com',
        'bookmarks.yahoo.com',
        'answers.yahoo.com'
    ];

    /**
     * Default visitor details
     * 
     * @type {Object}
     */
    this._wma = {
        'tracking_id':          '',
        'timestamp':            this.current_timestamp,          // default timestamp is now
        'source':               '',
        'medium':               '',
        'keyword':              '',
        'content':              '',
        'campaign':             '',
        'landing_page':         window.location.href,           // default landing page location
    };

    /**
     * Define Google URL parameters
     *
     * @link {https://support.google.com/analytics/answer/1033867?hl=en}
     * @type {Object}
     */
    this.url_parameters = {
        utm_source:        'source',
        utm_medium:        'medium',
        utm_term:          'keyword',
        utm_content:       'content',
        utm_campaign:      'campaign'
    };

    /**
     * Available mediums (for reference)
     * 
     * @type {Array}
     */
    this.mediums = [
        'none',
        'referral',
        'organic',
        'social',
        'paid'
    ];

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
function providePlugin( pluginName, pluginConstructor ) {
    var ga = window[window['GoogleAnalyticsObject'] || 'ga'];
    if ( ga ) ga('provide', pluginName, pluginConstructor);
}

/**
 * Helper function: get intersecting arrays
 * 
 * @param  {Array} arr1
 * @param  {Array} arr2
 * @return {Array}
 */
function get_intersect( arr1, arr2 ) {
    var r = [], o = {}, l = arr2.length, i, v;
    for (i = 0; i < l; i++) {
        o[arr2[i]] = true;
    }
    l = arr1.length;
    for (i = 0; i < l; i++) {
        v = arr1[i];
        if (v in o) {
            r.push(v);
        }
    }
    return r;
}

/**
 * Helper function: read cookie
 * 
 * @param  {String} name
 * @return {String}
 */
function read_cookie( name ) {
    var nameEQ  = name + "=",
        ca      = String(document.cookie).split(';');

    for ( var i in ca ) {
        var c = String(ca[i]);
        
        while ( c.charAt(0) == ' ' ) {
            c = c.substring(1, c.length);
        }
        
        if ( c.indexOf(nameEQ) === 0 ) {
            return c.substring(nameEQ.length, c.length);
        }
    }

    return null;
}

/**
 * Helper function: set cookie
 *  
 * @param {String} name
 * @param {String} value
 * @param {Integer} timeout
 * @param {String} domain_name
 */
function set_cookie( name, value, timeout, domain_name ) {
    var expires,
        date = new Date();

        date.setTime(date.getTime() + (timeout * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    
    if ( domain_name == 'none' ) {
        document.cookie = name + "=" + value + expires + ";path=/;";
    }
    else {
        document.cookie = name + "=" + value + expires + ";path=/;domain=" + domain_name;
    }
}

/**
 * Initialize
 * 
 * @return void
 */
Attribution.prototype.init = function () {

    /**
     * Check cookies
     *
     * If this is a new session, get visitor tracking ID and determine medium/sources
     */
    if ( this.is_new_visitor() ) {

        // Get GA tracking ID
        this._wma.tracking_id = parseInt(this.tracker.get('clientId').split('.')[0], 10);

        this.get_info();
        this.get_url_parameters();

        set_cookie('_wma', JSON.stringify(this._wma), this.campaign_timeout, this.domain_name);
        set_cookie('_wmb', JSON.stringify(this._wma), this.campaign_timeout, this.domain_name);

        //this.tracker.send('event', 'Unique User Info', this._wma.tracking_id, '', '');
    }

    /**
     * Session exists, update visitor data
     */
    else if ( this.is_new_session() ) {

        // If referrer is the same host, use the existing wma cookie
        if ( location.hostname == document.referrer.split('/')[2] ) {
            this._wma = JSON.parse(read_cookie('_wma'));
        }

        // Get GA tracking ID
        this._wma.tracking_id = parseInt(this.tracker.get('clientId').split('.')[0], 10);

        this.get_info();
        this.get_url_parameters();
        
        set_cookie('_wma', JSON.stringify(this._wma), this.campaign_timeout, this.domain_name);

        //this.tracker.send('event', 'Unique User Info', this._wma.tracking_id, '', '');
    }

    // Ready event listener for form submit
    this.set_event_listener();
};

/**
 * Set an event listener for form submit
 *
 * @return void
 */
Attribution.prototype.set_event_listener = function() {
    var form        = document.getElementById(this.form_id),
        _wma        = JSON.parse(read_cookie('_wma')),
        _wmb        = JSON.parse(read_cookie('_wmb')),
        email       = this.email,
        params      = '?lp=' + this.landing_page_id + 
            '&ak=' + this.auth_key +
            '&t=' + _wma.tracking_id +
            '&cs=' + _wma.source +
            '&cm=' + _wma.medium +
            '&ck=' + _wma.keyword +
            '&ccn=' + _wma.content +
            '&cc=' + _wma.campaign +
            '&cl=' + encodeURIComponent(_wma.landing_page) +
            '&ct=' + _wma.timestamp +
            '&os=' + _wmb.source +
            '&om=' + _wmb.medium +
            '&ok=' + _wmb.keyword +
            '&ocn=' + _wmb.content +
            '&oc=' + _wmb.campaign +
            '&ol=' + _wmb.landing_page +
            '&ot=' + _wmb.timestamp +
            '&r=' + document.referrer;

    // Create and call 1x1 pixel on form submit
    if ( form.addEventListener ) {
        form.addEventListener('submit', function(e) {
            params  += '&em=' + document.getElementsByName(email)[0].value;

            var x   = document.createElement('img');
            x.src   = 'http://45.55.168.125/pixel' + params;
        }, false);
    }
    else if (form.attachEvent) {
        form.attachEvent('onsubmit', function(e) {
            params      += '&em=' + document.getElementsByName(email)[0].value;

            var x       = document.createElement('img');
                x.src   = 'http://45.55.168.125/pixel' + params;
        });
    }
};

/**
 * Check if this is a new visitor
 * 
 * @return {Boolean}
 */
Attribution.prototype.is_new_visitor = function () {
    return JSON.parse(read_cookie('_wma')) === null ? true : false;
};

/**
 * Check if this is a new session
 * 
 * @return {Boolean}
 */
Attribution.prototype.is_new_session = function () {
    var cookie = JSON.parse(read_cookie('_wma'));

    // If current timestamp is past the cookie timestamp + session timeout length, this is a new session
    if ( this.current_timestamp > parseInt(cookie.timestamp, 10) + this.session_timeout ) {
        return true;
    }
    else {
        return false;
    }
};

/**
 * Get visitor medium and source info
 */
Attribution.prototype.get_info = function () {

    // Set updated timestamp
    this._wma.timestamp = this.current_timestamp;

    /**
     * Check if referrer is undefined, in organic_sources array or in social_sources array
     */
    if ( document.referrer === undefined || document.referrer === 'undefined' || document.referrer === '' ) {
        this._wma.medium = 'none';
        this._wma.source = 'direct';
    }

    // If referrer is not the same host, process medium and source
    else if ( location.hostname != document.referrer.split('/')[2] ) {
        this._wma.source    = document.referrer.split('/')[2];         // split to get domain string
        var source          = this._wma.source.split('.');             // split to get domain parts

        // First check for custom social sources
        if ( this.custom_social.indexOf(this._wma.source) > 0 ) {
            this._wma.medium = 'social';
        }
        
        // Then check for search engines
        else if ( get_intersect(this.organic_sources, source).length > 0 ) {
            var url_strs = this.get_url_parameters(document.URL);

            // If gclid exist in current URL, paid medium
            if ( 'gclid' in url_strs ) {
                this._wma.medium = 'paid';
            }

            // Organic
            else {
                this._wma.medium    = 'organic';
                this._wma.keyword   = 'not provided';

                var refer_strs      = this.get_url_parameters(document.referrer);

                // Look for potential search terms
                if ( 'q' in refer_strs ) {
                    this._wma.keyword = refer_strs.q;
                }
            }
        }

        // Then check for social sources
        else if ( get_intersect(this.social_sources, source).length > 0 ) {
            this._wma.medium = 'social';
        }
        
        // Else referral
        else {
            this._wma.medium = 'referral';
        }
    }
};

/**
 * Get and set Google URL parameters
 *
 * @param {String} url
 * @return {Object}
 */
Attribution.prototype.get_url_parameters = function ( url ) {
    var vars    = [], hash, hashes,
        kv      = {};

    if ( url ) {
        hashes  = String(url.slice(url.indexOf('?') + 1)).split('&');
    }
    else {
        hashes  = String(window.location.href.slice(window.location.href.indexOf('?') + 1)).split('&');
    }

    for ( var i in hashes ) {
        hash = String(hashes[i]).split('=');
        
        kv[hash[0]] = hash[1];
        
        // If this is a matching URL tag, update _wma values
        if (hash[0] in this.url_parameters) {
            var key        = this.url_parameters[hash[0]];
            this._wma[key] = decodeURIComponent(hash[1]);
        }
    }

    return kv;
};

// Register the plugin.
providePlugin( 'Attribution', Attribution );