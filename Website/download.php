<!DOCTYPE html>
<html>
<head>
<title>Othanos Movies!!</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/jquery-func.js"></script>
<!--[if IE 6]><link rel="stylesheet" href="css/ie6.css" type="text/css" media="all" /><![endif]-->
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
      <ul>
      </ul>
    </div>
    <div id="sub-navigation">
      <ul>
        <li><a href="download.php?dl=E:\Movies/Movies">MOVIES</a></li>
        <li><a href="download.php?dl=E:\Movies/Animes">ANIMES</a></li>
        <li><a href="download.php?dl=E:\Movies/Kdrama">KDRAMA</a></li>
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
   

if(isset($_GET['dl']))
{
    $var_1 = $_GET['dl'];
    $file = $var_1;
    $file = str_replace('\\', '/', $file);

    /*echo '<p class="info">' . str_replace("E:/Movies/","",$file) . '</p>'; */
if(strpos($file, '.mp4') or strpos($file, '.mkv') or strpos($file, '.srt')){
set_time_limit(0); 
ini_set('memory_limit', '512M'); 
$filePath = $file; 
downloadFiles($filePath); 
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
        if (strpos($value, '.srt') or strpos($value, '.db')){
            $newDir = "download.php?dl=" . $file . "/" .$value;
            /*echo "<a href = '$newDir'><input type='submit' value='$value'/></a><br /><br />"; */
        }else{
           $newDir = "Files.php?dl=" . $file . "/" . $value;
            if($counter2 % 6 == 0 or ($counter == count($cdir))){
                echo '<div class="movie last">' .
                    ' <a href="' . $newDir . '"><div class="movie-image"> <span class="play"><span class="name">' .$value . '</span></span><img src="css/images/img.png" alt="" /></a> </div>' .
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
                    '<a href="' . $newDir . '"><div class="movie-image"> <span class="play"><span class="name">' .$value .'</span></span> <img src="css/images/img.png" alt="" /></a> </div>' .
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



?>
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
    <p class="rf">Powered by <a href="http://chocotemplates.com/">Othanos Finger Snap!</a></p>
    <div style="clear:both;"></div>
  </div>
</div>
<!-- END PAGE SOURCE -->
</body>
</html>