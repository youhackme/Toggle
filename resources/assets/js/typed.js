$(function () {

  if ($('span').hasClass('typed')) {
    new Typed('.typed', {
      strings: ['Technologies', 'WordPress Themes', 'WordPress Plugins', 'Frameworks', 'Applications', 'Fonts'],
      typeSpeed: 100,
      loop: true,
      startDelay: 1000,
      backDelay: 1500
    });
  }

});