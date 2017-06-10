<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}" type="text/css"/>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>

    <title>Plugin details</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <h3 class="text-info">Plugin details</h3>
            <hr>


            <div class="alert  js-alert" style="display: none;">

            </div>


            <form role="form" method="POST" class="js-submit-form">

                <div class="form-group has-feedback">
                    <label for="previewlink">Plugin Preview Url</label>
                    <input type="text" class="form-control" id="previewlink"
                           placeholder="http://toggle.me"
                           value="{{$plugin->previewlink}}"
                    >
                    <span class="js-find-application-spinner glyphicon glyphicon-repeat fast-right-spinner form-control-feedback"
                          style="display: none;">
                    </span>
                </div>
                <div class="form-group">
                    <label for="uniqueidentifier">Unique Identifier</label>
                    <input type="text" class="form-control" id="uniqueidentifier" placeholder="987878787"
                           value="{{$plugin->uniqueidentifier}}">
                </div>
                <div class="form-group">
                    <label for="name">Plugin Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Avada" value="{{$plugin->name}}">
                </div>

                <div class="form-group">
                    <label for="description">Plugin Description</label>
                    <textarea type="text"
                              class="form-control"
                              id="description"
                              placeholder="This is a marketing plugin to boost email conversions."
                              style="height:200px;"
                    >{{$plugin->description}}</textarea>
                </div>
                <div class="form-group js-slug">
                    <input type="text" class="form-control" id="slug" placeholder="optinmonster">
                </div>
                <div class="form-group">
                    <label for="screenshoturl">Screenshot Url(For Marketing)</label>
                    <input type="text" class="form-control" id="screenshoturl"
                           placeholder="http://toggle.me/wp-content/themes/avada/screenshot.png"
                           value="{{$plugin->screenshoturl}}">
                </div>

                <div class="form-group">
                    <label for="downloadlink">Download Link</label>
                    <input type="text" class="form-control" id="downloadlink"
                           placeholder="http://themeforest.net/theme"
                           value="https://{{$plugin->provider}}{{$plugin->downloadlink}}">
                </div>
                <input type="hidden" id="id" value="{{$plugin->id}}">
                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </form>
        </div>
    </div>
</div>
<style>
    .glyphicon.fast-right-spinner {
        -webkit-animation: glyphicon-spin-r 1s infinite linear;
        animation: glyphicon-spin-r 1s infinite linear;
    }

    @-webkit-keyframes glyphicon-spin-r {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(359deg);
            transform: rotate(359deg);
        }
    }

    @keyframes glyphicon-spin-r {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(359deg);
            transform: rotate(359deg);
        }
    }


</style>
<script>
  (function ($) {
    var o = $({});
    $.each({
      on: 'subscribe',
      trigger: 'publish',
      off: 'unsubscribe'
    }, function (key, api) {
      $[api] = function () {
        o[key].apply(o, arguments);
      };
    });
  })(jQuery);

  (function ($) {

    var pluginForm = {
      init: function () {
        this.bindEvents();
        this.subscriptions();

      },
      bindEvents: function () {
        $('.js-find-application').focusout(this.findTheme);
        $('.js-submit-form').submit(function (event) {
          event.preventDefault();
          console.log('triggered');
          pluginForm.save.call(this);

        });

      },
      subscriptions: function () {
        $.subscribe('wordpress/results', this.renderResults);
      },
      findPlugin: function () {
        pluginForm.toggleSpinner.call(this);
        var themeDemoUrl = $('#previewlink').val();
        if (themeDemoUrl != '') {

          axios.get('/site/' + themeDemoUrl)
            .then(function (response) {
              console.log(response);
              pluginForm.toggleSpinner.call(this);
              pluginForm.response = response;

              $.publish('wordpress/results');

            });
        }
      },
      toggleSpinner: function () {
        $('.js-find-application-spinner').toggle();
      },
      renderResults: function () {
        var pluginAlias = [];
        var self = pluginForm;

        $.each(self.response.data.plugins, function (pluginAlias, plugin) {
          console.log(pluginAlias);
          console.log(plugin);

          $(' <label class="radio-inline"> <input class="js-pick-slug" name="optradio" data-slug="' + pluginAlias + ' " type="radio"> ' + pluginAlias + ' </label> ')
            .prependTo('.js-slug');

          $(document).on('change', '.js-pick-slug', function () {
            if (this.checked) {
              $('#slug').val($(this).data('slug'));
            }
          });

          pluginAlias.push(pluginAlias);
          if (typeof plugin.description !== 'undefined') {
            descriptions.push(plugin.description);
          }

        });

      },
      save: function () {

        axios.post('/admin/theme/add', {
          uniqueidentifier: $('#uniqueidentifier').val(),
          name: $('#name').val(),
          slug: $('#slug').val(),
          screenshoturl: $('#screenshoturl').val(),
          downloadlink: $('#downloadlink').val(),
          description: $('#description').val(),
          previewlink: $('#previewlink').val(),
          provider: $('#provider').val(),
          type: $('#type').val(),
          screenshotHash: $('#screenshotHash').val(),
          type: $('#type').val()
        })
          .then(function (response) {
            $('div.js-alert')
              .removeClass('alert-danger')
              .addClass('alert-success')
              .html('Theme saved successfully')
              .show();
          })
          .catch(function (error) {
            if (error.response.status == 422) {
              var list = '';
              $.each(error.response.data, function (key, error) {
                list = list + '<li>' + error + '</li>';
              });

              $('div.js-alert')
                .removeClass('alert-success')
                .addClass('alert-danger')
                .html('<ul>' + list + '</ul>')
                .show();

            }
          });

      }
    };

    var navigation = {

      init: function () {
        this.bindEvents();
      },
      bindEvents: function () {
        var self = this;
        $(document).keyup(function (event) {

          switch (event.which) {
            case 37:
              self.previous();
              break;
            case 39:
              self.next();
              break;
            case 70:
              self.scan();
              break;
          }
        });

      },
      next: function () {
        window.location = '/admin/plugin/list/{{$next}}';
      },
      previous: function () {
        window.location = '/admin/plugin/list/{{$previous}}';
      },
      scan: function () {
        pluginForm.findPlugin();
      }
    };

    pluginForm.init();
    navigation.init();

  })(jQuery);


</script>
</body>
</html>
