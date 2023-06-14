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
   
if(isset($_GET['play'])){
        $url = str_replace('Files.php?dl=E:/Movies/','',$_GET['play']);
        echo '<h1>' .$_GET['title']. '</h1>';
        echo '<video width="100%" height="100%" controls controlsList="nodownload" autoplay>' .
  			'<source src="' .$url. '" type="video/mp4"><source src="' .$url. '" type="video/avi"></video>';
}

?>
    </div>

          <br />
          <br />
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