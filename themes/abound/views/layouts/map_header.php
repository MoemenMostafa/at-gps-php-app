<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>atgps - fleet management system</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Fleet Management and Tracking System">
    <meta name="author" content="www.at-gps.com">
	<link href='http://fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' type='text/css'>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<?php
	  $baseUrl = Yii::app()->theme->baseUrl; 
	  $cs = Yii::app()->getClientScript();
	  Yii::app()->clientScript->registerCoreScript('jquery');
	?>
    <!-- Fav and Touch and touch icons -->
    <link rel="shortcut icon" href="<?php echo $baseUrl;?>/img/icons/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $baseUrl;?>/img/icons/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $baseUrl;?>/img/icons/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo $baseUrl;?>/img/icons/apple-touch-icon-57-precomposed.png">
	<?php  
	  $cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');
	  $cs->registerCssFile($baseUrl.'/css/bootstrap-responsive.min.css');
	  $cs->registerCssFile($baseUrl.'/css/abound.css');
	  $cs->registerCssFile($baseUrl.'/css/style-black.css');
	  

	  $cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js');
	  $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.sparkline.js');
	  $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.flot.min.js');
	  $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.flot.pie.min.js');
	  $cs->registerScriptFile($baseUrl.'/js/charts.js');
	  $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.knob.js');
	  $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.masonry.min.js');

	?>
	


  </head>
  <body>
  
  
  	<style>

		  body {
			margin: 0;
		  }

		  #loading_screen {
			background-color: #afbcc8;
			background-image: -webkit-gradient(linear, left top, left bottom, from(#dde4ea), color-stop(100%, #afbcc8));
			background-image: -moz-linear-gradient(90deg, #afbcc8 0%, #dde4ea);
			height: 100%;
			width: 100%;
			position: relative;
			z-index: 99999;
		  }

		  #loading_screen_background {
			position: absolute;
			width: 100%;
			height: 100%;
			background-image: url(themes/abound/img/bg.png);
			z-index: 0;
			-webkit-mask: -webkit-gradient(linear, left top, left bottom, from(rgba(0, 0, 0, 0)), to(black));
		  }

		  #loading_screen_logo {
			text-align: center;
			background-image: url(themes/abound/img/logo-02.png);
			background-repeat: no-repeat;
			background-position: center bottom;
			background-size: 164px;
			position: relative;
			z-index: 1;
		  }

		  #loading_screen_bars {
			width: 100%;
			text-align: center;
			margin: 0 auto;
			margin-top: 15px;
			position: relative;
			z-index: 1;
		  }

		  .loader-dot {
			display: inline-block;
			background-color: rgb(18, 71, 167);
			-webkit-box-shadow: inset 0px 1px 1px 0px rgba(0,0,0,.3);
			-moz-box-shadow: inset 0px 1px 1px 0px rgba(0,0,0,.3);
			width: 9px;
			height: 9px;
			margin-right: 8px;
			opacity: .1;
			-webkit-border-radius: 9px;
			border-radius: 9px;
			
			-webkit-box-shadow: inset 0px 1px 1px 0px rgba(0,0,0,.3);
			-moz-box-shadow: inset 0px 1px 1px 0px rgba(0,0,0,.3);
			box-shadow: inset 0px 1px 1px 0px rgba(0,0,0,.3);
			
			-webkit-animation-name: loader-dot;
			-webkit-animation-iteration-count: infinite;
			-webkit-animation-timing-function: linear;
			-webkit-animation-duration: 2s;
			-moz-animation-name: loader-dot;
			-moz-animation-iteration-count: infinite;
			-moz-animation-timing-function: linear;
			-moz-animation-duration: 2s;
		  }
		  
		  #dot1 { -webkit-animation-delay: 0s; -moz-animation-delay: 0s; }
		  #dot2 { -webkit-animation-delay: .15s; -moz-animation-delay: .15s; }
		  #dot3 { -webkit-animation-delay: .3s; -moz-animation-delay: .3s; }
		  #dot4 { -webkit-animation-delay: .45s; -moz-animation-delay: .45s; }
		  #dot5 { -webkit-animation-delay: .6s; -moz-animation-delay: .6s; margin-right: 0; }
		  
		  @-webkit-keyframes loader-dot{
			0% {opacity: .1;}
			40% {opacity: 1;}
			60% {opacity: 1;}
			100% {opacity: .1;}
		  }
		  
		  @-moz-keyframes loader-dot{
			0% {opacity: .1;}
			40% {opacity: 1;}
			60% {opacity: 1;}
			100% {opacity: .1;}
		  }


		</style>
	
	<div id="loading_screen">
	  <div id="loading_screen_background"></div>
	  <div id="loading_screen_logo" style="padding-top: 151.35999999999999px;"></div>
	  <div id="loading_screen_bars">
		<div id="dot1" class="loader-dot"></div>
		<div id="dot2" class="loader-dot"></div>
		<div id="dot3" class="loader-dot"></div>
		<div id="dot4" class="loader-dot"></div>
		<div id="dot5" class="loader-dot"></div>
	  </div>
	</div>
	

		<script>
		  var LoadingScreen = {
			start: function() {
			  var self = this;

			  if(!("webkitMask" in document.body.style)) {
				document.getElementById("loading_screen_background").style.backgroundImage = "none";
			  }

			  self._resize();
			  window.addEventListener("resize", LoadingScreen._resize, false);
			},

			stop: function() {
			  document.getElementById("loading_screen").style.display = "none";
			},

			_resize: function() {
			  var window_height = window.innerHeight;
			  document.getElementById('loading_screen').style.height
					= window_height + "px";
			  document.getElementById('loading_screen_logo').style.paddingTop
				  = (window_height * .43) + "px";
			}
		  };

		  LoadingScreen.start();
		  window.addEventListener('load', function() { LoadingScreen.stop(); }, false);
		</script>

  
  