<?php
declare(strict_types=1);

    error_reporting(0);
    function createDataURI(string $file, string $mimeType = null){
        $fileContents = file_get_contents($file);
        if (!$fileContents) {
            throw new \InvalidArgumentException("File does not exist: $file");
        }
        if(!$mimeType) {
            $mimeType = mime_content_type($file);
        }
        return "data:".$mimeType.";base64,".base64_encode($fileContents);
    }
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" data-theme="dark"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" data-theme="dark"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" data-theme="dark"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" data-theme="dark"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>EPCC &mdash; Eclipse Phase (First Edition) Character Creator</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <style>
            html, body { background-color: #0f1114; color: #868f96; }
        </style>
        <style>
            <?php
            include public_path('css/vendor.css');
            include public_path('css/app.css');
            ?>
        </style>
    </head>
    <body>

        <!-- POPUP  -- DYNAMIC CONTENT -->
        <div id="loading_popup" class="loading-indicator"></div>
        <!-- MESSAGES FOR THE USER - DYNAMIC CONTENT-->
        <section id="messages"></section>
        <div id="container">
            <router-view></router-view>
        </div>

        <script>
            window.env = {};
            window.env.VITE_GOOGLE_ANALYTICS_ID = "{{config('epcc.googleAnalyticsId')}}";
            <?php
            //Load order is important here
            include public_path('js/app.js');
            include public_path('js/legacy.js');
            ?>

            $( function() {
                //NAVIGATION JQUERRY
                //class active au menu principal
                $("#main-nav li a").click(function(){
                    $(".active").removeClass("active");
                    $(this).toggleClass("active");
                    $("#tertiary_infos").css('visibility','hidden');
                    return false;
                });
            });
        </script>
    </body>
</html>
