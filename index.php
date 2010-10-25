<?php
session_start();
if (!isset($_SESSION['oauth_token']) || !isset($_SESSION['oauth_token_secret'])) { 
	if (isset($_COOKIE['twixxee'])) {
		$token = explode(':', base64_decode($_COOKIE['twixxee']));
		$_SESSION['oauth_token'] = $token[0];
		$_SESSION['oauth_token_secret'] = $token[1];
		Header("Location: /client");
	}
} else {
	Header("Location: /client");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Welcome to Twixxee</title>
		<link rel="stylesheet" type="text/css" href="css/teapot.css" title="default "/>
		<link rel="alternate stylesheet" type="text/css" href="css/teapot-dark.css" title="dark"/>
		<link rel="alternate stylesheet" type="text/css" href="css/teapot-smallscreen.css" title="smallscreen"/>
		<script type="text/javascript" src="libs/jquery-1.4.2.js"></script>		
		<script type="text/javascript" src="libs/jquery-ui-1.8rc2.js"></script>
		<script type="text/javascript" src="libs/trimpath-template-1.0.38.js"></script>
		<script type="text/javascript" src="src/utils.js"></script>
		<script type="text/javascript" src="src/logger.js"></script>
		<script type="text/javascript" src="src/Tweet.js"></script>
		<script type="text/javascript" src="src/JsonApi.js"></script>
        <script type="text/javascript" src="src/PagedList.js"></script>
		<script type="text/javascript" src="src/teapot.js"></script>		
		<script type="text/javascript">
		$(function() {						
			$("#aboutLink").click( function(){
				utils.showAbout();
				return false;
			});
		});
		</script>
		<link rel="shortcut icon" href="favicon.ico" />
	</head>
	<body>
		<div class="pagecontents">
			<div class="pagehead">
				<div style="margin: 0 auto; color: #EEEEEE; padding: 15px; width: 70%">
				<p align="center" style="padding: 0 0 15px 0;"><a href="/oauth/login"><img src="img/twitter.png"></a></p>
				<p align="justify">
				Twixxee is a simple, ultra-fast Twitter client built in HTML5. The way we connect and 
				interact with Twitter is becoming increasingly diverse and as a result, compatibility, 
				dependability and usability have all taken a hit. Into this void steps Twixxee, 
				delivering a superior Twitter experience to the iPad, iPhone and a host of other 
				mobile devices and browsers without the need for a separately running app. Twixxee takes 
				advantage of HTML5's support for a wide array of visual renderings, cleaner markup and 
				better structure to run perfectly across a multitude of platforms and devices. 
				Twixxee, better Tweeting.
				</p>
				<div id="browserWarningContaint">

								<ul>
									<li><a title="Firefox" target="_blank" href="http://www.getfirefox.com"><img width="41" height="41" alt="Firefox" src="img/browserWarningFF.png"></a></li>
									<li><a title="Safari" target="_blank" href="http://www.apple.com/safari/"><img width="41" height="41" alt="Safari" src="img/browserWarningSF.png"></a></li>
									<li><a title="Chrome" target="_blank" href="http://www.google.com/chrome"><img width="41" height="41" alt="Chrome" src="img/browserWarningCH.png"></a></li>
									<li><a title="Opera" target="_blank" href="http://www.opera.com/"><img width="41" height="41" alt="Opera" src="img/browserWarningOP.png"></a></li>
								</ul>

												<p>We are currently not supporting Internet Explorer, but are working for future support. For the time being, we suggest you use one of these fine browsers:</p>

								<div id="browserWarningIcon"></div>

							</div>
				</div>
			</div>
			<div id="footer">
				<p class="copyright">
					&copy; 2010 <a href="http://7touchgroup.com/">7touch group, inc.</a>
					&nbsp;|&nbsp;
					Based upon the Open Source Project Teapot and Alex Young.
				</p>
				<p class="links">
					<a href="/about" id="aboutLink">about</a>
					&nbsp;|&nbsp;
					<a href="http://7touchgroup.com/contact">contact</a>
					&nbsp;|&nbsp;
					<a href="http://7touchgroup.com/privacy">privacy policy</a>
				</p>
				<span id="requestsremaining"></span>
			</div>
	</div>							

<div id="aboutText" style="display:none;">
	<p>
		Twixxee is a simple, ultra-fast Twitter client built in HTML5. The way we connect and 
		interact with Twitter is becoming increasingly diverse and as a result, compatibility, 
		dependability and usability have all taken a hit. Into this void steps Twixxee, 
		delivering a superior Twitter experience to the iPad, iPhone and a host of other 
		mobile devices and browsers without the need for a separately running app. Twixxee takes 
		advantage of HTML5's support for a wide array of visual renderings, cleaner markup and 
		better structure to run perfectly across a multitude of platforms and devices. 
		Twixxee, better Tweeting.   
	</p>
</div>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-282101-15']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</body>
</html>