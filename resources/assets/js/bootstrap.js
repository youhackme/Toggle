try {
  window.$ = window.jQuery = require('jquery');
  window.Popper = require('popper.js');
  window.Tether = require('tether');
  require('bootstrap');
} catch (e) {}