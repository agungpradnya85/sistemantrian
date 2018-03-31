$(function() {

  'use strict';

  /**
   * ================================
   * PRELOADER
   * ================================
   */
  // makes sure the whole site is loaded
  $(window).on('load', function() {
    // will first fade out the loading animation
    $("#loader").fadeOut();
    //then background color will fade out slowly
    //$("#pgloading").delay(600).fadeOut("slow");

  });
});


