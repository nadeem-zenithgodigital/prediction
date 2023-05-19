<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["adloggedin"]) || $_SESSION["adloggedin"] !== true){
    header("location: adlogin");
    exit;
}
require_once "config.php";
  $username=$_GET['un'];
  $amount=$_GET['am'];
  $utr=$_GET['utr'];
  $first=0;


$opt="SELECT SUM(recharge) as total FROM `recharge` WHERE username='$username' AND status='success'";
$optres=$conn->query($opt);
$sum= mysqli_fetch_assoc($optres);
if($sum['total']=="" or $sum['total']=="0"){
   
          $bonus=(20/100)*$amount;
        
   
     
          
    $win="select refcode FROM `users` WHERE  username='$username' ";
$result3 =$conn->query($win);
$row3 = mysqli_fetch_assoc($result3);
$refcode=$row3['refcode'];
$adb="UPDATE users SET balance= balance +$bonus WHERE usercode='$refcode'";
$conn->query($adb);
$addbrec="INSERT INTO bonus (giver,usercode,amount,level) VALUES ('$username','$refcode','$bonus','1')";
$conn->query($addbrec);
    
}

$addwin00="UPDATE recharge SET status='success' WHERE username='$username' AND recharge='$amount' AND utr='$utr'";
$conn->query($addwin00);

if($conn->query($addwin00)){
    
    
    $addwin0="UPDATE users SET balance= balance +($amount) WHERE username='$username'";
   
    if($conn->query($addwin0)){
        header("location: rechargeRequests");
    }
}else{
    echo"FAILED";
}
?>