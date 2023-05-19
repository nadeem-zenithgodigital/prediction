<?php

require_once "config.php";

$username = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST"){
 
        $username = trim($_POST['username']);
    


if(empty($err))
{
   
$sql = "UPDATE period SET nxt=$username WHERE id='1'";

$conn->query($sql);
if ($conn->query($sql) === TRUE) {
    echo '<h1  style="text-align: center;">Prediction added sucessfully</h1>';
     header("location: adpre");
} else {
    echo '<h1  style="text-align: center;" > Does not Exists</h1>';
}
   


}
}
?>