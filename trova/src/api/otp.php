<?php
require_once "conn.php";
if (isset($_SERVER['HTTP_ORIGIN'])) {
	// Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
	// you want to allow, and if so:
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 1000');
}
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
		// may also be using PUT, PATCH, HEAD etc
		header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
	}

	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
		header("Access-Control-Allow-Headers: Accept, Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token, Authorization");
	}
	exit(0);
}

$sqlr = "SELECT api FROM otp WHERE id='1'";
$resultr = $conn->query($sqlr);
$rowr = mysqli_fetch_array($resultr);
$api=$rowr['api'];
if(isset($_GET['num'])){
function genOtp(){
   

    $tn = rand(500000,600000);
    $otp=$tn;
    
    return $otp;
    
    }
  
$otp= genOtp(); 

$num=$_GET["num"];

$rec="INSERT INTO verify (username,otp) VALUES ('$num','$otp')";
$conn->query($rec);
	$opt9 = "SELECT COUNT(*) AS num FROM `verify` WHERE username='$num' AND time >= now() - interval 5 minute ";
	$optres9 = $conn->query($opt9);
	$sum9 = mysqli_fetch_assoc($optres9);
	$totalnum = $sum9['num'];
if (true){
   $fields = array(
    "variables_values" => "$otp",
    "route" => "otp",
    "numbers" => "$num",
);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode($fields),
  CURLOPT_HTTPHEADER => array(
      "authorization: pBj1986StRgm0FxyaQkUKDYCANiucJwsTqf7PhbeVMn2XvOHdWUpI1ohdklOnTxvDSLjBu8mbNF0sG9Q",
    "accept: */*",
    "cache-control: no-cache",
    "content-type: application/json"
  ),
));

$response=curl_exec($curl);
$err = curl_error($curl);

curl_close($curl); 
}


if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
}
?>