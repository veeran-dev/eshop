<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <meta name="description" content="Kobster Elite">
    <meta name="author" content="Kobster">
    <link rel="shortcut icon" href="dash/favicon.ico">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="dash/dist/ui.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBAVWQfd_coykhZWXDenMNjrk46gNVfWjc&libraries=places"></script>
    <title>Kobster Elite</title>
    <style>
        #preloader{
            display: flex;
            display: -webkit-flex;
            justify-content: center;
            -webkit-justify-content: center;
            flex-direction: column;
            -webkit-flex-direction: column;
            align-items:  center;
            -webkit-align-items:  center;
            background: #ffffff;
            height: 100vh;
            transition: opacity 300ms fade-in;
        }
        #preloader span, #preloader img{
            display: block;
            margin: 16px;
            color: #323232;
        }
    </style>
    {if $mode == 'LIVE'}
        <script>
        {literal}
              (function(i, s, o, g, r, a, m) {
                 i['GoogleAnalyticsObject'] = r;
                 i[r] = i[r] || function() {
                     (i[r].q = i[r].q || []).push(arguments)
                 }, i[r].l = 1 * new Date();
                 a = s.createElement(o),
                     m = s.getElementsByTagName(o)[0];
                 a.async = 1;
                 a.src = g;
                 m.parentNode.insertBefore(a, m)
             })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
             ga('create', 'UA-68709246-1', 'auto');
             ga('send', 'pageview');
             ga('set', '& uid', {$cookie->id_customer}); // Set the user ID using signed-in user_id.
        {/literal}
        </script>
    {/if}
</head>
<body>