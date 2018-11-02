<?
$googleKey = "AIzaSyBpYdHJXDsByckC1aeA8MThdLsGaVIh9AI";
$location = urlencode($_GET['s']);
//$url = "http://maps.google.com/maps/geo?q=$location&output=json&key=$googleKey"; 
$url = "http://maps.googleapis.com/maps/api/geocode/json?address=$location&sensor=false&$googleKey";
$response = file_get_contents($url); 
echo $response
?>