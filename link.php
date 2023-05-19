<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["adloggedin"]) || $_SESSION["adloggedin"] !== true){
    header("location: adlogin");
    exit;
}
require_once "config.php";

$username = $newpassword = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty(trim($_POST['username'])) )
    {
        $err = "Please enter Amount";
        echo($err);
    }
    else{
        $username = trim($_POST['username']);
        if(empty(trim($_POST['password']))){
            $password=0;
        }else{
            $password = trim($_POST['password']); 
        }
       
         $newpassword=($username/ $password);
 function random_strings($length_of_string)
{
  
    // String of all alphanumeric character
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
  
    // Shuffle the $str_result and returns substring
    // of specified length
    return substr(str_shuffle($str_result), 
                       0, $length_of_string);
}

$user_code = random_strings(15);  
    }
$query11 = "SELECT code FROM `gift` WHERE code='$user_code'";


$result1 = mysqli_query($conn, $query11);

   if (mysqli_num_rows($result1) != 0)
   {
    header("location: gift");
    }

    else
   {
    
 

if(empty($err))
{
   
$sql = "INSERT INTO gift (amount,share,code) VALUES('$username','$newpassword','$user_code')";


if ($conn->query($sql) === TRUE) {
 
        header("location: lifafa?id=".$user_code);
} else {
   
        header("location: lifafa?id=".$user_code);
}
   


}   }
}


?>