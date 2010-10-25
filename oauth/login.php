<?php
session_start();
require_once("OAuth.php");
require_once("config.php");

$request_token = "https://api.twitter.com/oauth/request_token";
$sig_method = new OAuthSignatureMethod_HMAC_SHA1();

$consumer = new OAuthConsumer($key, $secret);

$parsed = parse_url($request_token);
$params = array();
parse_str($parsed['query'], $params);

$req_req = OAuthRequest::from_consumer_and_token($consumer, NULL, "GET", $request_token, $params);
$req_req->sign_request($sig_method, $consumer, NULL);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $req_req);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch); 

parse_str($output);

/* Save temporary credentials to session. */
$_SESSION['oauth_token'] = $oauth_token;
$_SESSION['oauth_token_secret'] = $oauth_token_secret;

//authorize
$auth_url = "https://api.twitter.com/oauth/authenticate?oauth_token=$oauth_token";
Header("Location: $auth_url");

?>
