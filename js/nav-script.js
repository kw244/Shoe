;(function($) {

"use strict";

var $body = $('body');
// var $head = $('head');
// var $mainWrapper = $('#main-wrapper');

$(document).ready(function () {

	/* -------------------------------------------------------------------------
    SELECT BOX 
  ------------------------------------------------------------------------- */
/*   $.fn.SelectBox = function() {

    var self = $(this),
      select = self.find('select');
    self.prepend('<ul class="select-clone custom-list"></ul>');

    var placeholder = select.data('placeholder') ? select.data('placeholder') : select.find('option:eq(0)').text(),
      clone = self.find('.select-clone');
    self.prepend('<input class="value-holder" type="text" disabled="disabled" placeholder="' + placeholder + '">');
    var value_holder = self.find('.value-holder');

    // CREATE CLONE LIST
    select.find('option').each(function() {
      if ($(this).attr('value')) {
        clone.append('<li data-value="' + $(this).val() + '">' + $(this).text() + '</li>');
      }
    });

    // TOGGLE LIST
    self.click(function() {
      clone.slideToggle(100);
      self.toggleClass('active');
    });

    // CLICK
    clone.find('li').click(function() {
      console.log($(this).text());
      value_holder.val($(this).text());
      select.find('option[value="' + $(this).attr('data-value') + '"]').attr('selected', 'selected');

      // IF LIST OF LINKS
      if (self.hasClass('links')) {
        window.location.href = select.val();
      }
    });

    // HIDE LIST
    self.bind('clickoutside', function(event) {
      clone.slideUp(100);
    });

    // LIST OF LINKS
    if (self.hasClass('links')) {
      select.change(function() {
        window.location.href = select.val();
      });
    }

  };
 */

  // NAVBAR TOGGLE
  $( '.toggleMenu' ).click(function(){
    $('.navigation nav').slideToggle(300);
  });
  
  $(document).on('click', function(event) {
      if (!$(event.target).closest('.navigation').length && $(window).width() <= 768) {
        // Hide the menus.
        $('.navigation nav').slideUp(300);
      }
  });
  

  
  
  $(window).resize(function(){
    if ($(window).width() > 768) {
      $('.navigation nav').removeAttr( 'style' );
    }
  });


});


// Touch
// ---------------------------------------------------------
var dragging = false;

$body.on('touchmove', function() {
	dragging = true;
});

$body.on('touchstart', function() {
	dragging = false;
});



}(jQuery));
