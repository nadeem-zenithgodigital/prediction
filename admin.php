<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["adloggedin"]) || $_SESSION["adloggedin"] !== true){
    header("location: adlogin");
    exit;
}
require_once "config.php";
$opt9="SELECT COUNT(*) as total9 FROM `users` ";
$optres9=$conn->query($opt9);
$sum9= mysqli_fetch_assoc($optres9);

if($sum9['total9']==""){
    $bonus9=0;
   
}else{
    $bonus9=$sum9['total9'];
}
$opt="SELECT SUM(withdraw) as total FROM `record` WHERE status='success' ";
$optres=$conn->query($opt);
$sum= mysqli_fetch_assoc($optres);
if($sum['total']==""){
    $bonus=0;
    
}else{
    $bonus=round($sum['total'],2);
}

$opt1="SELECT SUM(recharge) as total1 FROM `recharge` WHERE status='successfull'";
$optres1=$conn->query($opt1);
$sum1= mysqli_fetch_assoc($optres1);
if($sum1['total1']==""){
    $tbal=0;
    
}else{
    $tbal=$sum1['total1'];
}
$opt10="SELECT SUM(withdraw) as total10 FROM `withdraw` WHERE status='wait'";
$optres10=$conn->query($opt10);
$sum10= mysqli_fetch_assoc($optres10);
if($sum10['total10']==""){
    $tbal0=0;
    
}else{
    $tbal0=$sum10['total10'];
}





$opt9t="SELECT COUNT(*) as total9 FROM `users` WHERE  DATE(`time`) = CURDATE() ";
$optres9t=$conn->query($opt9t);
$sum9t= mysqli_fetch_assoc($optres9t);

if($sum9t['total9']==""){
    $bonus9t=0;
   
}else{
    $bonus9t=$sum9t['total9'];
}
$optt="SELECT SUM(withdraw) as total FROM `record` WHERE status='success' AND  DATE(`created_at`) = CURDATE() ";
$optrest=$conn->query($optt);
$sumt= mysqli_fetch_assoc($optrest);
if($sumt['total']==""){
    $bonust=0;
    
}else{
    $bonust=round($sumt['total'],2);
}

$opt1t="SELECT SUM(recharge) as total1 FROM `recharge` WHERE status='success' AND  DATE(`created_at`) = CURDATE()";
$optres1t=$conn->query($opt1t);
$sum1t= mysqli_fetch_assoc($optres1t);
if($sum1t['total1']==""){
    $tbalt=0;
    
}else{
    $tbalt=$sum1t['total1'];
}
$opt10t="SELECT SUM(withdraw) as total10 FROM `recharge` WHERE status='Applying' AND  DATE(`created_at`) = CURDATE()";
$optres10t=$conn->query($opt10t);
$sum10t= mysqli_fetch_assoc($optres10t);
if($sum10t['total10']==""){
    $tbal0t=0;
    
}else{
    $tbal0t=$sum10t['total10'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ADMIN</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="admincss/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="admincss/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="index.html" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>ADMIN</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">Jhon Doe</h6>
                        <span>Admin</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="admin" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="users" class="nav-item nav-link"><i class="fa fa-th me-2"></i>users</a>
                    <a href="adpre" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Next Prediction</a>
                    <a href="adreward" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Add Reward</a>
                    <a href="inviterec" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Invite Record</a>
                    <a href="adwith" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Withdraw Request</a>
                    <a href="rechargeRequests" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Recharge Request</a>
                    <a href="upi" class="nav-item nav-link"><i class="fa fa-table me-2"></i>upi change</a>
                     <a href="adduser" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Add User</a>
                    <a href="notice" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Notice change</a>
                     <a href="gift" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Gift Card</a>
                    <a href="delete" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Delete User</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0" style="background-color: #FF5F1F !important;">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control border-0" type="search" placeholder="Search">
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                   
                
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex">John Doe</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                           
                            <a href="/logout" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->


            <!-- Sale & Revenue Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4" style="background-color: #FF00FF  !important;">
                            <i class="fa fa-chart-line fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2" style="color: white;">Todays Users/Total users: </p>
                                <h6 class="mb-0" style="color: white;"><?php echo $bonus9t ?>/<?php echo $bonus9 ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4"style="background-color: #00FF00  !important;">
                            <i class="fa fa-chart-bar fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2" style="color: white;">Todays Profit/Total Profit: </p>
                                <h6 class="mb-0" style="color: white;"><?php echo ($tbalt-$bonust)?>/ <?php echo ($tbal-$bonus)?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4"style="background-color: #0000FF  !important;">
                            <i class="fa fa-chart-area fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2" style="color: white;">Today/Total Amount Withdrawn: </p>
                                <h6 class="mb-0" style="color: white;"><?php echo $bonust?>/ <?php echo $bonus?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4"style="background-color: #FF0000  !important;">
                            <i class="fa fa-chart-pie fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2" style="color: white;">Today's/Total Withdraw pending: </p>
                                <h6 class="mb-0" style="color: white;"><?php echo $tbal0t?>/<?php echo $tbal0?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4"style="background-color: #00FFFF  !important;">
                            <i class="fa fa-chart-bar fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2" style="color: white;">Today/Total Recharge: </p>
                                <h6 class="mb-0" style="color: white;"><?php echo $tbalt?>/ <?php echo $tbal?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <br>
            
          
                 <h2 style="font-size:20px;padding:5px; color:black; text-align:center;"onclick="window.location.href='notice'"> Click Here for UPDATE Notice</h2>
                 <h2 style="font-size:20px;padding:5px; color:black; text-align:center;"onclick="window.location.href='block'"> Click Here to block user</h2>
                 <h2 style="font-size:20px;padding:5px; color:black; text-align:center;"onclick="window.location.href='unblock'"> Click Here to Unblock user</h2>
                  <h2 style="font-size:20px;padding:5px; color:black; text-align:center;"onclick="window.location.href='updateperiod'"> Click Here to UPDATE Period</h2>
                   <h2 style="font-size:20px;padding:5px; color:black; text-align:center;"onclick="window.location.href='updateotp'"> Click Here to update OTP</h2>
                   <h2 style="font-size:20px;padding:5px; color:black; text-align:center;"onclick="window.location.href='helpapprove'"> Click Here to check Quries</h2>
            <!-- Sale & Revenue End -->


            <!-- Sales Chart Start -->
       
            <!-- Sales Chart End -->


            <!-- Recent Sales End -->


            <!-- Widgets Start -->
            
            <!-- Widgets End -->


            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">Contact Developer</a> 
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                           
                            Designed By <a href="#">lovely</a>
                        
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="adminjs/main.js"></script>
</body>

</html>