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
    <title>Add original Theme</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <h3 class="text-info">Add a Theme</h3>
            <hr>
            <form role="form">
                <div class="form-group has-feedback">
                    <label for="theme-demo-url">Theme demo Url</label>
                    <input type="text" class="form-control js-find-application" id="theme-demo-url"
                           placeholder="http://toggle.me">
                    <span class="js-find-application-spinner glyphicon glyphicon-repeat fast-right-spinner form-control-feedback"
                          style="display: none;"></span>
                </div>
                <div class="form-group">
                    <label for="theme-name">Theme Name</label>
                    <input type="text" class="form-control" id="theme-name" placeholder="Avada">
                </div>

                <div class="form-group">
                    <label for="theme-description">Theme Description</label>
                    <textarea type="text" class="form-control" id="theme-description"
                              placeholder="This is a bootstrap 4 premium theme."></textarea>
                </div>
                <div class="form-group">
                    <label for="theme-alias">Theme Alias</label>
                    <input type="text" class="form-control" id="theme-alias" placeholder="avada">
                </div>
                <div class="form-group">
                    <label for="screenshot-url">Screenshot Url</label>
                    <input type="text" class="form-control" id="screenshot-url"
                           placeholder="http://toggle.me/wp-content/themes/avada/screenshot.png">
                </div>
                <div class="form-group">
                    <label for="screenshot-hash">Screenshot Hash</label>
                    <input type="text" class="form-control" id="screenshot-hash" placeholder="123abef67676aeb3abcds">
                </div>
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

    var themeForm = {
      init: function () {
        $('.js-find-application').focusout(this.findTheme);
        this.subscriptions();

      },
      findTheme: function () {

        var themeDemoUrl = $('#theme-demo-url').val();
        if (themeDemoUrl != '') {
          this.toggleSpinner;
          axios.get('/site/' + themeDemoUrl)
            .then(function (response) {

              this.toggleSpinner;

              $.publish('wordpress/results');

            })
            .catch(function (error) {
              console.log(error);
            });
        }
      },
      save: function () {
      },
      validate: function () {
      },
      toggleSpinner: function () {
        $('.js-find-application-spinner').toggle();
      },
      renderResults: function () {
        var themeAliases = [];

        $.each(response.data.theme, function (themeAlias, detail) {
          themeAliases.push(themeAlias);
          $('#theme-description').val(detail.description);
        });

        $('#theme-alias').val(themeAliases.join());

        $.each(response.data.screenshot, function (themeAlias, screenshot) {
          $('#screenshot-hash').val(screenshot.hash);
          $('#screenshot-url').val(screenshot.url);
          return false;
        });

        console.log(response.data);
      },
      subscriptions: function () {
        $.subscribe('wordpress/results', this.renderResults);

      },
    };

    themeForm.init();

  })(jQuery);


</script>
</body>
</html>