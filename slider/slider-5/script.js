jQuery('.slider').clone().removeAttr('id').attr('id', 'slider-2').appendTo('body');

jQuery('#slider-1').slick({
    arrows: false,
    speed: 750,
    asNavFor: '#slider-2',
    dots: false
}).on('mousedown touchstart', function () {
    jQuery('body').addClass('down');
}).on('mouseleave mouseup touchend', function () {
    jQuery('body').removeClass('down');
});

jQuery(window).on('keydown', function () {
    jQuery('body').addClass('down');
}).on('keyup', function () {
    jQuery('body').removeClass('down');
});

jQuery('#slider-2').slick({
    fade: true,
    arrows: false,
    speed: 300,
    asNavFor:
    '#slider-1',
    dots: false
});

setTimeout(function(){
  jQuery(window).trigger('keydown');
  setTimeout(function(){
    jQuery('#slider-1').slick('slickNext');
    setTimeout(function(){
      jQuery(window).trigger('keyup');
    }, 500);
  }, 600);
}, 1500);

jQuery('#slider-1 image').removeAttr('mask');

jQuery(window).on('resize', function () {
    jQuery('#donutmask circle').attr({
        cx: jQuery(window).width() / 2,
        cy: jQuery(window).height() / 2
    });
    jQuery('#donutmask #outer').attr({
        r: jQuery(window).height() / 2.6
    });
    jQuery('#donutmask #inner').attr({
        r: jQuery(window).height() / 4.5
    });
}).resize();

jQuery(window).on('mousemove', function(e){
  jQuery('.cursor').css({
    top: e.pageY + 'px',
    left: e.pageX + 'px',
  })
});