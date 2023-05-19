<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["adloggedin"]) || $_SESSION["adloggedin"] !== true){
    header("location: adlogin");
    exit;
}
require_once "config.php";

  $id=$_GET['id'];
  
$addwin00="UPDATE help SET status='success' WHERE id='$id'";
$conn->query($addwin00);
if($conn->query($addwin00)){

        header("location: helpapprove");
    
}else{
    echo"FAILED";
}
?>