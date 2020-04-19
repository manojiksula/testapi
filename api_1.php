<?php

// https://devdocs.magento.com/guides/v2.3/rest/list.html

$baseUrl = "http://m2-demo.com/";

$userData = array("username" => "admin", "password" => "admin@123");

$ch = curl_init($baseUrl."rest/V1/integration/admin/token");

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($userData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Content-Lenght: " . strlen(json_encode($userData))));
 
$token = curl_exec($ch);


$ch = curl_init($baseUrl."rest/V1/products/test");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . json_decode($token)));
 
$result = curl_exec($ch);
 
echo "<pre>";
print_r($result);