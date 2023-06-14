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
        width: 1000%;
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
        max-width: 1000px;
        max-height: 1000px;
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
    <h1 id="logo"><a href="#">othanos</a></h1>
    <div class="social"> <span></span>
      <ul>
      </ul>
    </div>
    <div id="navigation">
    </div>
    <br />
    <div id="sub-navigation">
      <ul>
        <li><a href="download.php?dl=E:\Movies/Movies">MOVIES</a></li>
        <li><a href="download.php?dl=E:\Movies/Animes">ANIMES</a></li>
        <li><a href="download.php?dl=E:\Movies/Kdrama">KDRAMA</a></li>
      </ul>
      <div class="cl">&nbsp;</div>
      <div class="cl">&nbsp;</div>
    </div>
  </div>
  <div id="main">
    <div id="content">
      <br />

<?php
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
            mysqli_query($connection , "Update `Voucher` set uses = (uses - $cost) where Code = '$code'") or die(mysqli_error($connection));
            if (strpos($hreflink,'8887')){
                $cost = 5;
            }else{
                $cost = 15;
            }

            $uses = $uses - $cost;
            echo '<script> alert("Credits Left: ' . $uses . '")</script>';
            echo '<script> location.href="' . $hreflink . '"</script>';
        }

        return $success;
    }

if(isset($_GET['dl']))
{
    $var_1 = $_GET['dl'];
    $file = $var_1;
    $file = str_replace('\\', '/', $file);


    $fileInfos = pathinfo($file); 
    $fileNames  = $fileInfos['basename']; 
    echo '<h1>' . $fileNames . ' - Episodes/Chapters' .'</h1>';


    /*echo '<p class="info">' . str_replace("E:/Movies/","",$file) . '</p>'; */
if(strpos($file, '.mp4') or strpos($file, '.mkv') or strpos($file, '.srt')  or strpos($file, '.MP4') or strpos($file, '.avi')){
}else{
    $cdir = scandir($file);
    $videoDir = "";
    $counter = 1;
    $counter2 = 1;
    echo '<div class="box">';
   foreach ($cdir as $key => $value)
   {

      if (!in_array($value,array(".","..")))
      { 
        if (strpos($value, '.db')){
            $newDir = "downloadFile.php?dl=" . $file . "/" .$value;
            /*echo "<a href = '$newDir'><input type='submit' value='$value'/></a><br /><br />"; */
        }else{
            $newDir = "Files.php?dl=" . $file . "/" . $value;
            $newVal = "'" . $value . "'";
            if($counter2 % 6 == 0 or ($counter == count($cdir))) {
                echo '<div class="movie last">' .
                    '<a id="' . $newDir. '"  onclick="openForm(' .$newVal. ', this.id)"><div class="movie-image"> <span class="play"><span class="name">' .$value . '</span></span> <img src="css/images/img.png" alt="" /></a> </div>' .
                    '<div class="rating">' .
                    '<p>' . $value . '</p>' .
                    '</div>' .
                    '</div>' .
                    '<div class="cl">&nbsp;</div>' .
                    '</div>' .
                    '<div class="box">';
            }else
            {
                echo '<div class="movie">' .
                    '<a id="' . $newDir. '"  onclick="openForm(' .$newVal. ', this.id)"><div class="movie-image"> <span class="play"><span class="name">' .$value .'</span></span><img src="css/images/img.png" alt="" /></a> </div>' .
                    '<div class="rating">' .
                    '<p>' . $value . '</p></div>' .
                    '</div>';
            }
            $counter2 +=1;
        }
      }
      $counter += 1;
   }
}
} //- the missing closing brace

 

if(isset($_POST['code'])){
        useVoucher($_POST['code'] , $_POST['link']);
}

?>
<div class="loginPopup">
      <div class="formPopup" id="popupForm">
        <div class="ie-fixMinHeight">
        <div class="main">
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
      </div>
    </div>

    <div class="loginPopup">
      <div class="formPopup" id="popupForm2">
        <div class="ie-fixMinHeight">
        <div class="main">
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

            document.getElementById("popupForm2").style.display = "block";
            document.getElementById("linkTB").value = finalLink;
            
        }

      function closeForm2() {
            document.getElementById("popupForm2").style.display = "none";
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
        <p class="date" align="Left">OCT.21.2021</p>
        <h4>Padownload/Papasa</h4>
        <br />
        <p>Pag wala po dyan ang Movie na gusto nyo , sabihan lng po naten ung nasa tindahan para ma-add ung movie na gusto nyo, thanks po!! </p>
        </div>
    </div>
    <div id="coming">
      <div class="head">
        <h3>Note po Ulet! hahah<strong>!</strong></h3>
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
    <p class="rf">Powered by <a href="">Othanos Finger Snap!</a></p>
    <div style="clear:both;"></div>
  </div>
</div>
<!-- END PAGE SOURCE -->
</body>
</html>