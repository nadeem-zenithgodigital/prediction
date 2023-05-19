v


<?php
/*
This file contains database configuration assuming you are running mysql using user "root" and password ""
*/
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'db_usename_name');
define('DB_PASSWORD', 'bd_password');
define('DB_NAME', 'db_usename_name');
// Try connecting to the Database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

//Check the connection
if($conn == false){
    dir('Error: Cannot connect');
}
$current = strtotime(date("Y-m-d 00:00:00"));
$now = strtotime(date("Y-m-d H:i:s"));
$firstperiodid=date('Ymd').sprintf("%03d",1);
$lastperiodid=date('Ymd',strtotime("-1 days")).sprintf("%03d",480);


$sql3 = "SELECT period,nxt FROM beconeperiod WHERE id='1'";
$result3 =$conn->query($sql3);
$row3 = mysqli_fetch_assoc($result3);
$period=$row3['period'];
$next=$row3['nxt'];
echo"$next <br>";

if($next==11){
    $opt1="SELECT SUM(amount) as total1 FROM beconebetting WHERE ans='green' AND status='pending'";
    $opt1res=$conn->query($opt1);
    $sum1 = mysqli_fetch_assoc($opt1res);
    
    
    $opt0="SELECT SUM(amount) as total0 FROM beconebetting WHERE ans='red' AND status='pending'";
    $opt0res=$conn->query($opt0);
    $sum0 = mysqli_fetch_assoc($opt0res);
    
    if($sum1['total1'] =="" AND $sum0['total0'] ==""){
            $num=rand(40000,50000);             
    }
    elseif($sum1['total1']> $sum0['total0']){
        $a=array("0","2","4","6","8");
    $random_keys=array_rand($a,1);
    $t= $a[$random_keys];
         $x=rand(40000,50000);
       $y= $x % 10;
      $num=($x-$y)+$t;
    }elseif($sum1['total1']< $sum0['total0']){
        $a=array("1","3","5","7","9");
    $random_keys=array_rand($a,1);
    $t= $a[$random_keys];
         $x=rand(40000,50000);
       $y= $x % 10;
      $num=($x-$y)+$t;
    }else{
         $num=rand(40000,50000);  
        
    }
       
        
    }else{
        $x=rand(40000,50000);
       $y= $x % 10;
      $num=($x-$y)+$next;
    }
$price=$num;

$prices= $num % 10;
$ans=$prices;
   
if($prices==0 || $prices==5){
    $res1="violet";
} else
{ 
   $res1="";  
}
$e=$ans % 2;

if($e==0){
  $res='red';

}elseif($e==1){
 $res='green';
}

$exist="SELECT COUNT(*) as betnum FROM beconebetting WHERE status='pending'";
$existres=$conn->query($exist);
$exists= mysqli_fetch_assoc($existres);


if( $exists['betnum']==0){
   
$rec="INSERT INTO beconebetrec (period,ans,num,clo,res1) VALUES ($period,$ans,$num,'$res','$res1')";
$conn->query($rec);




}else{
    
    
$addwin00="UPDATE beconebetting SET res='fail',price=$num,number=$prices,color='$res',color2='$res1' WHERE period=$period ";
$conn->query($addwin00);

$bet0q="SELECT username,amount FROM beconebetting WHERE status='pending' ";
    $betres0q=$conn->query($bet0q);
    while($row0 = mysqli_fetch_array($betres0q)){
 
    $winner0=$row0['username'];
    $fbets0= $row0['amount'];
    $b1=(30/100)*((5/100)*$fbets0);
    $b2=(20/100)*((5/100)*$fbets0);
    $b3=(10/100)*((5/100)*$fbets0);
    $uc="SELECT refcode,refcode1,refcode2 FROM users WHERE username='$winner0'";
    $ucc=$conn->query($uc);
    $getuc= mysqli_fetch_assoc($ucc);
    $r=$getuc['refcode'];
    $r1=$getuc['refcode1'];
    $r2=$getuc['refcode2'];
    if($r!=""){
        $addb1="UPDATE users SET bonus= bonus +$b1 WHERE usercode='$r'";
        $conn->query($addb1);
        $recb1="INSERT INTO bonus (giver,usercode,amount,level) VALUES ('$winner0','$r','$b1','1')";
        $conn->query($recb1);
        if($r1!=""){
            $addb2="UPDATE users SET bonus= bonus +$b2 WHERE usercode='$r1'";
            $conn->query($addb2);
            $recb2="INSERT INTO bonus (giver,usercode,amount,level) VALUES ('$winner0','$r1','$b2','2')";
            $conn->query($recb2);
            if($r2!=""){
                $addb3="UPDATE users SET bonus= bonus +$b3 WHERE usercode='$r2'";
                $conn->query($addb3);
                $recb2="INSERT INTO bonus (giver,usercode,amount,level) VALUES ('$winner0','$r2','$b3','3')";
                $conn->query($recb2);
                
                
            }
        }
    }
 
    }


switch ($prices) {

  case "1":
    $bet0="SELECT username,amount FROM beconebetting WHERE status='pending' AND ans=1";
    $betres0=$conn->query($bet0);
    while($row0 = mysqli_fetch_array($betres0)){
 
    $winner0=$row0['username'];
    $fbets0= $row0['amount'];
    $winamount0= ($fbets0-(5/100)*$fbets0)*9;
    echo $winner0;
    $addwin0="UPDATE users SET balance= balance +$winamount0 WHERE username=$winner0";
    $conn->query($addwin0);
    $addwin0="UPDATE beconebetting SET res='success' WHERE username=$winner0 AND period=$period AND ans='$prices'";
    $conn->query($addwin0);
   
 
    }
    
    break;
  case "3":
    $bet0="SELECT username,amount FROM beconebetting WHERE status='pending' AND ans=3";
    $betres0=$conn->query($bet0);
    while($row0 = mysqli_fetch_array($betres0)){
 
    $winner0=$row0['username'];
    $fbets0= $row0['amount'];
    $winamount0= ($fbets0-(5/100)*$fbets0)*9;
    echo $winner0;
    $addwin0="UPDATE users SET balance= balance +$winamount0 WHERE username=$winner0";
    $conn->query($addwin0);
    $addwin0="UPDATE beconebetting SET res='success' WHERE username=$winner0 AND period=$period AND ans='$prices'";
    $conn->query($addwin0);
  
 
    }
      break;
  case "2":
    $bet0="SELECT username,amount FROM beconebetting WHERE status='pending' AND ans=2";
    $betres0=$conn->query($bet0);
    while($row0 = mysqli_fetch_array($betres0)){
 
    $winner0=$row0['username'];
    $fbets0= $row0['amount'];
    $winamount0= ($fbets0-(5/100)*$fbets0)*9;
    echo $winner0;
    $addwin0="UPDATE users SET balance= balance +$winamount0 WHERE username=$winner0";
    $conn->query($addwin0);
    $addwin0="UPDATE beconebetting SET res='success' WHERE username=$winner0 AND period=$period AND ans='$prices'";
    $conn->query($addwin0);
   
 
    }
    break;
  case "4":
   $bet0="SELECT username,amount FROM beconebetting WHERE status='pending' AND ans=4";
     $betres0=$conn->query($bet0);
    while($row0 = mysqli_fetch_array($betres0)){
 
    $winner0=$row0['username'];
    $fbets0= $row0['amount'];
    $winamount0= ($fbets0-(5/100)*$fbets0)*9;
    echo $winner0;
    $addwin0="UPDATE users SET balance= balance +$winamount0 WHERE username=$winner0";
    $conn->query($addwin0);
    $addwin0="UPDATE beconebetting SET res='success' WHERE username=$winner0 AND period=$period AND ans='$prices'";
    $conn->query($addwin0);
   
 
    }
    break;
  case "5":
    $bet0="SELECT username,amount FROM beconebetting WHERE status='pending' AND ans=5";
    $betres0=$conn->query($bet0);
    while($row0 = mysqli_fetch_array($betres0)){
 
    $winner0=$row0['username'];
    $fbets0= $row0['amount'];
    $winamount0= ($fbets0-(5/100)*$fbets0)*9;
    echo $winner0;
    $addwin0="UPDATE users SET balance= balance +$winamount0 WHERE username=$winner0";
    $conn->query($addwin0);
    $addwin0="UPDATE beconebetting SET res='success' WHERE username=$winner0 AND period=$period AND ans='$prices'";
    $conn->query($addwin0);
    
 
    }
    break;
  case "6":
    $bet0="SELECT username,amount FROM beconebetting WHERE status='pending' AND ans=6";
    $betres0=$conn->query($bet0);
    while($row0 = mysqli_fetch_array($betres0)){
 
    $winner0=$row0['username'];
    $fbets0= $row0['amount'];
    $winamount0= ($fbets0-(5/100)*$fbets0)*9;
    echo $winner0;
    $addwin0="UPDATE users SET balance= balance +$winamount0 WHERE username=$winner0";
    $conn->query($addwin0);
    $addwin0="UPDATE beconebetting SET res='success' WHERE username=$winner0 AND period=$period AND ans='$prices'";
    $conn->query($addwin0);
    
 
    }
    break;
  case "7":
    $bet0="SELECT username,amount FROM beconebetting WHERE status='pending' AND ans=7";
    $betres0=$conn->query($bet0);
    while($row0 = mysqli_fetch_array($betres0)){
 
    $winner0=$row0['username'];
    $fbets0= $row0['amount'];
    $winamount0= ($fbets0-(5/100)*$fbets0)*9;
    echo $winner0;
    $addwin0="UPDATE users SET balance= balance +$winamount0 WHERE username=$winner0";
    $conn->query($addwin0);
    $addwin0="UPDATE beconebetting SET res='success' WHERE username=$winner0 AND period=$period AND ans='$prices'";
    $conn->query($addwin0);
   
 
    }
    break;
  case "8":
    $bet0="SELECT username,amount FROM beconebetting WHERE status='pending' AND ans=8";
    $betres0=$conn->query($bet0);
    while($row0 = mysqli_fetch_array($betres0)){
 
    $winner0=$row0['username'];
    $fbets0= $row0['amount'];
    $winamount0= ($fbets0-(5/100)*$fbets0)*9;
    echo $winner0;
    $addwin0="UPDATE users SET balance= balance +$winamount0 WHERE username=$winner0";
    $conn->query($addwin0);
    $addwin0="UPDATE beconebetting SET res='success' WHERE username=$winner0 AND period=$period AND ans='$prices'";
    $conn->query($addwin0);
   
 
    }
    break;
  case "9":
    $bet0="SELECT username,amount FROM beconebetting WHERE status='pending' AND ans=9";
    $betres0=$conn->query($bet0);
    while($row0 = mysqli_fetch_array($betres0)){
 
    $winner0=$row0['username'];
    $fbets0= $row0['amount'];
    $winamount0= ($fbets0-(5/100)*$fbets0)*9;
    echo $winner0;
    $addwin0="UPDATE users SET balance= balance +$winamount0 WHERE username=$winner0";
    $conn->query($addwin0);
    $addwin0="UPDATE beconebetting SET res='success' WHERE username=$winner0 AND period=$period AND ans='$prices'";
    $conn->query($addwin0);
   
 
    }
    break;
  case "0":
    echo"zero";
    $bet0="SELECT username,amount FROM beconebetting WHERE status='pending' AND ans='0'";
    $betres0=$conn->query($bet0);
    while($row0 = mysqli_fetch_array($betres0)){
 
    $winner0=$row0['username'];
    $fbets0= $row0['amount'];
    $winamount0= ($fbets0-(5/100)*$fbets0)*9;
    $addwin0="UPDATE users SET balance= balance+$winamount0 WHERE username=$winner0";
    $conn->query($addwin0);
    $addwin0="UPDATE beconebetting SET res='success' WHERE username=$winner0 AND period=$period AND ans='$prices'";
    $conn->query($addwin0);
   
 
   }
    break;
  default:
    echo "ERROR NO NUMBER FOUND";
}




if( $res=="red" && $res1=="" ){
    
echo"red";
$bet2="SELECT username,amount FROM beconebetting WHERE status='pending' AND ans='$res'";
$betres2=$conn->query($bet2);
while($row2 = mysqli_fetch_array($betres2)){
$winner2=$row2['username'];   
$fbets2= $row2['amount'];
$winamount2= ($fbets2-(5/100)*$fbets2)*2;
$addwin2="UPDATE users SET balance= balance+$winamount2 WHERE username=$winner2";
$conn->query($addwin2);
$addwin12="UPDATE beconebetting SET res='success',price=$num,number=$prices,color='$res',color2='$res1' WHERE username=$winner2 AND period=$period AND ans='$res'";
$conn->query($addwin12);
   
}



}elseif( $res=="green" && $res1=="" ){

echo"green"; 
$bet3="SELECT username,amount FROM beconebetting WHERE status='pending' AND ans='$res'";
$betres3=$conn->query($bet3);
while($row3 = mysqli_fetch_array($betres3)){
    
$winner3=$row3['username'];
$fbets3=$row3['amount']; 
$winamount3= ($fbets3-(5/100)*$fbets3)*2;
$addwin3="UPDATE users SET balance= balance+$winamount3 WHERE username=$winner3";
$conn->query($addwin3);
$addwin13="UPDATE beconebetting SET res='success',price=$num,number=$prices,color='$res',color2='$res1' WHERE username=$winner3 AND period=$period AND ans='$res'";
$conn->query($addwin13);
   

}

    }
if( $res=="green" && $res1=="violet"){

echo"green vio";
$bet4="SELECT username,amount FROM beconebetting WHERE status='pending' AND ans='$res'";
$betres4=$conn->query($bet4);
while($row4 = mysqli_fetch_array($betres4)){
    $winner4=$row4['username'];

$fbets4=$row4['amount']; 
$winamount4= ($fbets4-(5/100)*$fbets4)*1.5;
$addwin4="UPDATE users SET balance= balance +$winamount4 WHERE username=$winner4";
$conn->query($addwin4);
$addwin14="UPDATE beconebetting SET res='success',price=$num,number=$prices,color='$res',color2='$res1' WHERE username=$winner4 AND period=$period AND ans='$res'";
$conn->query($addwin14);
   

}


$bet1="SELECT username,amount FROM beconebetting WHERE status='pending' AND ans='violet'";
$betres1=$conn->query($bet1);
while($row1 = mysqli_fetch_array($betres1)){
    $winner1=$row1['username'];

$fbets1= $row1['amount'];
$winamount1= ($fbets1-(5/100)*$fbets1)*3;


$addwin1="UPDATE users SET balance= balance +$winamount1 WHERE username=$winner1";
$conn->query($addwin1);
$addwin11="UPDATE beconebetting SET res='success',price=$num,number=$prices,color='$res',color2='$res1' WHERE username=$winner1 AND period=$period AND ans='violet'";
$conn->query($addwin11);
   

    
}

}elseif($res=="red" && $res1=="violet"){
 
echo"red vio";
$bet5="SELECT username,amount FROM beconebetting WHERE status='pending' AND ans='$res'";
$betres5=$conn->query($bet5);
while($row5 = mysqli_fetch_array($betres5)){
  $winner5=$row5['username'];

$fbets5=$row5['amount'] ;
$winamount5= ($fbets5-((5/100)*$fbets5))*1.5;
$addwin5="UPDATE users SET balance= balance+$winamount5 WHERE username='$winner5'";
$conn->query($addwin5);
$addwin15="UPDATE beconebetting SET res='success',price=$num,number=$prices,color='$res',color2='$res1' WHERE username=$winner5 AND period=$period AND ans='$res'";
$conn->query($addwin15);
   
      
}

$bet12="SELECT username,amount FROM beconebetting WHERE status='pending' AND ans='violet'";
$betres12=$conn->query($bet12);
while($row12 = mysqli_fetch_array($betres12)){
$winner12=$row12['username'];

$fbets12=$row12['amount'] ;
$winamount12= ($fbets12-(5/100)*$fbets12)*3;

$addwin12="UPDATE users SET balance= balance+$winamount12 WHERE username=$winner12";
$conn->query($addwin12);
$addwin112="UPDATE beconebetting SET res='success',price=$num,number=$prices,color='$res',color2='$res1' WHERE username=$winner12 AND period=$period AND ans='violet'";
$conn->query($addwin112);
   


}

    }










$rec="INSERT INTO beconebetrec (period,ans,num,clo,res1) VALUES ($period,$ans,$num,'$res','$res1')";
$conn->query($rec);

}

 





















$suc="UPDATE beconebetting SET status='sucessful' WHERE status='pending'";
$conn->query($suc);

$checkperiod_Query=mysqli_query($conn,"select * from `beconeperiod` order by id desc limit 1");
$periodRow=mysqli_num_rows($checkperiod_Query);
$periodidRow=mysqli_fetch_array($checkperiod_Query);


if($lastperiodid==$periodidRow['period'])
{
  $truncateQuery=mysqli_query($conn,"TRUNCATE TABLE `beconeperiod`");
  $truncateResultQuery=mysqli_query($conn,"TRUNCATE TABLE `beconeperiod`");
    $sql19=mysqli_query($conn,"INSERT INTO `beconeperiod` (`period`,`nxt`) VALUES ('".$firstperiodid."','11')");  
}elseif($periodRow=='' OR $periodRow=='0')
{
$sql19=mysqli_query($conn,"INSERT INTO `beconeperiod` (`period`,`nxt`) VALUES ('".$firstperiodid."','11')");
	

}else 
{
$sql4 = "UPDATE beconeperiod SET period= period +'1',nxt='11' WHERE id='1'";
$conn->query($sql4);
	}

$sql1="DELETE FROM beconebet WHERE id='1'";
$sql = "INSERT INTO beconebet (id) VALUES ('1')";
                
$conn->query($sql1);
 
                
$conn->query($sql);



$conn->close();
?>