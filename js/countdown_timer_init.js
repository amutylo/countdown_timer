(function ($, Drupal, drupalSettings) {
  "use strict";
  /**
   * Attaches the JS countdown behavior
   */
  Drupal.behaviors.countdownTimer = {
    attach: function (context) {
      var container = $('#countdown-container'),
        ts = new Date(1588327200 * 1000);
      if (container && container.length) {
        $(context).find('#countdown-container').once('countdown-timer').countdown(
          "2020/05/01", function(event) {
            var $this = $(this).html(event.strftime(''
              + '<span>%w</span> weeks '
              + '<span>%d</span> days '
              + '<span>%H</span> hr '
              + '<span>%M</span> min '
              + '<span>%S</span> sec'));
        });
      }
    }
  }

})(jQuery, Drupal, drupalSettings);
