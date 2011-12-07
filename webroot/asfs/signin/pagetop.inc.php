<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>ASFS Sign-In Sheet</title>
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<!--
		<html manifest="cache.manifest">
		<meta name="viewport" content="user-scalable=no, width=device-width" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
-->			
		<meta name="viewport" content="width=device-width">
		
		<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
		<link rel="apple-touch-icon" href="images/apple-touch-icon.png"/>
		<link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon.png"/> 
		<script type="text/javascript" src="js/jquery/1.4.2/jquery.min.js"></script>
		<script type="text/javascript" src="js/jqueryui/1.8.2/jquery-ui.min.js"></script>
		<script type="text/javascript" src="js/jquery/jquery.scrollTo-1.4.2-min.js"></script>
		<script type="text/javascript" src="js/main.js"></script>
		<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.1.pack.js"></script>
		<script type="text/javascript" src="js/bookmark_bubble.js"></script>
		<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.9.0/build/calendar/assets/skins/sam/calendar.css">
		<link rel="stylesheet" href="fancybox/jquery.fancybox-1.3.1.css" type="text/css" media="screen" />
		<script src="http://yui.yahooapis.com/2.9.0/build/yahoo-dom-event/yahoo-dom-event.js"></script>
		<script src="http://yui.yahooapis.com/2.9.0/build/calendar/calendar-min.js"></script>
		<?php
		if (isset($scriptFiles)) {
			foreach($scriptFiles as $scriptFile) {
			echo '<script type="text/javascript" src="' . $scriptFile . '"></script>';
			}
		}
		?>
		<link rel="stylesheet" type="text/css" media="screen" href="style/main.css" />
		<script>
		
			function blockMove(event) {
				// Tell Safari not to move the window.
				event.preventDefault() ;
			}
			
			function setupIOSScaling() {
				if (navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i)) {
				  var viewportmeta = document.querySelector('meta[name="viewport"]');
				  if (viewportmeta) {
				    viewportmeta.content = 'width=device-width, minimum-scale=1.0, maximum-scale=1.0';
				    document.body.addEventListener('gesturestart', function() {
				      viewportmeta.content = 'width=device-width, minimum-scale=0.25, maximum-scale=1.6';
				    }, false);
				  }
				}
			}
			
		</script>

	</head>
<!--
	<body ontouchmove="blockMove(event);">
-->
	<body>
		<div id="header">
		</div>
		<div id="main" class="yui-skin-sam">
