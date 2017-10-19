$(function () {

  if ($('span').hasClass('typed')) {
    new Typed('.typed', {
      strings: ['Technologies', 'WordPress Theme', 'WordPress Plugins', 'Framework', 'Application', 'Fonts'],
      typeSpeed: 100,
      loop: true,
      startDelay: 1000,
      backDelay: 1500
    });
  }

});