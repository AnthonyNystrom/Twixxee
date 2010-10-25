<?php
/**
 * Take the user when they return from Twitter. Get access tokens.
 * Verify credentials and redirect to based on response from Twitter.
 */
session_start();
require_once("OAuth.php");
require_once("config.php");

$access_token = "https://api.twitter.com/oauth/access_token";
$sig_method = new OAuthSignatureMethod_HMAC_SHA1();

$temp_token = new OAuthConsumer($_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

$consumer = new OAuthConsumer($key, $secret);

$parsed = parse_url($access_token);
$params = array();
parse_str($parsed['query'], $params);

$acc_req = OAuthRequest::from_consumer_and_token($consumer, $temp_token, "GET", $access_token, $params);
$acc_req->sign_request($sig_method, $consumer, $temp_token);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $acc_req);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch); 

parse_str($output, $_SESSION);

$cookie = base64_encode($_SESSION['oauth_token'] . ':' . $_SESSION['oauth_token_secret']);
setcookie(COOKIE_NAME, $cookie, time()+60*60*24*7*3, '/', COOKIE_DOMAIN);

//echo "done. go do something with it.";
Header("Location: /client");
?>
