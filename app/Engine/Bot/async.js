var phantom = require('phantom');

(async function () {
  const instance = await phantom.create();
  const page = await instance.createPage();
  await page.on('onResourceRequested', function (requestData) {
    // console.info('Requesting', requestData.url);
  });

  const status = await page.open(process.argv[2]);
  const content = await page.property('content');

  var result = {
    hostname: process.argv[2],
    url: process.argv[2],
    html: content,
    headers: 'headers',
    status: 200,
    env: 'env',
    cookies: 'cookies',
  };

  console.log(JSON.stringify(result));

  await instance.exit();
}());
