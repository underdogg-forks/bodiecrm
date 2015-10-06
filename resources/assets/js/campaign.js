/**
 * Campaign.js
 *
 * Campaign JS
 */
;(function( $, window, document ) {

    'use strict';

    var Campaign = {

        /**
         * Initialize
         */
        init: function() {
            this.campaign_users_delete();
        },

        campaign_users_delete: function() {
            $('section.campaigns #campaign_users_current input[type=checkbox]').change(function() {
                var container = $(this).parent().parent();

                if ( this.checked ) {
                    container.find('select').prop('disabled', 'disabled');
                    container.addClass('deleting')
                }
                else {
                    container.removeClass('deleting');
                    container.find('select').prop('disabled', false);
                }
            });
        }
    };

    Campaign.init();

})( jQuery, window, document );