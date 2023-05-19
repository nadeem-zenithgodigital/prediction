<?php
include "./conn.php";
$connect = new PDO("mysql:host=localhost;dbname=db_usename_name", "db_usename_name", "bd_password");
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

$res = array('error' => false);
$action = '';
$user = '';

if (isset($_GET['action'])) {

	$action = $_GET['action'];
}
if ($action == 'getuserinfo') {
	$user = $_GET['user'];
	$sql = "SELECT id,username,usercode,ROUND(balance) AS balance FROM `users` WHERE username='$user'";
	$result = $conn->query($sql);
	$num = mysqli_num_rows($result);
	$userData = array();
	$row = $result->fetch_assoc();
	$usercode = $row['usercode'];
	array_push($userData, $row);
	$sql1 = "SELECT notice FROM notice WHERE id='1'";
	$result1 = $conn->query($sql1);
	$row1 = mysqli_fetch_array($result1);
	$notice = $row1['notice'];
	$opt = "SELECT SUM(amount) as total FROM `bonus` WHERE usercode=$usercode";
	$optres = $conn->query($opt);
	$sum = mysqli_fetch_assoc($optres);
	$bonus = round($sum['total'], 2);
	$opt9 = "SELECT COUNT(*) as total9 FROM `signin` WHERE username='$user' ";
	$optres9 = $conn->query($opt9);
	$sum9 = mysqli_fetch_assoc($optres9);

	if ($sum9['total9'] == "") {
		$bonus9 = 0;
	} else {
		$bonus9 = $sum9['total9'];
	}
	$opt9t = "SELECT COUNT(*) as total9 FROM `signin` WHERE username='$user' AND DATE(`created`) =date(now()-interval 12 hour)";
	$optres9t = $conn->query($opt9t);
	$sum9t = mysqli_fetch_assoc($optres9t);

	if ($sum9t['total9'] == "" || $sum9t['total9'] == "0") {
		$bonus9t = "Not signed in";
	} else {
		$bonus9t = "Had signed in";
	}
	array_push($userData, ['notice' => $notice], ['bonus' => $bonus],['days'=>$bonus9],['status'=>$bonus9t]);
	$res['error'] = false;
	$res['user_Data'] = $userData;
} else {
	$res['error'] = false;
	$res['message'] = "No Data Found!";
}





$conn->close();
header("Content-type: application/json");
echo json_encode($res);
die();
