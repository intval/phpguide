<!DOCTYPE HTML>
<html>
    <head>
    <meta charset="utf-8">


    <!--[if ie]><meta content='IE=8' http-equiv='X-UA-Compatible'/><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>תכנות מונחה עצמים מאפס ב-PHP</title>


    <!-- StileSheet -->
    <!-- Google Fonts -->

    <link rel="stylesheet" type="text/css" href="/static/oopbook/css/style.css" />
    <link rel="stylesheet" type="text/css" href="/static/oopbook/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="/static/oopbook/css/bootstrap-responsive.css" />

    <!--[if lt IE 9]>
    <link rel="stylesheet" type="text/css" href="/static/oopbook/css/fallback.css" />
    <![endif]-->

    <!--[if lt IE 10]>
    <link rel="stylesheet" type="text/css" href="/static/oopbook/css/style_ie.css" />
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="/static/oopbook/css/my.css" />

    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    <?php $this->addScripts('plugins', 'ui', 'analytics', 'salespageAnalytics'); ?>

        <!-- End Head -->
</head>


<!-- Start Body -->
<body dir='rtl' >



<!-- Block Home -->

<div class="home blockhome" id="home">

    <!-- Logo -->

    <div style="text-align: center;">

        <a href="/" title=""><img src="http://phpguide.co.il/static/images/logo.backup.jpg" alt="logo"/></a>
    </div>



    <?= $content ?>



</div><!-- End Block Home -->

    <script type="text/javascript" >
        function StartAnalytics(product)
        {
            new SalesPageAnalytics(product, Analytics);
        }
    </script>

</body>
</html>