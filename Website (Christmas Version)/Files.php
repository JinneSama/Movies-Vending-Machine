<!DOCTYPE html>
<html>
<head>
<title>Othanos Movies!!</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
<link rel="stylesheet" href="css/style2.css" type="text/css" media="all" />
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/jquery-func.js"></script>
<!--[if IE 6]><link rel="stylesheet" href="css/ie6.css" type="text/css" media="all" /><![endif]-->

<style>
  .loginPopup {
    position: relative;
    text-align: center;
    width: 100%;
  }
  .formPopup {
    display: none;
    position: fixed;
    left: 50%;
    top: 0%;
    transform: translate(-50%, 5%);
    z-index: 9;
  }
  .formContainer {
    max-width: 100%;
    max-height: 100%;
    padding: 20px;
    background:url('css/images/body-bg.gif');
    border: 5px solid #999999;
  }
  .formContainer .btn {
    padding: 12px 20px;
    border: none;
    background-color: #8ebf42;
    color: #fff;
    cursor: pointer;
    width: 100%;
    margin-bottom: 15px;
    opacity: 0.8;
  }
  .formContainer .cancel {
    background-color: #cc0000;
  }
</style>

</head>
<body>
<!-- START PAGE SOURCE -->
<div id="shell">
    <div id="header">
        <h1 id="logo"><a href="index.php">othanos</a></h1>
        <br />
        <div id="navigation">
          <ul>
            <li><a class="active" href="index.php">HOME</a></li>
            <li><a onclick="return openForm3()" id="status">LOGIN</a></li>
            <li>
            <table style="margin-top:-25px">
                <tr>
                    <td>
                        <h3>Code:</h3>
                    </td>
                    <td>
                        <h3 id = "code">N/A</h3>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3>Credits:</h3>
                    </td>
                    <td>
                        <h3 id="credits">N/A</h3>
                    </td>
                </tr>
            </table>
            </li>
          </ul>
        </div>
        <div id="sub-navigation">
            <ul>
                <li><a href="Files.php?dl=E:\Movies/Movies">MOVIES</a></li>
                <li><a href="Files.php?dl=E:\Movies/Animes">ANIMES</a></li>
                <li><a href="Files.php?dl=E:\Movies/Kdrama">KDRAMA</a></li>
            </ul>
             <div class="cl">&nbsp;</div>
             <div class="cl">&nbsp;</div>
             <div id="search">
        </div>
    </div>
</div>
<div id="main">
<div id="content">
      <br />
<?php
session_start();

$Server = "127.0.0.1";
$UID = "root";
$Password = "root";
$Database = "vouchercodes";

$Port = "3306";

$connection = mysqli_connect($Server , $UID , $Password ,  $Database , $Port);

$vcode = "";
$uses = "";

function useVoucher($code , $hreflink){
  $success = false;
  global $connection;
  global $vcode;
  global $uses;
  $cost = 5;

  $tblData = mysqli_query($connection , "Select * FROM Voucher where Code = '$code'") or die(mysqli_error($connection));
  while($row = mysqli_fetch_array($tblData))
  {
    $vcode = $row['Code'];
    $uses = $row['uses'];
  }
  if(mysqli_num_rows($tblData) == 0){
    echo "<script>alert('Wrong Code');</script>";
  }elseif ($uses == 0) {
    echo "<script>alert('Voucher Code: " . $vcode . " ,has no Credits Left');</script>";
  }elseif($uses - $cost < 0){
    echo "<script>alert('Voucher Code: " . $vcode . " ,Insufficient Credits , only " . $uses . " Left');</script>";
  }else{
    $success = true;
    if (strpos($hreflink,'8887')){
      $cost = 2;
    }else{
      $cost = 5;
    }
    
    mysqli_query($connection , "Update `Voucher` set uses = ($uses - $cost) where Code = '$code'") or die(mysqli_error($connection));
    $uses = $uses - $cost;
    echo '<script> alert("Credits Left: ' . $uses . '")</script>';
    echo '<script> location.href="' . $hreflink . '"</script>';
    return;
  }

  return $success;
}
if(isset($_POST['code'])){
  useVoucher($_POST['code'] , $_POST['link']);
}

if(isset($_GET['dl']))
{
  $file = $_GET['dl'];
  $file = str_replace('\\', '/', $file);
    $cdir = scandir($file);
    $videoDir = "";
    echo '<div class="box">';
    foreach ($cdir as $key => $value)
    {
      if (!in_array($value,array(".",".."))){ 
        if (strpos($value, '.srt') or strpos($value, '.db') or strpos($value, '.png') or strpos($value, '.jpg')){
          $newDir = "Files.php?dl=" . $file . "/" .$value;
          /*echo "<a href = '$newDir'><input type='submit' value='$value'/></a><br /><br />"; */
        }else{
          $newDir = "Files.php?dl=" . $file . "/" . $value;
          $imgDir = str_replace("E:/Movies/","",$file) . "/" . $value .  "/img.png";
          $imgDir = "http://192.168.10.19:8887/" . str_replace('%2F', '/', urlencode($imgDir));
          $imgDir = str_replace('+', '%20', $imgDir);
          $defaultImage = "'css/images/img.png'";

          $newVal = "'" . $value . "'";
          echo '<div class="movie2">' .
                '<a id="' . $newDir. '"  onclick="openForm(' .$newVal. ', this.id)"><div class="movie-image"> <span class="play"><span class="name">' .$value .'</span></span><img src="' .$imgDir . '" alt="" onerror="this.onerror=null; this.src='. $defaultImage .'"/></a> </div>' .
                '<div class="rating">' .
                '<p>' . $value . '</p></div>' .
                '</div>' ;
        }
      }
    }
    
    echo '<div class="cl">&nbsp;</div>';
    }

  if(isset($_POST['voucherCode'])){

    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
      echo $_SESSION["voucherCode"] . ": Already Logged in";
    }else{
      $_SESSION["loggedin"] = true;
      $_SESSION["voucherCode"] = $_POST['voucherCode'];
    }
  }

  function getVCode($voucherCode){
    $success = false;
    global $connection;
    global $vcode;
    global $uses;
    $cost = 5;
  
    $tblData = mysqli_query($connection , "Select * FROM Voucher where Code = '$voucherCode'") or die(mysqli_error($connection));
    while($row = mysqli_fetch_array($tblData))
    {
      $vcode = $row['Code'];
      $uses = $row['uses'];
    }
}

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    getVCode($_SESSION['voucherCode']);
    echo "<script>document.getElementById('code').innerHTML = '" . $vcode . "';</script>";
    echo "<script>document.getElementById('credits').innerHTML = '" . $uses . "';</script>";
    echo "<script>document.getElementById('status').innerHTML = 'LOGOUT';</script>";
}else{
    echo "<script>document.getElementById('status').innerHTML = 'LOGIN';</script>";
}

if(isset($_POST['voucherCode'])){
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        echo "<script>document.getElementById('code').innerHTML = '" . $_SESSION["voucherCode"] . "';</script>";
    }else{
        $_SESSION["loggedin"] = true;
        getVCode($_POST['voucherCode']);
        $_SESSION["voucherCode"] = $vcode;
        echo "<script>document.getElementById('code').innerHTML = '" . $vcode . "';</script>";
        echo "<script>document.getElementById('credits').innerHTML = '" . $uses . "';</script>";
        echo "<script>document.getElementById('status').innerHTML = 'LOGOUT';</script>";
    } 
}

if(isset($_POST['logout'])){
    $_SESSION["loggedin"] = false;
    $_SESSION["voucherCode"] = "";
    echo "<script>document.getElementById('code').innerHTML = '" . "N/A" . "';</script>";
    echo "<script>document.getElementById('credits').innerHTML = '" . "N/A" . "';</script>";
    echo "<script>document.getElementById('status').innerHTML = 'LOGIN';</script>";
}
?>

<div class="loginPopup">
  <div class="formPopup" id="popupForm">
        <div class="wrap animated fadeIn">
          <form class="formContainer" style="overflow-y:scroll;height:250px;">
            <p style="color:green" id="title">Title</p><br /><br />
            <input type="submit" value="Download"  formaction="javascript:openForm2('download')"/> <br /><br />
            <input type="submit" value="Play"  formaction="javascript:openForm2('play')"/><br /><br />
            <input type="submit" value="Close"  formaction="javascript:closeForm()" />
          </form>
        </div>
      </div>
    </div>

<div class="loginPopup">
  <div class="formPopup" id="popupForm2">
        <div class="wrap animated fadeIn">
          <form class="formContainer" style="overflow-y:scroll;height:250px;" method="post">
            <p style="color:green" id="title">Enter Voucher Code</p><br /><br />
            <input type="text" value="" name = "code"/>
            <input type="text" id = "linkTB" value="" name = "link" hidden/>
            <input type="submit" value="Proceed"/><br /><br />
            <input type="submit" value="Close"  formaction="javascript:closeForm2()" />
          </form>
        </div>
      </div>
    </div>

    <div class="loginPopup">
  <div class="formPopup" id="LoginForm">
        <div class="wrap animated fadeIn">
          <form class="formContainer" style="overflow-y:scroll;height:250px;" method="post">
            <p style="color:green" id="title">Enter Your Voucher Code</p><br /><br />
            <input type="text" value="" name = "voucherCode"/>
            <input type="submit" value="Login"/><br /><br />
            <input type="submit" value="Close"  formaction="javascript:closeForm3()" />
          </form>
        </div>
      </div>
    </div>

    <div class="loginPopup">
  <div class="formPopup" id="LogoutForm">
        <div class="wrap animated fadeIn">
          <form class="formContainer" style="overflow-y:scroll;height:250px;" method="post">
            <p style="color:green" id="title">Continue Logout?</p><br /><br />
            <input type="submit" value="Logout" name="logout"/><br /><br />
            <input type="submit" value="Close"  formaction="javascript:closeForm4()" />
          </form>
        </div>
      </div>
    </div>

    <div class="formPopup" id="ContinueForm">
        <div class="wrap animated fadeIn">
          <form class="formContainer" style="overflow-y:scroll;height:250px;" method="post">
            <p style="color:green" id="title">Continue?</p><br /><br />
            <input type="text" id="tbCode" value="" name = "code" hidden/>
            <input type="text" id="ClinkTB" value="" name = "link" hidden/>
            <input type="submit" value="Proceed"/><br /><br />
            <input type="submit" value="Close"  formaction="javascript:closeForm5()" />
          </form>
        </div>
      </div>
    </div>

<script type="text/javascript">

var mainlink = "";
var deviceIP = "http://192.168.10.19";
var userAction = "";
var finalLink = "";
var currentTitle = "";

function openForm(val , lnk) {
  if(lnk.includes(".mp4") || lnk.includes(".mkv") || lnk.includes(".MP4")  || lnk.includes(".avi")){
    document.getElementById("popupForm").style.display = "block";
    currentTitle = val.replace("Files.php?dl=","");
    document.getElementById("title").innerHTML = currentTitle;
    mainlink = lnk;
  }else{  
    location.href = lnk;
  }
}


function closeForm() {
  document.getElementById("popupForm").style.display = "none";
}

function openForm2(act) {
  
  if(act == "download"){
    mainlink = mainlink.replace("Files.php?dl=E:/Movies/","downloadFile.php?dl=E:/Movies/");
    finalLink = mainlink;
  }else{
    var fname = mainlink.replace("Files.php?dl=E:/Movies/","");
    finalLink = deviceIP + ":8887/" + fname;
    finalLink = "PlayMovies.php?play=" + finalLink + "&title=" + currentTitle;
  }
  if(document.getElementById('code').innerHTML != 'N/A'){
    document.getElementById("ContinueForm").style.display = "block";
    finalLink = finalLink + "&title=" + currentTitle;
    document.getElementById("ClinkTB").value = finalLink;
    document.getElementById("tbCode").value = document.getElementById('code').innerHTML;
  }else{
    document.getElementById("popupForm2").style.display = "block";
    finalLink = finalLink + "&title=" + currentTitle;
    document.getElementById("linkTB").value = finalLink;
  }
}

function closeForm2() {
  document.getElementById("popupForm2").style.display = "none";
}

function openForm3()
{
  if(document.getElementById('status').innerHTML == "LOGIN"){
    document.getElementById("LoginForm").style.display = "block";
  }else{
    document.getElementById("LogoutForm").style.display = "block";
  }
}

function closeForm3()
{
  document.getElementById("LoginForm").style.display = "none";
}
function closeForm4()
{
  document.getElementById("LogoutForm").style.display = "none";
}
function closeForm5()
{
  document.getElementById("ContinueForm").style.display = "none";
}

</script>
    </div>
        <br />
        <br />
        <br />
        <div id="news">
        <div class="head">
            <h3>Note lng po!</h3>
        </div>
        <div class="content">
            <div class="cl">&nbsp;</div>
            <p class="date">OCT.21.2021</p>
            <h4>Padownload/Papasa</h4>
            <br />
            <p>Pag wala po dyan ang Movie na gusto nyo , sabihan lng po naten ung nasa tindahan para ma-add ung movie na gusto nyo, thanks po!! </p>
        </div>
    </div>
    <div id="coming">
        <div class="head">
            <h3>Note po Ulet! hahah<strong></strong></h3>
            <p class="text-right"><a href="#">See all</a></p>
        </div>
        <div class="content">
            <h4>Pag may Error</h4>
            <a href="#"><img src="css/images/coming-soon1.jpg" alt="" /></a>
            <p>Sabihan po natin ulit ung nasa Store para maayos!</p> </div>
            <div class="cl">&nbsp;</div>
        </div>
        <div class="cl">&nbsp;</div>
    </div>
    <div id="footer">
        <p class="lf">Copyright &copy; 2021 <a href="#">Othanos Movies!!</a> - All Rights Reserved</p>
        <p class="rf">Powered by <a href="http://othanoswifi.net">Othanos Finger Snap!</a></p>
        <div style="clear:both;"></div>
    </div>
</div>
</body>
</html>