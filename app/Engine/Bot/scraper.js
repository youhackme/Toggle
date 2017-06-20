(function () {
  var
    url,
    originalUrl,
    scriptDir,
    scriptPath = require('fs').absolute(require('system').args[0]),
    resourceTimeout = 30000,
    debug = false, // Output debug messages
    quiet = false; // Don't output errors

  try {
    // Working directory
    scriptDir = scriptPath.split('/');
    scriptDir.pop();
    scriptDir = scriptDir.join('/');

    require('fs').changeWorkingDirectory(scriptDir);

    require('system').args.forEach(function (arg) {

      var
        value,
        arr = /^(--[^=]+)=(.+)$/.exec(arg);

      if (arr && arr.length === 3) {
        arg = arr[1];
        value = arr[2];
      }

      switch (arg) {
        case '-v':
        case '--verbose':
          debug = true;

          break;
        case '-q':
        case '--quiet':
          quiet = true;

          break;
        case '--resource-timeout':
          if (value) {
            resourceTimeout = value;
          }

          break;
        default:
          url = originalUrl = arg;
      }
    });

    if (!url) {
      throw new Error('Usage: phantomjs ' + require('system').args[0] + ' <url>');
    }

    var toggleBot = {
      timeout: 30000,

      /**
       * Log messages to console
       */
      log: function (args) {
        if (args.type === 'error') {
          if (!quiet) {
            //require('system').stderr.write(args.message + '\n');
          }
        } else if (debug || args.type !== 'debug') {
          //require('system').stdout.write(args.message + '\n');
        }
      },

      /**
       * Send response
       */
      sendResponse: function (apps) {
        apps = apps || [];
        require('system').stdout.write(JSON.stringify(apps) + '\n');
        phantom.exit(1);
        //  require('system').stdout.write(JSON.stringify({url: url, originalUrl: originalUrl, applications: apps}) + '\n');
      },

      /**
       * Initialize
       */
      init: function () {
        var
          page, hostname, responseStatus,
          headers = {},
          responseCookies = {},
          a = document.createElement('a');

        a.href = url.replace(/#.*$/, '');

        hostname = a.hostname;

        page = require('webpage').create();

        page.settings.loadImages = false;
        page.settings.userAgent = 'Mozilla/5.0';
        page.settings.resourceTimeout = resourceTimeout;

        page.onError = function (message) {
          toggleBot.log(message, 'error');
        };

        page.onResourceTimeout = function () {
          toggleBot.log('Resource timeout', 'error');

          toggleBot.sendResponse();

          phantom.exit(1);
        };

        page.onResourceReceived = function (response) {
          if (response.url.replace(/\/$/, '') === url.replace(/\/$/, '')) {
            if (response.redirectURL) {
              url = response.redirectURL;

              return;
            }

            responseStatus = response.status;

            if (response.stage === 'end' && response.status === 200 && response.contentType.indexOf('text/html') !== -1) {

              headers = JSON.stringify(response.headers);
              
            }
          }
        };

        page.onResourceError = function (resourceError) {
          toggleBot.log(resourceError.errorString, 'error');
        };

        page.open(url, function (status) {
          var html, environmentVars = '';

          if (status === 'success') {
            html = page.content;

            // Collect cookies

            var cookies = page.cookies;
            for (var i in cookies) {

              responseCookies[cookies[i].name.toLowerCase()] = cookies[i].value;
              // console.log(cookies[i].name + '=' + cookies[i].value);
            }

            // Collect environment variables
            environmentVars = page.evaluate(function () {
              var i, environmentVars = '';

              for (i in window) {
                environmentVars += i + ' ';
              }

              return environmentVars;
            });

            toggleBot.log({message: 'environmentVars: ' + environmentVars});

            environmentVars = environmentVars.split(' ').slice(0, 500);

            var result = {
              hostname: hostname,
              url: url,
              html: html,
              headers: headers,
              status: responseStatus,
              env: environmentVars,
              cookies: responseCookies,
            };

            toggleBot.sendResponse(result);
            // console.log(JSON.stringify(result));

            // toggleBot.analyze(hostname, url, {
            //   html: html,
            //   headers: headers,
            //   env: environmentVars
            // });

            phantom.exit(0);
          } else {
            toggleBot.log('Failed to fetch page', 'error');

            toggleBot.sendResponse();

            phantom.exit(1);
          }
        });
      }
    };

    toggleBot.init();
  } catch (e) {
    // console.log(e);
    //toggleBot.log(e, 'error');
    toggleBot.sendResponse();
    phantom.exit(1);
  }
})();