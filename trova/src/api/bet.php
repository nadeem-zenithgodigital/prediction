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
if ($action == 'info') {
	$data = array();
	$user = $_GET['user'];
	$sql1 = "SELECT balance FROM users WHERE username='$user'";
	$result1 = $conn->query($sql1);
	$row1 = mysqli_fetch_array($result1);
	$balance = round($row1['balance']);
	$sql2 = "SELECT period FROM period WHERE id=1";
	$result2 = $conn->query($sql2);
	$row2 = mysqli_fetch_array($result2);
	$period = $row2['period'];

	$opt9 = "SELECT COUNT(*) as total9 FROM `betrec` ";
	$optres9 = $conn->query($opt9);
	$sum9 = mysqli_fetch_assoc($optres9);
	$total = $sum9['total9'];

	$opt22= "SELECT COUNT(*) as total22 FROM `recharge` WHERE username='$user' ";
	$optres222 = $conn->query($opt22);
	$sum2 = mysqli_fetch_assoc($optres222);
	$total2 = $sum2['total22'];
	$opt220= "SELECT COUNT(*) as total220 FROM `betting` WHERE username='$user' ";
	$optres2220 = $conn->query($opt220);
	$sum20 = mysqli_fetch_assoc($optres2220);
	$total20 = $sum20['total220'];


	$opt = "SELECT COUNT(*) as total FROM `betting` WHERE username='$user' ";
	$optres = $conn->query($opt);
	$sum = mysqli_fetch_assoc($optres);
	$total1 = $sum['total'];
	array_push($data, ['balance' => $balance], ['total' => $total], ['period' => $period],['total1' => $total1],['rech' => $total2],['trans' => $total20]);
	echo json_encode($data);
} else if ($action == 'resultrec') {
	$end = 10;
	$page = $_GET['page'];
	$st = ($page - 1) * $end;
	$query = "SELECT * FROM betrec ORDER BY id DESC LIMIT " . $st . ',' . $end;
	$statement = $connect->prepare($query);
	$statement->execute();
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
		$data[] = $row;
	}

	echo json_encode($data);
} else if ($action == 'reward') {
	$data1 = array();
	$user = $_GET['user'];
	$sql1 = "SELECT usercode FROM users WHERE username='$user'";
	$result1 = $conn->query($sql1);
	$row1 = mysqli_fetch_array($result1);
	$user_code= $row1['usercode'];
	$end1 = 10;
	$page1 = $_GET['page1'];
	$st1 = ($page1 - 1) * $end1;
	$query = "SELECT * FROM bonus WHERE usercode='$user_code' ORDER BY id DESC LIMIT " . $st1 . ',' . $end1;
	$statement = $connect->prepare($query);
	$statement->execute();
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
		$data1[] = $row;
	}

	echo json_encode($data1);
}else if ($action == 'todaysign') {
	$user=$_GET['username'];
	$sql7 = "INSERT INTO signin (username,amount) VALUES ('$user',0)";
	$conn->query($sql7);
	$sql9="UPDATE users SET  balance = balance+0 WHERE username='$user'" ;
    $conn->query($sql9); 
}
else if ($action == 'dailysign') {
	$data = array();
	$user=$_GET['username'];
	$opt9="SELECT COUNT(*) as total9 FROM `signin` WHERE username='$user' ";
	$optres9=$conn->query($opt9);
	$sum9= mysqli_fetch_assoc($optres9);
	
	if($sum9['total9']==""){
		$days=0;
	   
	}else{
		$days=$sum9['total9'];
	}
	$opt9t="SELECT COUNT(*) as total9 FROM `signin` WHERE username='$user' AND DATE(`created`) >= NOW() - INTERVAL 1 DAY";
	$optres9t=$conn->query($opt9t);
	$sum9t= mysqli_fetch_assoc($optres9t);
	
	if($sum9t['total9']=="" || $sum9t['total9']=="0"){
		$status="Not signed in";
	   
	}else{
		$status="Had signed in";
	}
	$opt90="SELECT sum(amount) as total90 FROM `signin` WHERE username='$user' ";
	$optres90=$conn->query($opt90);
	$sum90= mysqli_fetch_assoc($optres90);
	
	if($sum90['total90']==""){
		$total=0;
	   
	}else{
		$total=$sum90['total90'];
	}
	$opt900="SELECT amount  FROM `signin` WHERE username='$user'  ORDER BY id DESC";
	$optres900=$conn->query($opt900);
	$sum900= mysqli_fetch_assoc($optres900);
	

		$tam=$sum900['amount'];;
	   
	
 
array_push($data, ['status' => $status,'days' => $days,'tam'=>$tam,'total'=>$total]);
	echo json_encode($data);
}else if ($action == 'betrec') {
	$user = $_GET['user'];
	$end1 = 10;
	$page1 = $_GET['page1'];
	$st1 = ($page1 - 1) * $end1;
	$query = "SELECT * FROM betting WHERE username='$user' ORDER BY id DESC LIMIT " . $st1 . ',' . $end1;
	$statement = $connect->prepare($query);
	$statement->execute();
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
		$data1[] = $row;
	}

	echo json_encode($data1);
}  else if ($action == 'bet') {
	$data = array();
	$user=$_POST['username'];
	$period=$_POST['period'];
	$ans=$_POST['ans'];
	$amount=$_POST['amount'];
    $sql2 ="INSERT INTO betting (username,period,ans,amount) VALUES ('$user', $period,'$ans',$amount)"; 
    $sql="UPDATE users SET  balance = balance-$amount WHERE username='$user'" ;
    $conn->query($sql); 
    $result=$conn->query($sql2);
	if($result===true){
        $status="Bet Added Successfully";
	}else{
        $status="Somthing Went Wrong";
	}   
array_push($data, ['status' => $status],['amount' => $amount],['ans' => $ans],['user' => $user]);
	echo json_encode($data);
}
else if ($action == 'withdrawal') {
	$data = array();
	$user=$_GET['user'];
	$amount=(95/100)*$_GET['amount'];
	$amount1=$_GET['amount'];
	function random_strings($length_of_string)
    {

        // String of all alphanumeric character
        $str_result = '0123456789AXYZ012345678901234567890123456789';

        // Shuffle the $str_result and returns substring
        // of specified length
        return substr(
            str_shuffle($str_result),
            0,
            $length_of_string
        );
    }

    $pre = "MGWS";
    $r = random_strings(22);


    $rand = $pre . $r;

    $sql2 ="INSERT INTO record (username,withdraw,rand) VALUES ('$user', $amount,'$rand')"; 
    $sql="UPDATE users SET  balance = balance-$amount1 WHERE username='$user'" ;
    $res1=$conn->query($sql); 
    $result=$conn->query($sql2);
    $opt="SELECT SUM(recharge) as total FROM `recharge` WHERE username='".$_SESSION['username']."'";
$optres=$conn->query($opt);
$sum= mysqli_fetch_assoc($optres);
if($sum['total']==""){
    $bonus=0;
    
}else{
    $bonus=round($sum['total'],2);
}
$opt1="SELECT SUM(amount) as total1 FROM `betting` WHERE username='".$_SESSION['username']."'";
$optres1=$conn->query($opt1);
$sum1= mysqli_fetch_assoc($optres1);
if($sum1['total1']==""){
    $bonus1=0;
    
}else{
    $bonus1=round($sum1['total1'],2);
}
 if($bonus==0){
     $status="Need first recharge to withdraw";
 }else if($bonus-$bonus1 > 0){
     $status="You need to bet".($bonus-$bonus1);
 }else if($result===true && $res1===true){
        $status="Success";
 }else{
        $status="Somthing Went Wrong";
 }   
array_push($data, ['status' => $status]);
	echo json_encode($data);
}  else if ($action == 'rechargerecord') {
	$data1 = array();
	$user = $_GET['user'];
	$end1 = 10;
	$page1 = $_GET['page1'];
	$st1 = ($page1 - 1) * $end1;
	$query = "SELECT * FROM recharge WHERE username='$user' ORDER BY id DESC LIMIT " . $st1 . ',' . $end1;
	$statement = $connect->prepare($query);
	$statement->execute();
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
		$data1[] = $row;
	}

	echo json_encode($data1);
} else if ($action == 'trans') {
	$data1 = array();
	$user = $_GET['user'];
	$end1 = 10;
	$page1 = $_GET['page1'];
	$st1 = ($page1 - 1) * $end1;
	$query = "SELECT * FROM betting WHERE username='$user' ORDER BY id DESC LIMIT " . $st1 . ',' . $end1;
	$statement = $connect->prepare($query);
	$statement->execute();
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
		$data1[] = $row;
	}

	echo json_encode($data1);
}else if ($action == 'invite') {
	$data = array();
	$username = $_GET['usercode'];
	$sql1 = "SELECT usercode FROM users WHERE username='$username'";
	$result1 = $conn->query($sql1);
	$row1 = mysqli_fetch_array($result1);
	$usercode = $row1['usercode'];
	
	$opt99 = "SELECT SUM(amount) as total99 FROM `bonus` WHERE usercode='$usercode' ";
	$optres99 = $conn->query($opt99);
	$sum99 = mysqli_fetch_assoc($optres99);
	$totalb = round($sum99['total99'],2);

	$opt9 = "SELECT COUNT(*) as total9 FROM `users` WHERE refcode='$usercode' ";
	$optres9 = $conn->query($opt9);
	$sum9 = mysqli_fetch_assoc($optres9);
	$total = $sum9['total9'];
	
	$query = "SELECT username FROM `users` WHERE refcode='$usercode'  ORDER BY id DESC ";  
$result = mysqli_query($conn, $query);  
$con=0;  
//display the retrieved result on the webpage  
while ($row2 = mysqli_fetch_array($result)) {
    $user=$row2['username'];
        $opt13="SELECT SUM(amount) as total1 FROM `betting` WHERE username='$user' ";
$optres13=$conn->query($opt13);
$sum13= mysqli_fetch_assoc($optres13);
if($sum13['total1']==""){
    $total=0;
    
}else{
    $total=$sum13['total1'];
} 
    $con=$con+$total;
    
}
	

	$opt22= "SELECT COUNT(*) as total22 FROM `users`WHERE refcode2='$usercode'";
	$optres222 = $conn->query($opt22);
	$sum2 = mysqli_fetch_assoc($optres222);
	$total2 = $sum2['total22'];


	$opt = "SELECT COUNT(*) as total FROM `users`  WHERE refcode1='$usercode' ";
	$optres = $conn->query($opt);
	$sum = mysqli_fetch_assoc($optres);
	$total1 = $sum['total'];
	$people=$total+$total1+$total2;
	array_push($data, ['bonus' => $totalb,'level1' => $total,'people' => $people,'level2' => $total1,'level3' => $total2,'con'=>$con]);
	echo json_encode($data);
} else if ($action == 'withdrawrecord') {
	$data1 = array();
	$user = $_GET['user'];
	$end1 = 10;
	$page1 = $_GET['page1'];
	$st1 = ($page1 - 1) * $end1;
	$query = "SELECT * FROM record WHERE username='$user' ORDER BY id DESC LIMIT " . $st1 . ',' . $end1;
	$statement = $connect->prepare($query);
	$statement->execute();
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
		$data1[] = $row;
	}

	echo json_encode($data1);
} else if ($action == 'inviterecord') {
	$data1 = array();
	$user = $_GET['user'];
	$end1 = 10;
	$level= $_GET['level'];
	$page1 = $_GET['page'];
	$sql3 = "SELECT usercode FROM users WHERE username='$user'";
	$result3 =$conn->query($sql3);
	$row3 = mysqli_fetch_assoc($result3);
	$usercode=$row3['usercode'];		
	$st1 = ($page1 - 1) * $end1;
	if($level==1){
		$query = "SELECT * FROM users WHERE refcode='$usercode'  ORDER BY id DESC LIMIT " . $st1 . ',' . $end1;
	}elseif($level==2){
		$query = "SELECT * FROM users WHERE refcode1='$usercode'  ORDER BY id DESC LIMIT " . $st1 . ',' . $end1;
	}elseif($level==3){
		$query = "SELECT * FROM users WHERE refcode2='$usercode'  ORDER BY id DESC LIMIT " . $st1 . ',' . $end1;
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
		$data1[] = $row;
	}

	echo json_encode($data1);
}
 else if ($action == 'bankcard') {
	$data1 = array();
	$user = $_GET['user'];

	$query = "SELECT * FROM users WHERE username='$user' ";
	$statement = $connect->prepare($query);
	$statement->execute();
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
		$data1[] = $row;
	}

	echo json_encode($data1);
}else if ($action == 'deletebankcard') {

	$user = $_GET['user'];

	$query = "UPDATE users SET account='1111111111' WHERE username='$user' ";
	$statement = $connect->prepare($query);
	$statement->execute();
	
}else if ($action == 'register') {
	$user = $_POST['username'];
	$otp=$_POST["code"];
	$ip=getenv("REMOTE_ADDR");
	$query0 =  "SELECT  username FROM verify  WHERE otp='$otp' ORDER BY id DESC";
	$result3 =$conn->query($query0);
	$row3 = mysqli_fetch_assoc($result3);
	if(isset($row3['username'])){
	$verun=$row3['username'];
	}else{
	$verun="none";
	}
	
	if($verun==$user){
		$username=$_POST['username'];
		$password=$_POST['password'];
		$refcode=$_POST['refcode'];
		$data = array();
		$opt9 = "SELECT COUNT(*) as total9 FROM `users` WHERE username = '$username' ";
	   $optres9 = $conn->query($opt9);
	   $sum9 = mysqli_fetch_assoc($optres9);
	   $usernum=$sum9['total9'];
		if($usernum==0){
			function genUserCode(){
				$str="AB1CDE2FG3HI4JK5LM6NO7PQ8RS9TU0VQXYZ".time();
				$str= str_split($str,1);
				$l = count($str);
				$user_code='';
				for($i=0;$i<8;$i++){
				$tn = rand(0,$l);
				$user_code.=$str[$tn];
				}
				
				return $user_code;
				
				}
			$user_code = genUserCode(); 
			$sql3 = "SELECT refcode,refcode1 FROM users WHERE usercode='$refcode'";
			$result3 =$conn->query($sql3);
			$row3 = mysqli_fetch_assoc($result3);
			$refcode1=$row3['refcode'];
			$refcode2=$row3['refcode1'];
			$query="INSERT INTO users (username, password, refcode,usercode,refcode1,refcode2,r_ip) VALUES ('$username','$password','$refcode','$user_code','$refcode1','$refcode2','$ip')";
			$statement = $connect->prepare($query);
			$statement->execute();
			$status="success";
			array_push($data, ['status' => $status]);
			echo json_encode($data);
		}else{
			$status="User already exists";
		array_push($data, ['status' => $status]);
		echo json_encode($data);
		}
		
		
	}else{
		
	
	
		$data = array();
		$status="Incorrect otp";
		array_push($data, ['status' => $status]);
		echo json_encode($data);
	}
	
	
}else if ($action == 'reset') {
	$user = $_POST['username'];
	$otp=$_POST["code"];

	$query0 =  "SELECT  username FROM verify  WHERE otp='$otp' ORDER BY id DESC";
	$result3 =$conn->query($query0);
	$row3 = mysqli_fetch_assoc($result3);
	if(isset($row3['username'])){
	$verun=$row3['username'];
	}else{
	$verun="none";
	}
	
	if($verun==$user){
		$username=$_POST['username'];
		$password=$_POST['password'];
	
		$data = array();
		$opt9 = "SELECT COUNT(*) as total9 FROM `users` WHERE username = '$username' ";
	   $optres9 = $conn->query($opt9);
	   $sum9 = mysqli_fetch_assoc($optres9);
	   $usernum=$sum9['total9'];
		if($usernum==1){
		
		
			$query="UPDATE users SET password='$password' WHERE username='$username'";
			$statement = $connect->prepare($query);
			$statement->execute();
			$status="success";
			array_push($data, ['status' => $status]);
			echo json_encode($data);
		}else{
			$status="User Does not exists";
		array_push($data, ['status' => $status]);
		echo json_encode($data);
		}
		
		
	}else{
		
	
	
		$data = array();
		$status="Incorrect otp";
		array_push($data, ['status' => $status]);
		echo json_encode($data);
	}
	
	
}else if ($action == 'addbankcard') {

	$user = $_GET['user'];
	$otp=$_POST["code"];
$query0 =  "SELECT  username FROM verify  WHERE otp='$otp' ORDER BY id DESC";
$result3 =$conn->query($query0);
$row3 = mysqli_fetch_assoc($result3);
if(isset($row3['username'])){
$verun=$row3['username'];
}else{
$verun="none";
}

if($verun==$user){
	
	$account=$_POST['account'];
	$name=$_POST['actualname'];
	$ifsc=$_POST['ifsc'];
	$upi=$_POST['upi'];
	$bankname=$_POST['bankname'];
	$state=$_POST['state'];
	$city=$_POST['city'];
	$address=$_POST['address'];
	$mobile=$_POST['mobile'];
	$email=$_POST['email'];
	$query = "UPDATE users SET account='$account',name='$name',ifsc='$ifsc',bankname='$bankname',state='$state',city='$city',upi='$upi',address='$address',mobile='$mobile',email='$email' WHERE username='$user' ";
	$statement = $connect->prepare($query);
	$statement->execute();
	$data = array();
	$status="success";
	array_push($data, ['status' => $status]);
	echo json_encode($data);
	
}else{
	


	$data = array();
	$status="Incorrect otp";
	array_push($data, ['status' => $status]);
	echo json_encode($data);
}
	
	
}else {
	$res['error'] = false;
	$res['message'] = "No Data Found!";
}




$conn->close();
header("Content-type: application/json");
//echo json_encode($res);
die();
