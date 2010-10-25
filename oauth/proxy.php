<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0

session_start();
require_once("OAuth.php");
require_once("config.php");

$sig_method = new OAuthSignatureMethod_HMAC_SHA1();

$endpoint = "http://api.twitter.com" . $_GET['endpoint'];

$params = array();

if (isset($_POST['post'])) {
	$method = "POST";
	$params = $_POST;
	//unset($params['post']);
} else {
	$method = "GET";
	$get = $_GET;
	unset($get['endpoint']);
	unset($get['oauth_token']);
	unset($get['oauth_token_secret']);
	foreach ($get as $key=>$value) {
		$endpoint .= "&" . $key . "=" . $value;
	}
	$parsed = parse_url($endpoint);
	parse_str($parsed['query'], $params);
}

$consumer = new OAuthConsumer($key, $secret);
$token = new OAuthConsumer($_GET['oauth_token'], $_GET['oauth_token_secret']);

$req = OAuthRequest::from_consumer_and_token($consumer, $token, $method, $endpoint, $params);
$req->sign_request($sig_method, $consumer, $token);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $req);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
if (isset($_POST['post'])) { curl_setopt($ch, CURLOPT_POST, true); }
$output = curl_exec($ch);
curl_close($ch); 

echo $output;

?>