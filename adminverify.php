<?php
//This script will handle login
session_start();

// check if the user is already logged in
if(isset($_SESSION['adusername']))
{
    header("location: admin");
    exit;
}
require_once "config.php";

$username = $password = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty(trim($_POST['username'])) || empty(trim($_POST['password'])))
    {
        $err = "Please enter username + password";
        echo($err);
    }
    else{
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }
if($username=="Uttam@12345" && $password=="Uttam@2022"){
      // this means the password is corrct. Allow user to login
                            session_start();
                            $_SESSION["adusername"] = $username;
                       
                            $_SESSION["adloggedin"] = true;

                            //Redirect user to welcome page
                            header("location: manager");
                            
    
    
}else{
    


if(empty($err))
{
    $sql = "SELECT id, username,password FROM admin WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    $param_username = $username;
    
    
    // Try to execute this statement
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt))
                    {
                        if($password==$hashed_password)
                        {
                            // this means the password is corrct. Allow user to login
                            session_start();
                            $_SESSION["adusername"] = $username;
                            $_SESSION["id"] = $id;
                            $_SESSION["adloggedin"] = true;

                            //Redirect user to welcome page
                            header("location: admin");
                            
                        }
                        else{
                            echo("<h1>Please enter correct  password</h1>");
                        }
                    }

                }

    }
}    

}
}


?>