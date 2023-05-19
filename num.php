

<?php
require_once "config.php";
$ans=rand(1,9);

function num($p) {
     echo"a";
    $bet0="SELECT username,amount FROM betting WHERE status='pending' AND ans=1";
    if($betres0==$conn->query($bet0)){
    echo "add num bet";}
    while($row0 = mysqli_fetch_array($betres0)){
 
    $winner0=$row0['username'];
    $fbets0= $row0['amount'];
    $winamount0= ($fbets0-(2/100)*$fbets0)*9;
    echo $winner0;
    $addwin0="UPDATE users SET balance= balance +$winamount0 WHERE username=$winner0";
    $conn->query($addwin0);
    $addwin0="UPDATE betting SET res='success' WHERE username=$winner0 AND period=$period AND ans='$prices'";
    $conn->query($addwin0);
   
    }
  echo $p;
}

num($ans);

?>