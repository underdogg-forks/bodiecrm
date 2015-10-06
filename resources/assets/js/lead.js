/**
 * Lead.js
 *
 * Lead JS
 */
;(function( $, window, document ) {

    'use strict';

    var Lead = {

        /**
         * Initialize
         */
        init: function() {
            this.leads_users_delete();
            this.leads_watch_unwatch();
            this.get_landing_page_auth();
            this.add_custom_field();
            this.set_custom_field();
        },

        /**
         * Highlight row when prompting to delete a user
         * 
         * @return void
         */
        leads_users_delete: function() {
            $('section.leads #leads_single_users_current input[type=checkbox]').change(function() {
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
        },

        /**
         * Watch/unwatch a lead
         * 
         * @return void
         */
        leads_watch_unwatch: function() {
            $('.lead_follow').on('click', '.watch', function() {
                $(this)
                    .removeClass('watch')
                    .addClass('unwatch')
                    .html('<i class = "fa fa-star"></i>Unwatch');

                var el      = $(this).next('button'),
                    count   = parseInt(el.html());

                el.html(count + 1);

                $.ajax({
                    method: 'GET',
                    url: $(this).data('url'),
                    data: { csrf: $(this).data('csrf') }
                });
            });

            $('.lead_follow').on('click', '.unwatch', function() {
                $(this)
                    .removeClass('unwatch')
                    .addClass('watch')
                    .html('<i class = "fa fa-star"></i>Watch');

                var el      = $(this).next('button'),
                    count   = parseInt(el.html());

                el.html(count - 1);

                $.ajax({
                    method: 'GET',
                    url: $(this).data('url'),
                    data: { csrf: $(this).data('csrf') }
                });
            });
        },

        /**
         * Get landing page authentication key
         * 
         * @return String
         */
        get_landing_page_auth: function() {
            $('#leads_single_create #landing_page_select').change(function() {
                if ( $(this).val() != '' ) {
                    $('#auth_key').val($(this).find(':selected').data('key'));
                }
                else {
                    $('#auth_key').val('');
                }
            });
        },

        /**
         * Add custom field to lead creation
         */
        add_custom_field: function() {
            $('#leads_single_create #leads_single_create_custom a.button').click(function() {
                $('#custom_fields').clone().removeAttr('id').removeClass('hide').appendTo('#leads_single_create_custom');
            });
        },

        /**
         * Set the custom field name
         */
        set_custom_field: function() {
            $('#leads_single_create #leads_single_create_custom').on('focusout', 'input.custom_field_name', function() {
                $(this).parent().parent().find('input.custom_field_value').attr('name', $(this).val());
            });
        }
    };

    Lead.init();

})( jQuery, window, document );