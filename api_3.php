<?php
function sign($method, $url, $data, $consumerSecret, $tokenSecret)
{
	$url = urlEncodeAsZend($url);
 
	$data = urlEncodeAsZend(http_build_query($data, '', '&'));
	$data = implode('&', [$method, $url, $data]);
 
	$secret = implode('&', [$consumerSecret, $tokenSecret]);
 
	return base64_encode(hash_hmac('sha1', $data, $secret, true));
}
 
function urlEncodeAsZend($value)
{
	$encoded = rawurlencode($value);
	$encoded = str_replace('%7E', '~', $encoded);
	return $encoded;
}
 
// REPLACE WITH YOUR ACTUAL DATA OBTAINED WHILE CREATING NEW INTEGRATION
$consumerKey = 'wjvk7lj8qhzck6x8s22kxf14hr1y8j9o';
$consumerSecret = '3zm2a5z60y50zletqvkdgds7r61sd4ut';
$accessToken = '0zpoljfbcxibwet3b31pxaefbn729a5l';
$accessTokenSecret = 'vo1w9agwwufxf5t3dimmvs6lb8vl24ct';
 
$method = 'GET';
$url = 'http://m2-demo.com/rest/V1/products/test';
 
//
$data = [
	'oauth_consumer_key' => $consumerKey,
	'oauth_nonce' => md5(uniqid(rand(), true)),
	'oauth_signature_method' => 'HMAC-SHA1',
	'oauth_timestamp' => time(),
	'oauth_token' => $accessToken,
	'oauth_version' => '1.0',
];
 
$data['oauth_signature'] = sign($method, $url, $data, $consumerSecret, $accessTokenSecret);
 
$curl = curl_init();
 
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $url,
	CURLOPT_HTTPHEADER => [
		'Authorization: OAuth ' . http_build_query($data, '', ',')
	]
]);
 
$result = curl_exec($curl);
curl_close($curl);
echo "<pre>";
print_r($result);