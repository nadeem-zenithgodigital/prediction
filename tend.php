<?php
session_start();
 

   require_once "config.php";
   
   session_start();
 
// Check if the user is logged in, if not then redirect him to login page

 require_once "config.php";

                       

//retrieve the selected results from database   
$query2 = "SELECT clo FROM betrec WHERE  DATE(`time`) = CURDATE() ORDER BY id DESC   ";  
$result2 = mysqli_query($conn, $query2);  
  $a=array();
//display the retrieved result on the webpage  
while ($row2 = mysqli_fetch_array($result2)) { 
    
array_push($a," $row2[0]");
   
    
}
$query1 = "SELECT period ,ans FROM betrec WHERE  DATE(`time`) = CURDATE() ORDER BY id DESC ";  
$result1 = mysqli_query($conn, $query1);  
   $a1=array();
   $a2=array();
//display the retrieved result on the webpage  
while ($row12 = mysqli_fetch_array($result1)) { 
    
array_push($a1," $row12[period]");
array_push($a2," $row12[ans]");
   
    
}
  




$i=0;
while($i < count($a)){
    if($a[$i]!=$a[$i+1]){
        $p=substr($a1[$i], -3);
        
        $n=$a2[$i];
        if($n==5 or $n==0){
            $c="violet-".trim($a[$i]);
        }else{
            $c=trim($a[$i]);
        }
        //1row
        	 $dataRow11 = $dataRow11."<div class='cell border'>
                <div class='item-$c'>
                    $p
                </div>
            </div>";
             $dataRow12 = $dataRow12."<div class='cell border'>
                <div class='item-$c'>
                    $n
                </div>
            </div>";
        //2row
            $dataRow21 = $dataRow21."<div class='cell border'>
                <div class='item-null'>
                   
                </div>
            </div>";
             $dataRow22 = $dataRow22."<div class='cell border'>
                <div class='item-null'>
                 
                </div>
            </div>";
        //3row    
             $dataRow31 = $dataRow31."<div class='cell border'>
                <div class='item-null'>
                   
                </div>
            </div>";
             $dataRow32 = $dataRow32."<div class='cell border'>
                <div class='item-null'>
                 
                </div>
            </div>";
        //4row    
             $dataRow41 = $dataRow41."<div class='cell border'>
                <div class='item-null'>
                   
                </div>
            </div>";
             $dataRow42 = $dataRow42."<div class='cell border'>
                <div class='item-null'>
                 
                </div>
            </div>";
        $i++;
    }
    if($a[$i+1] && $a[$i]==$a[$i+1]){
         $p=substr($a1[$i], -3);
       
          $n=$a2[$i];
          if($n==5 or $n==0){
            $c="violet-".trim($a[$i]);
        }else{
            $c=trim($a[$i]);
        }
        	 $dataRow11 = $dataRow11."<div class='cell border'>
                <div class='item-$c'>
                    $p
                </div>
            </div>";
             $dataRow12 = $dataRow12."<div class='cell border'>
                <div class='item-$c'>
                    $n
                </div>
            </div>";
            
            
            
            
        while($a[$i+1] && $a[$i]==$a[$i+1]){
            $i++;
            $p=substr($a1[$i], -3);
       
          $n=$a2[$i];
          if($n==5 or $n==0){
            $c="violet-".trim($a[$i]);
        }else{
            $c=trim($a[$i]);
        }
        	 $dataRow21 = $dataRow21."<div class='cell border'>
                <div class='item-$c'>
                    $p
                </div>
            </div>";
             $dataRow22 = $dataRow22."<div class='cell border'>
                <div class='item-$c'>
                    $n
                </div>
            </div>";
            
            
            
        while($a[$i+1] && $a[$i]==$a[$i+1]){
            
            $i++;
             $dataRow31 = $dataRow31."<div class='cell border'>
                <div class='item-null'>
                   
                </div>
            </div>";
             $dataRow32 = $dataRow32."<div class='cell border'>
                <div class='item-null'>
                 
                </div>
            </div>";
             $p=substr($a1[$i], -3);
       
          $n=$a2[$i];
          if($n==5 or $n==0){
            $c="violet-".trim($a[$i]);
        }else{
            $c=trim($a[$i]);
        }
        	 $dataRow31 = $dataRow31."<div class='cell border'>
                <div class='item-$c'>
                    $p
                </div>
            </div>";
             $dataRow32 = $dataRow32."<div class='cell border'>
                <div class='item-$c'>
                    $n
                </div>
            </div>";
            
        while($a[$i+1] && $a[$i]==$a[$i+1]){
            
            $i++;
            
        }
            
        }
            
        }
       $i++;
    }
    
}



function getdata($row){
    global $a;
    global $a2;
    $i=1;
   
     while($i <= $row){
         echo" <div class='row'> <div class='index'>
                                        $i
                                    </div>"; 
                                   
                                    $g=0;
                                 

                                    while($g < (count($a)/$row)){
                                        $q=($g*$row)+$i-1;
                                        
                                        $n=$a2[$q];
                                        if($n==5 or $n==0){
                                                    $c="violet-".trim($a[$q]);
                                                      }else{
                                                         $c=trim($a[$q]);
                                                            }
        
                                         echo"<div class='cell border'>
                                        <div class='item-$c'>
                                        $n
                                        </div>
                                        </div>";
                                     
                                       $g++;
            
                                    }
                                   
                                    echo"</div>";
                                    $i++;
}

}
 
// Initialize the session
   $sql3 = "SELECT period FROM period WHERE id='1'";
    $result3 =$conn->query($sql3);
    $row3 = mysqli_fetch_assoc($result3);
    $perio=$row3['period'];
    $p=($perio-1);
     $sql = "SELECT * FROM betrec WHERE period=$p";
   $result =$conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    $period=$p;
    $price=$row['num'];
    $result=$row['ans'];
    if($result % 2==0){
       $c="red"; 
    }else{
         $c="green"; 
    }
    
    $opt11="SELECT COUNT(*) as total11 FROM `betrec` WHERE clo='green' AND DATE(`time`) = CURDATE()";
$optres11=$conn->query($opt11);
$sum11= mysqli_fetch_assoc($optres11);

if($sum11['total11']==""){
    $bonus11=0;
   
}else{
    $bonus11=$sum11['total11'];
}

 $opt12="SELECT COUNT(*) as total12 FROM `betrec` WHERE clo='red' AND DATE(`time`) = CURDATE()";
$optres12=$conn->query($opt12);
$sum12= mysqli_fetch_assoc($optres12);

if($sum12['total12']==""){
    $bonus12=0;
   
}else{
    $bonus12=$sum12['total12'];
}

 $opt13="SELECT COUNT(*) as total13 FROM `betrec` WHERE res1='violet' AND DATE(`time`) = CURDATE()";
$optres13=$conn->query($opt13);
$sum13= mysqli_fetch_assoc($optres13);

if($sum13['total13']==""){
    $bonus13=0;
   
}else{
    $bonus13=$sum13['total13'];
}
    ?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>567bet</title>
    <link href="/css/app.5d712b158b516e760fbff54839dedd12.css" rel="stylesheet">
</head>

<body class="">
    <div id="app">
        <div class="layout-content">
            <div class="parity-content">
                <div class="van-nav-bar van-hairline--bottom" style="z-index: 1;">
                    <div class="van-nav-bar__left"></div>
                    <div class="van-nav-bar__title van-ellipsis">Parity Record</div>
                    <div class="van-nav-bar__right"></div>
                </div>
                <div>
                    <div class="kline">
                        <div class="reservation-chunk">
                            <div class="reservation-chunk-sub">
                                <div class="reservation-chunk-sub-title">
                                    Period
                                </div>
                                <div class="reservation-chunk-sub-num">
                                    <?php echo $perio; ?>
                                </div>
                            </div>
                            <div class="reservation-chunk-sub" style="text-align: right;">
                                <div class="reservation-chunk-sub-title">
                                    Count Down
                                </div>
                                <div class="reservation-chunk-sub-num">
                                    <!---->
                                    <div id="demo" class="time">
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kline">
                        <div class="reservation-chunk">
                            <div class="reservation-chunk-sub">
                                <div class="reservation-chunk-sub-title">
                                    PrePeriod
                                </div>
                                <div class="reservation-chunk-sub-num">
                                    <?php echo $period; ?>
                                </div>
                            </div>
                            <div class="reservation-chunk-sub" style="text-align: center;">
                                <div class="reservation-chunk-sub-title">
                                    Result
                                </div>
                                <div class="reservation-chunk-sub-num">
                                    <div class="item-<?php echo $c; ?>" style="margin: 5px 0px 0px 35px;">
                                      <?php echo $result; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="reservation-chunk-sub" style="text-align: right;">
                                <div class="reservation-chunk-sub-title">
                                    OpenPrice
                                </div>
                                <div class="reservation-chunk-sub-num">
                                    <div style="color: rgb(232, 57, 241);">
                                        <?php echo $price; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kline">
                        <div class="title">
                            <div class="red">
                                Red:<?php echo $bonus12; ?>
                            </div>
                            <div class="green">
                                Green:<?php echo $bonus11; ?>
                            </div>
                            <div class="violet">
                                Violet:<?php echo $bonus13; ?>
                            </div>
                        </div>
                        <div class="switchBox"><button id="bper" class="van-button van-button--small van-button--default" onclick="per()"><span
                                    class="van-button__text">ShowPeriod</span></button> <button
                                    onclick="num()" id="bnum"
                                class="van-button van-button--small van-button--primary"><span
                                    class="van-button__text">ShowOpenNum</span></button></div>
                        <div id="num" class="box">
                            <div class="grid">
                                <div class="row">
                                    <div class="index">
                                        1
                                    </div>
                                    <?php echo $dataRow12; ?>
                                    
                                </div>
                                 <div class="row">
            <div class="index">
                2
            </div>
            <?php echo $dataRow22; ?>
        </div>
         <div class="row">
            <div class="index">
                3
            </div>
            <?php echo $dataRow32; ?>
        </div>
        <div class="row">
            <div class="index">
                4
            </div>
            <?php echo $dataRow42; ?>
        </div>
                                
                              
                            </div>
                        </div>
                        <div id="per" style="display:none;" class="box">
    <div class="grid">
        <div class="row">
            <div class="index">
                1
            </div>
            <?php echo $dataRow11; ?>
        </div>
         <div class="row">
            <div class="index">
                2
            </div>
            <?php echo $dataRow21; ?>
        </div>
         <div class="row">
            <div class="index">
                3
            </div>
            <?php echo $dataRow31; ?>
        </div>
        <div class="row">
            <div class="index">
                4
            </div>
            <?php echo $dataRow41; ?>
        </div>
       
    </div>
</div>
                    </div>
                    <div class="kline">
                        <div class="top-selete">
                            <div id="3" onclick="a3a()" class="top-selete-sub active">
                                Rd.3
                            </div>
                            <div id="4" onclick="a4a()" class="top-selete-sub">
                                Rd.4
                            </div>
                            <div id="5" onclick="a5a()" class="top-selete-sub">
                                Rd.5
                            </div>
                            <div id="6" onclick="a6a()" class="top-selete-sub">
                                Rd.6
                            </div>
                            <div id="7" onclick="a7a()" class="top-selete-sub">
                                Rd.7
                            </div>
                            <div id="8" onclick="a8a()" class="top-selete-sub">
                                Rd.8
                            </div>
                        </div>
                        <div id="3box" class="box">
                            <div class="grid">
                                <?php echo getdata(3); ?> 
                                
                            </div>
                        </div>
                        <div id="4box" style="display:none;" class="box">
                            <div class="grid">
                                <?php echo getdata(4); ?> 
                                
                            </div>
                        </div>
                        <div id="5box" style="display:none;" class="box">
                            <div class="grid">
                                <?php echo getdata(5); ?> 
                                
                            </div>
                        </div>
                        <div id="6box" style="display:none;" class="box">
                            <div class="grid">
                                <?php echo getdata(6); ?> 
                                
                            </div>
                        </div>
                        <div id="7box" style="display:none;" class="box">
                            <div class="grid">
                                <?php echo getdata(7); ?> 
                                
                            </div>
                        </div>
                        <div id="8box" style="display:none;" class="box">
                            <div class="grid">
                                <?php echo getdata(8); ?> 
                                
                            </div>
                        </div>
                        
                    </div>
                    <div class="kline">
                        <div class="box">
                            <div class="van-cell-group van-hairline--top-bottom">
                                <div class="van-cell">
                                    <div class="van-cell__value van-cell__value--alone">
                                        <div class="van-progress"><span class="van-progress__portion"
                                                style="background: rgb(245, 40, 39); width: 160.32px;"><span
                                                    class="van-progress__pivot"
                                                    style="left: 137.28px; background: rgb(245, 40, 39);">Red:<?php echo trim($bonus12); ?></span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="van-cell">
                                    <div class="van-cell__value van-cell__value--alone">
                                        <div class="van-progress"><span class="van-progress__portion"
                                                style="background: rgb(21, 114, 57); width: 170.34px;"><span
                                                    class="van-progress__pivot"
                                                    style="left: 141.27px; background: rgb(21, 114, 57);">Green:<?php echo trim($bonus11); ?></span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="van-cell">
                                    <div class="van-cell__value van-cell__value--alone">
                                        <div class="van-progress"><span class="van-progress__portion"
                                                style="background: rgb(232, 57, 241); width: 60.12px;"><span
                                                    class="van-progress__pivot"
                                                    style="left: 51.3px; background: rgb(232, 57, 241);">Violet:<?php echo trim($bonus13);?></span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="van-cell">
                                    <div class="van-cell__value van-cell__value--alone">
                                        <div class="van-progress"><span class="van-progress__portion"
                                                style="background: rgb(0, 122, 204); width: 26.72px;"><span
                                                    class="van-progress__pivot"
                                                    style="left: 23.84px; background: rgb(0, 122, 204);">0:28</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="van-cell">
                                    <div class="van-cell__value van-cell__value--alone">
                                        <div class="van-progress"><span class="van-progress__portion"
                                                style="background: rgb(0, 122, 204); width: 33.4px;"><span
                                                    class="van-progress__pivot"
                                                    style="left: 29.8px; background: rgb(0, 122, 204);">1:34</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="van-cell">
                                    <div class="van-cell__value van-cell__value--alone">
                                        <div class="van-progress"><span class="van-progress__portion"
                                                style="background: rgb(0, 122, 204); width: 23.38px;"><span
                                                    class="van-progress__pivot"
                                                    style="left: 20.86px; background: rgb(0, 122, 204);">2:24</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="van-cell">
                                    <div class="van-cell__value van-cell__value--alone">
                                        <div class="van-progress"><span class="van-progress__portion"
                                                style="background: rgb(0, 122, 204); width: 30.06px;"><span
                                                    class="van-progress__pivot"
                                                    style="left: 26.82px; background: rgb(0, 122, 204);">3:31</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="van-cell">
                                    <div class="van-cell__value van-cell__value--alone">
                                        <div class="van-progress"><span class="van-progress__portion"
                                                style="background: rgb(0, 122, 204); width: 30.06px;"><span
                                                    class="van-progress__pivot"
                                                    style="left: 26.82px; background: rgb(0, 122, 204);">4:30</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="van-cell">
                                    <div class="van-cell__value van-cell__value--alone">
                                        <div class="van-progress"><span class="van-progress__portion"
                                                style="background: rgb(0, 122, 204); width: 30.06px;"><span
                                                    class="van-progress__pivot"
                                                    style="left: 26.82px; background: rgb(0, 122, 204);">5:31</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="van-cell">
                                    <div class="van-cell__value van-cell__value--alone">
                                        <div class="van-progress"><span class="van-progress__portion"
                                                style="background: rgb(0, 122, 204); width: 36.74px;"><span
                                                    class="van-progress__pivot"
                                                    style="left: 32.78px; background: rgb(0, 122, 204);">6:35</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="van-cell">
                                    <div class="van-cell__value van-cell__value--alone">
                                        <div class="van-progress"><span class="van-progress__portion"
                                                style="background: rgb(0, 122, 204); width: 36.74px;"><span
                                                    class="van-progress__pivot"
                                                    style="left: 32.78px; background: rgb(0, 122, 204);">7:36</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="van-cell">
                                    <div class="van-cell__value van-cell__value--alone">
                                        <div class="van-progress"><span class="van-progress__portion"
                                                style="background: rgb(0, 122, 204); width: 33.4px;"><span
                                                    class="van-progress__pivot"
                                                    style="left: 29.8px; background: rgb(0, 122, 204);">8:34</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="van-cell">
                                    <div class="van-cell__value van-cell__value--alone">
                                        <div class="van-progress"><span class="van-progress__portion"
                                                style="background: rgb(0, 122, 204); width: 30.06px;"><span
                                                    class="van-progress__pivot"
                                                    style="left: 26.82px; background: rgb(0, 122, 204);">9:30</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="/static/js/manifest.2ae2e69a05c33dfc65f8.js"></script>
    <script type="text/javascript" src="/static/js/vendor.656e947823cf7884258e.js"></script>
    <script type="text/javascript" src="/static/js/app.9024e67d906b6dca91e5.js"></script>
    <div class="van-toast van-toast--middle van-toast--loading" style="z-index: 2001; display: none;">
        <div class="van-loading van-loading--circular van-toast__loading"><span
                class="van-loading__spinner van-loading__spinner--circular"><svg viewBox="25 25 50 50"
                    class="van-loading__circular">
                    <circle cx="50" cy="50" r="20" fill="none"></circle>
                </svg></span></div>
        <div class="van-toast__text">Loading...</div>
    </div>
    <script>
    function time(){
        var countDownDate = Date.parse(new Date) / 1e3;
  var now = new Date().getTime();
  var distance = 180 - countDownDate % 180;
  //alert(distance);
  var i = distance / 60,
   n = distance % 60,
   o = n / 10,
   s = n % 10;
  var minutes = Math.floor(i);
  var seconds = ('0'+Math.floor(n)).slice(-2);
  var sec1= (seconds%100-seconds%10)/10;
var sec2=seconds%10;
  document.getElementById("demo").innerHTML = "<span class='time-sub'>0</span><span class='time-sub'>"+Math.floor(minutes)+"</span><span class='time-sub-dot'>:</span><span class='time-sub'>"+sec1+"</span><span class='time-sub'>"+sec2+"</span>";
    }
                        var interval = setInterval(time, 1000);
                        
                        function num(){
                            document.getElementById("bnum").className="van-button van-button--small van-button--primary"
                             document.getElementById("bper").className="van-button van-button--small van-button--default"
                             document.getElementById("num").style.display=""
                             document.getElementById("per").style.display="none"
                        }
                        function per(){
                            document.getElementById("bnum").className="van-button van-button--small van-button--default"
                             document.getElementById("bper").className="van-button van-button--small van-button--primary"
                             document.getElementById("num").style.display="none"
                             document.getElementById("per").style.display=""
                        }
                        
                        
                        function a3a(){
                           document.getElementById("3").className="top-selete-sub active"; 
                           document.getElementById("4").className="top-selete-sub"; 
                           document.getElementById("5").className="top-selete-sub"; 
                           document.getElementById("6").className="top-selete-sub"; 
                           document.getElementById("7").className="top-selete-sub"; 
                           document.getElementById("8").className="top-selete-sub"; 
                           document.getElementById("3box").style.display="";
                           document.getElementById("4box").style.display="none"; 
                           document.getElementById("5box").style.display="none"; 
                           document.getElementById("6box").style.display="none";
                           document.getElementById("7box").style.display="none"; 
                           document.getElementById("8box").style.display="none"; 
                        }
                        
                        function a4a(){
                             document.getElementById("3").className="top-selete-sub"; 
                           document.getElementById("4").className="top-selete-sub active"; 
                           document.getElementById("5").className="top-selete-sub"; 
                           document.getElementById("6").className="top-selete-sub"; 
                           document.getElementById("7").className="top-selete-sub"; 
                           document.getElementById("8").className="top-selete-sub"; 
                           document.getElementById("3box").style.display="none";
                           document.getElementById("4box").style.display=""; 
                           document.getElementById("5box").style.display="none"; 
                           document.getElementById("6box").style.display="none";
                           document.getElementById("7box").style.display="none"; 
                           document.getElementById("8box").style.display="none"; 
                        }
                        function a5a(){
                             document.getElementById("3").className="top-selete-sub"; 
                           document.getElementById("4").className="top-selete-sub"; 
                           document.getElementById("5").className="top-selete-sub active"; 
                           document.getElementById("6").className="top-selete-sub"; 
                           document.getElementById("7").className="top-selete-sub"; 
                           document.getElementById("8").className="top-selete-sub"; 
                           document.getElementById("3box").style.display="none";
                           document.getElementById("4box").style.display="none"; 
                           document.getElementById("5box").style.display=""; 
                           document.getElementById("6box").style.display="none";
                           document.getElementById("7box").style.display="none"; 
                           document.getElementById("8box").style.display="none"; 
                        }
                        function a6a(){
                             document.getElementById("3").className="top-selete-sub"; 
                           document.getElementById("4").className="top-selete-sub"; 
                           document.getElementById("5").className="top-selete-sub"; 
                           document.getElementById("6").className="top-selete-sub active"; 
                           document.getElementById("7").className="top-selete-sub"; 
                           document.getElementById("8").className="top-selete-sub"; 
                           document.getElementById("3box").style.display="none";
                           document.getElementById("4box").style.display="none"; 
                           document.getElementById("5box").style.display="none"; 
                           document.getElementById("6box").style.display="";
                           document.getElementById("7box").style.display="none"; 
                           document.getElementById("8box").style.display="none"; 
                        }
                        function a7a(){
                             document.getElementById("3").className="top-selete-sub"; 
                           document.getElementById("4").className="top-selete-sub"; 
                           document.getElementById("5").className="top-selete-sub"; 
                           document.getElementById("6").className="top-selete-sub"; 
                           document.getElementById("7").className="top-selete-sub active"; 
                           document.getElementById("8").className="top-selete-sub"; 
                           document.getElementById("3box").style.display="none";
                           document.getElementById("4box").style.display="none"; 
                           document.getElementById("5box").style.display="none"; 
                           document.getElementById("6box").style.display="none";
                           document.getElementById("7box").style.display=""; 
                           document.getElementById("8box").style.display="none"; 
                        }
                        function a8a(){
                             document.getElementById("3").className="top-selete-sub"; 
                           document.getElementById("4").className="top-selete-sub"; 
                           document.getElementById("5").className="top-selete-sub"; 
                           document.getElementById("6").className="top-selete-sub"; 
                           document.getElementById("7").className="top-selete-sub"; 
                           document.getElementById("8").className="top-selete-sub active"; 
                           document.getElementById("3box").style.display="none";
                           document.getElementById("4box").style.display="none"; 
                           document.getElementById("5box").style.display="none"; 
                           document.getElementById("6box").style.display="none";
                           document.getElementById("7box").style.display="none"; 
                           document.getElementById("8box").style.display=""; 
                        }
                        
                        
    </script>
</body>

</html>