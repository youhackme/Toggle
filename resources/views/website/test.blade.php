<!doctype html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Home &raquo; test.com</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <style>
        .feature-inim-collage .col {
            padding: 0;
            margin: 0
        }

        .HomePage .feature-inim-collage .growable-container {

            display: block;
            float: left;
            position: relative;
            margin: 0 8px 8px 0;
            padding: 0;
        }

        .HomePage .feature-inim-collage .growable-container:hover {
            cursor: pointer
        }

        .HomePage .feature-inim-collage .growable-container img {
            height: 200px;
            max-width: 100%;
            max-height: 100%;
        }

        .HomePage .feature-inim-collage .growable-container .growable-container-like img {
            width: 20px
        }

        .HomePage .feature-inim-collage .growable-container:last-of-type {
            margin-right: 0
        }

        .col {
            display: block;
            float: left;
            margin: 1% 0 1% 1.6%;
            box-sizing: border-box;
            width: 100%;
        }

        .col:first-child {
            margin-left: 0
        }

        .no-col-vertical-margin .col {
            margin-top: 0;
            margin-bottom: 0
        }


    </style>
</head>
<body class="HomePage home white-header">
<section class="section group normal-screen feature-inim-collage feature-inims-top-row margin-top-15px">
    <div class="col span_1_of_1">
        <div class="growable-container growable-container-1" data-url="/inim/vivaluxury/76346/details"
             data-inims-id="76346" data-inims-username="vivaluxury">
            <img class="growable-container-inim"
                 src="https://dhklshjlt2i0p.cloudfront.net/content/resized/medium/3333/inims/5f013436988f54219e8c9d28ab44fb50a9ddec1c6f2ece3b7b56f540d88d2544.jpg">
        </div>
        <div class="growable-container growable-container-2" data-url="/inim/zeanvo/99274/details" data-inims-id="99274"
             data-inims-username="zeanvo">
            <img class="growable-container-inim"
                 src="https://dhklshjlt2i0p.cloudfront.net/content/resized/medium/416/inims/2879689b51efc6b2d6325ba439a8d51fa7b9e757e87db037a3f65433412af513.jpg">
        </div>
        <div class="growable-container growable-container-3" data-url="/inim/stockholmstreetstyle/4243/details"
             data-inims-id="4243" data-inims-username="stockholmstreetstyle">
            <img class="growable-container-inim"
                 src="https://dhklshjlt2i0p.cloudfront.net/content/resized/medium/50/inims/325c49038aa043174058083c3f53a8c6516241b0159d54d524c6f475ee082051.jpg">
        </div>
        <div class="growable-container growable-container-4" data-url="/inim/stockholmstreetstyle/4288/details"
             data-inims-id="4288" data-inims-username="stockholmstreetstyle">
            <img class="growable-container-inim"
                 src="https://dhklshjlt2i0p.cloudfront.net/content/resized/medium/50/inims/b5a3b7ced95dc97909ec39c2a2a7e38cae0e3ca496918e0a0b117d6d7fa796b5.jpg">
        </div>
    </div>
</section>
<section class="section group normal-screen feature-inim-collage feature-inims-bottom-row">
    <div class="col span_1_of_1">
        <div class="growable-container growable-container-5" data-url="/inim/vivaluxury/76056/details"
             data-inims-id="76056" data-inims-username="vivaluxury">
            <img class="growable-container-inim"
                 src="https://dhklshjlt2i0p.cloudfront.net/content/resized/medium/3333/inims/7f8bc2b9d2049685416026fb6db4234931af430ec92f7c7659db606354496b93.jpg">
        </div>
        <div class="growable-container growable-container-6" data-url="/inim/saraescudero/99165/details"
             data-inims-id="99165" data-inims-username="saraescudero">
            <img class="growable-container-inim"
                 src="https://dhklshjlt2i0p.cloudfront.net/content/resized/medium/3315/inims/8d1f3558184937e6ecaf57250ba49ef43d8bbc7c3bd9ae00285372c3419b2398.jpg">
        </div>
        <div class="growable-container growable-container-7" data-url="/inim/David/99163/details" data-inims-id="99163"
             data-inims-username="David">
            <img class="growable-container-inim"
                 src="https://dhklshjlt2i0p.cloudfront.net/content/resized/medium/3404/inims/4b4605c129512ff5048888e67791437223ca3f114fe60cb1be41d30a48948640.jpg">
        </div>
        <div class="growable-container growable-container-8" data-url="/inim/margaretzhang/24644/details"
             data-inims-id="24644" data-inims-username="margaretzhang">
            <img class="growable-container-inim"
                 src="https://dhklshjlt2i0p.cloudfront.net/content/resized/medium/715/inims/cf3c2d97466d4250ecf2f4004dce1f045aa07e5626821411988c787093bc4678.jpg">
        </div>
    </div>
</section>


<button id="2">Increase height</button>


<script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script>

  $(document).ready(function () {

    $('#2').click(function () {
      $('.feature-inims-bottom-row .growable-container img').css('height', '+=5');
      var RowWidth2 = CalculateTotalWidth(2);
      var ContainerWidth = $('.feature-inim-collage .col.span_1_of_1').width();
      alert('Container: ' + ContainerWidth + 'Row width: ' + RowWidth2);
    });

    /*****
     * Get the overall width of the container that we want to match
     **********/
    var ContainerWidth = $('.feature-inim-collage .col.span_1_of_1').width();
    console.log('Container Width: ' + ContainerWidth);

    /*****
     * Increase the height of the images until the total sum of the width if the
     * 4 images + the gutters is larger than ContainerWidth - then stop
     **********/

    /*****
     * Increment in jumps of 10px until we get within 80% of the width of
     * the ContainerWidth and then go to a more precise increment of 1px.
     * We can increase the px from 10 to 20 or 30 so there are less loops
     * but this can cause issues when we look at mobile and there is less
     * overall width in the containers and jumping by 30px will be too much
     **********/
    var i = 0;

    do {
      $('.feature-inims-top-row .growable-container img').css('height', i);

      var RowWidth1 = CalculateTotalWidth(1);

      if (RowWidth1 < (ContainerWidth * 0.8)) {
        i = i + 10;
      } else {
        i++;
      }
    }
    while (RowWidth1 < (ContainerWidth - 3));

    /*****
     * Repeat above for the 2nd row
     **********/
    var height = 0;
    do {
      $('.feature-inims-bottom-row .growable-container img').css('height', height);

      var RowWidth2 = CalculateTotalWidth(2);

      if (RowWidth2 < (ContainerWidth * 0.8)) {
        height = height + 10;
      } else {
        height++;
      }
    }
    while (RowWidth2 < (ContainerWidth - 3));

    /*********
     * Calculate the combined width of the images + the gutters
     ****/
    function CalculateTotalWidth (Row) {
      var Image1Width = $('.growable-container-1').width();
      var Image2Width = $('.growable-container-2').width();
      var Image3Width = $('.growable-container-3').width();
      var Image4Width = $('.growable-container-4').width();
      var Image5Width = $('.growable-container-5').width();
      var Image6Width = $('.growable-container-6').width();
      var Image7Width = $('.growable-container-7').width();
      var Image8Width = $('.growable-container-8').width();
      var GutterSize = 24; // (3 gutters @ 8px each)

      if (Row == 1) {
        var RowWidth = GutterSize + Image1Width + Image2Width + Image3Width + Image4Width;
      } else {
        var RowWidth = GutterSize + Image5Width + Image6Width + Image7Width + Image8Width;
      }
      return RowWidth;
    }

  });


</script>
</body>
</html>
