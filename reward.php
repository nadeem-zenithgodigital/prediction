<?php

require_once "config.php";

$username = $newpassword = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST"){
 
        $username = trim($_POST['username']);
        $newpassword = trim($_POST['password']);
    


if(empty($err))
{
   
$sql = "UPDATE users SET balance= balance+($newpassword/2) WHERE username='$username'";
$win="select refcode FROM users WHERE  username='$username' ";
$result3 =$conn->query($win);
$row3 = mysqli_fetch_assoc($result3);
$refcode=$row3['refcode'];
$addbrec="INSERT INTO bonus (giver,usercode,amount,level) VALUES ('$username','$refcode','$newpassword',4)";
$conn->query($addbrec);

$conn->query($sql);
if ($conn->query($sql) === TRUE) {
    echo '<h1  style="text-align: center;">Reward added sucessfully</h1>';
     header("location: adreward");
} else {
    echo '<h1  style="text-align: center;" >User Does not Exists</h1>';
}
   


}
}
?>