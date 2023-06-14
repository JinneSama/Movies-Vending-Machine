<?php 
session_start();
?>
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
</head>
<body>
<!-- START PAGE SOURCE -->

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
<?php 
$Server = "127.0.0.1";
$UID = "root";
$Password = "root";
$Database = "vouchercodes";
$Port = "3306";

$connection = mysqli_connect($Server , $UID , $Password ,  $Database , $Port);

$vcode = "";
$uses = "";

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

if(isset($_POST['download'])) {
  
  set_time_limit(0); 
	ini_set('memory_limit', '512M'); 
  $flpath = $_POST['link'];
  echo $flpath;
  output_file($flpath);

}

if(isset($_GET['dl']))
{
  $var_1 = $_GET['dl'];
  $file = $var_1;
  $file = str_replace('\\', '/', $file);
  echo '<h1>Downloading Your File: ' . $_GET['title'] . '</h1><br /><br />';

  echo '<form method="post">' .
        '<input type="text" id = "linkTB" value="' .$file. '" name = "link" hidden/>' .
        '<input type="submit" name="download"' .
                'class="button" value="' . $_GET['title'] . '" />' .
        '</form>';
}

function downloadFiles($filePath) 
{    
  include("fileTypes.php");

  if(!empty($filePath)) 
  { 
    $fileInfo = pathinfo($filePath); 
    $fileName  = $fileInfo['basename']; 
    $fileExtnesion   = $fileInfo['extension']; 
    $default_contentType = "application/octet-stream"; 
    $content_types_list = mimeTypes(); 
    if (array_key_exists($fileExtnesion, $content_types_list))  
    { 
      $contentType = $content_types_list[$fileExtnesion]; 
    }else 
    { 
      $contentType =  $default_contentType; 
    } 
    if(file_exists($filePath)) { 
      $size = filesize($filePath); 
      $offset = 0; 
      $length = $size; 
      if(isset($_SERVER['HTTP_RANGE'])) 
      { 
        preg_match('/bytes=(\d+)-(\d+)?/', $_SERVER['HTTP_RANGE'], $matches); 
        $offset = intval($matches[1]);  
        $length = intval($matches[2]) - $offset; 
        $fhandle = fopen($filePath, 'r'); 
        fseek($fhandle, $offset); 
        $data = fread($fhandle, $length); 
        fclose($fhandle); 
        header('HTTP/1.1 206 Partial Content'); 
        header('Content-Range: bytes ' . $offset . '-' . ($offset + $length) . '/' . $size); 
      }
      //Heasers for download
      header("Content-Disposition: attachment;filename=".$fileName); 
      header('Content-Type: video/mp4'); 
      header("Accept-Ranges: bytes"); 
      header("Pragma: public"); 
      header("Expires: 0"); 
      header("Cache-Control: no-cache"); 
      header("Cache-Control: public, must-revalidate, post-check=0, pre-check=0"); 
      header("Content-Length: ".filesize($filePath)); 
      $chunksize = 8 * (1024 * 1024); //8MB (highest possible fread length) 
      
      if ($size > $chunksize) 
      { 
        $handle = fopen($_FILES["file"]["tmp_name"], 'rb'); 
        $buffer = ''; 
        while (!feof($handle) && (connection_status() === CONNECTION_NORMAL))  
        { 
          $buffer = fread($handle, $chunksize); 
          print $buffer; 
          ob_flush(); 
          flush(); 
        } 
        if(connection_status() !== CONNECTION_NORMAL) 
        { 
          echo "Connection aborted"; 
        } 
        fclose($handle); 
      }else  
      { 
        ob_clean(); 
        flush(); 
        readfile($filePath); 
      } 
    }else 
    { 
      echo 'File does not exist!'; 
    } 
  }else{ 
    echo 'There is no file to download!'; 
  } 
}

function output_file($file)
{

    if(!is_readable($file)) die('File not found or inaccessible!');

    $fileInfo = pathinfo($file); 
    $name  = $fileInfo['basename']; 
    $mime_type = $fileInfo['extension']; 

    $size = filesize($file);
    $name = rawurldecode($name);
    $known_mime_types=array(
        "htm" => "text/html",
        "exe" => "application/octet-stream",
        "zip" => "application/zip",
        "doc" => "application/msword",
        "jpg" => "image/jpg",
        "php" => "text/plain",
        "xls" => "application/vnd.ms-excel",
        "ppt" => "application/vnd.ms-powerpoint",
        "gif" => "image/gif",
        "pdf" => "application/pdf",
        "txt" => "text/plain",
        "html"=> "text/html",
        "png" => "image/png",
        "jpeg"=> "image/jpg",
        "mp4" => "video/mp4"
    );

    if($mime_type==''){
        $file_extension = strtolower(substr(strrchr($file,"."),1));
        if(array_key_exists($file_extension, $known_mime_types)){
            $mime_type=$known_mime_types[$file_extension];
        } else {
            $mime_type="application/force-download";
        };
    };
    @ob_end_clean();
    if(ini_get('zlib.output_compression'))
    ini_set('zlib.output_compression', 'Off');
    header('Content-Type: ' . $mime_type);
    header('Content-Disposition: attachment; filename="'.$name.'"');
    header("Content-Transfer-Encoding: binary");
    header('Accept-Ranges: bytes');

    if(isset($_SERVER['HTTP_RANGE']))
    {
        list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
        list($range) = explode(",",$range,2);
        list($range, $range_end) = explode("-", $range);
        $range=intval($range);
        if(!$range_end) {
            $range_end=$size-1;
        } else {
            $range_end=intval($range_end);
        }

        $new_length = $range_end-$range+1;
        header("HTTP/1.1 206 Partial Content");
        header("Content-Length: $new_length");
        header("Content-Range: bytes $range-$range_end/$size");
    } else {
        $new_length=$size;
        header("Content-Length: ".$size);
    }

    $chunksize = 1*(1024*1024);
    $bytes_send = 0;
    if ($file = fopen($file, 'r'))
    {
        if(isset($_SERVER['HTTP_RANGE']))
        fseek($file, $range);

        while(!feof($file) &&
            (!connection_aborted()) &&
            ($bytes_send<$new_length)
        )
        {
            $buffer = fread($file, $chunksize);
            echo($buffer);
            flush();
            $bytes_send += strlen($buffer);
        }
        fclose($file);
    } else
        die('Error - can not open file.');
    die();
}


?>

</div>
    <br />
    <br />
    <div class="box" >
        </div>
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
<script>
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
</script>
</body>
</html>