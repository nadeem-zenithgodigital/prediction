<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["adloggedin"]) || $_SESSION["adloggedin"] !== true){
    header("location: adlogin");
    exit;
}
require_once "config.php";
   
                      
                        
$query =  "SELECT  * FROM recharge ORDER BY id DESC ";


// result for method one
$result1 = mysqli_query($conn, $query);

// result for method two 
$result2 = mysqli_query($conn, $query);
$rowcount=mysqli_num_rows($result2);
    

$dataRow = "";

while($row2 = mysqli_fetch_array($result2))
{
  
    $dataRow = $dataRow."<tr class='user' ><td >$row2[1]</td><td>$row2[2]</td><td>$row2[3]</td><td>$row2[5]</td></tr>";
}


?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body {
    font-family: "Lato", sans-serif;
  }
  
  .sidenav {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    background-color: #111;
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 60px;
  }
  
  .sidenav a {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 25px;
    color: #818181;
    display: block;
    transition: 0.3s;
  }
  
  .sidenav a:hover {
    color: #f1f1f1;
  }
  
  .sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 36px;
    margin-left: 50px;
  }
  
  #main {
    transition: margin-left .5s;
    padding: 16px;
  }
  
  @media screen and (max-height: 450px) {
    .sidenav {padding-top: 15px;}
    .sidenav a {font-size: 18px;}
  }
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  overflow: hidden;

}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
#searchbar{
     margin-left: 15%;
     padding:15px;
     border-radius: 10px;
   }
 
   input[type=text] {
      width: 30%;
      -webkit-transition: width 0.15s ease-in-out;
      transition: width 0.15s ease-in-out;
   }

</style>
</head>
<body>
 <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; </span>

  <div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="admin" class="active" >Admin</a>
   <a href="users"  >Users</a>
  <a href="adduser">add User</a>
  <a href="inviterec">Invite Record</a>
  <a href="adpass">Password Change </a>
  <a href="adwith">Withdraw Requests</a>
  <a href="adpre">Next Predition</a>
  <a href="adreward">Reward Management</a>
  <a href="rechargeRequests">Recharge Requests</a>
  <a href="delete">Delete User</a>
  <a href="adlogout">Log Out</a>


</div>
 <input id="searchbar" onkeyup="search()" type="text"
        name="search" placeholder="Search by username">
        <h2 style="font-size:20px;padding:5px;  text-align:center;">Recharge Record</h2>
        <h2 style="font-size:20px;padding:5px; color:grey; text-align:center;" onclick="window.location.href='withrecord';">Withdraw Record</h2>
<div>
  <table style="background-color: White;">
    <tr>
        
        <th>Username</th>
        <th>Amount</th>
        <th>Status</th>
      <th>upi id</th>
      
    </tr>
    
    <?php echo $dataRow;?>

</table>
</div>

<script>
   function openNav() {
      document.getElementById("mySidenav").style.width = "250px";
      document.getElementById("main").style.marginLeft = "250px";
    }
    
    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
      document.getElementById("main").style.marginLeft= "0";
    }
// JavaScript code
function search() {
	let input = document.getElementById('searchbar').value
	input=input.toLowerCase();
	let x = document.getElementsByClassName('user');
	
	for (i = 0; i < x.length; i++) {
		if (!x[i].innerHTML.toLowerCase().includes(input)) {
			x[i].style.display="none";
		}
		else {
			x[i].style.display="";				
		}
	}
}

</script>

</body>
</html>
