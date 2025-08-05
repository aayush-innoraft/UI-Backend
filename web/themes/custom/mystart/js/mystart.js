(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.mystartBehavior = {
    attach: function (context, settings) {
      console.log("✅ mystart.js is working!");
    },
  };
})(jQuery, Drupal, drupalSettings);
