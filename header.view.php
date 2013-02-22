<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>phpDoc in the cloud - generate phpDoc from GitHub repos</title>
  <meta name="description" content="Generate and host your phpDoc code documentation in the cloud">
  <meta name="keywords" content="phpdoc, phpdocs, phpdocumentor, continuous documentation, continuous integration">

  <meta name="viewport" content="width=device-width">

  <link rel="stylesheet" href="/assets/css/bootstrap.css">
  <link rel="stylesheet" href="/assets/css/main.css">
  
  <script type="text/javascript">
  function trackOutboundLink(link, category, action, label, value) { 
    try { 
      _gaq.push(['_trackEvent', category , action, label, value]); 
    } catch(err){}

    setTimeout(function() {
      document.location.href = link.href;
    }, 100);
  }
  </script>

  <script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php print GA_ID ?>']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
  </script>
</head>
<body>
