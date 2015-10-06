/**
 * Main.js
 *
 * Main JS file for landing page package
 */
;(function( $, window, document ) {

    'use strict';

    var Main = {

        /**
         * Initialize
         */
        init: function() {
            this.smooth_scroll();
            this.hide_unhide();
            this.chartjs_config();
            this.comments_panel();
            this.add_comments();
        },

        /**
         * Smooth scrolling for anchor
         * 
         * @return false
         */
        smooth_scroll: function() {
            $('a[href*=#]:not([href=#])').click(function() {
                if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') || location.hostname == this.hostname) {
                    var target = $(this.hash);
                        target = target.length ? target : $('[name=' + this.hash.slice(1) +']');

                    if (target.length) {
                        $('html,body').animate({
                            scrollTop: target.offset().top
                        }, 500, 'swing');

                        return false;
                    }
                }
            });
        },

        /**
         * Hide/unhide elements
         * 
         * @return void
         */
        hide_unhide: function() {
            $('input[type="radio"]').change(function() {
                var id = $(this).data('target');

                if ( $(this).data('action') == 'hide' ) {
                    $('#' + id).addClass('hide');
                }

                if ( $(this).data('action') == 'unhide' ) {
                    $('#' + id).removeClass('hide');
                }
            });
        },

        /**
         * Configure ChartJS
         * 
         * @return void
         */
        chartjs_config: function() {
            Chart.defaults.global.tooltipTemplate      = "<%= label %> - <%= value %> leads";
            Chart.defaults.global.multiTooltipTemplate = " <%= datasetLabel %> - <%= value %> leads";
            Chart.defaults.global.tooltipFontFamily    = "'Monteserrat', sans-serif";
            Chart.defaults.global.tooltipFontSize      = 12;

            Chart.defaults.Line.pointDotRadius         = 3;
        },

        /**
         * Show/hide comments panel
         */
        comments_panel: function() {
            $('button.comment-button').click(function() {
                $('#comments-panel').removeClass('hide fadeOutRight').addClass('slideInRight');
            });

            $('#comments-panel-exit').click(function() {
                $('#comments-panel').removeClass('slideInRight').addClass('fadeOutRight');
            });
        },

        /**
         * Add comments
         */
        add_comments: function() {
            $('form#comment_submit').submit(function(e) {
                if ($('form#comment_submit textarea[name=comment]').val() != '') {
                    $.ajax({
                        method: 'POST',
                        url:    $(this).attr('action'),
                        data:   {
                            _token:     $('input[name=_token]').val(),
                            comment:    $('textarea[name=comment]').val()
                        },
                        success: function(data) {
                            var c = $('#comment_clone').clone();
                                c.removeAttr('id').find('span.has-tip').attr('title', data.user.fullname).html('<img src = "' + data.user.profile_url + '" class = "th" />');

                                c.find('h4').html(data.user.fullname);
                                c.find('span.date').html(data.comment.formatted_date);
                                c.find('.comment_content').html(data.comment.comment);

                            c.prependTo('#comments_block').addClass('slideInRight').removeClass('hide');

                            $('.no_comments').remove();
                            $('form#comment_submit textarea[name=comment]').val('');
                        }
                    });
                }

                return false;
            });
        }
    };

    Main.init();

})( jQuery, window, document );