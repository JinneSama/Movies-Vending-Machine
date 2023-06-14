const char webpage[] PROGMEM = R"=====(
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="data:,">
<title>Othanos Wifi - Extend Time</title>
<style type="text/css">

a,body,div,form,html,img,input,label,p,span{
    margin:0;
    padding:0;
    border:0;
    font-family:sans-serif,Arial
}
 body,html{
    min-height:100%;
    overflow-x:hidden
}

 body{
    background:#a2a09b;
    background:-webkit-linear-gradient(315deg,hsla(236.6,0%,53.52%,1) 0,hsla(236.6,0%,53.52%,0) 70%),-webkit-linear-gradient(65deg,hsla(220.75,34.93%,26.52%,1) 10%,hsla(220.75,34.93%,26.52%,0) 80%),-webkit-linear-gradient(135deg,hsla(46.42,36.62%,83.92%,1) 15%,hsla(46.42,36.62%,83.92%,0) 80%),-webkit-linear-gradient(205deg,hsla(191.32,50.68%,56.45%,1) 100%,hsla(191.32,50.68%,56.45%,0) 70%);
    background:linear-gradient(135deg,hsla(236.6,0%,53.52%,1) 0,hsla(236.6,0%,53.52%,0) 70%),linear-gradient(25deg,hsla(220.75,34.93%,26.52%,1) 10%,hsla(220.75,34.93%,26.52%,0) 80%),linear-gradient(315deg,hsla(46.42,36.62%,83.92%,1) 15%,hsla(46.42,36.62%,83.92%,0) 80%),linear-gradient(245deg,hsla(191.32,50.68%,56.45%,1) 100%,hsla(191.32,50.68%,56.45%,0) 70%)
}

.ie-fixMinHeight{
    display:-webkit-box;
    display:-ms-flexbox;
    display:flex
}
.wrap{
    margin:auto;
    padding:40px;
    -webkit-transition:width .3s ease-in-out;
    transition:width .3s ease-in-out
}
.main{
    min-height:calc(100vh - 90px);
    width:100%;
    display:-webkit-box;
    display:-ms-flexbox;
    display:flex;
    -webkit-box-orient:vertical;
    -webkit-box-direction:normal;
    -ms-flex-direction:column;
    flex-direction:column
}

h1,span{
    text-align:center;
    color:#fff;
    font-size:35px!important
}
input{
    outline:0;
    -webkit-appearance:none;
    -moz-appearance:none;
    appearance:none
}
input:focus{
    outline:0
}
.bt{
    opacity:.4
}
input[type=submit]{
    background:#3e4d59;
    color:#fff;
    border:0;
    cursor:pointer;
    text-align:center;
    width:100%;
    height:44px;
    border-radius:6px;
    -webkit-transition:background .3s ease-in-out;
    transition:background .3s ease-in-out
}
input[type=submit]:focus,input[type=submit]:hover{
    background:#33404a
}

*{
    -webkit-box-sizing:border-box;
    box-sizing:border-box;
    font-size:16px
}

.button { 
  background-color: #507075; 
    border: none; 
    color: white; 
    adding: 16px 40px;
    ext-decoration: none; 
    font-size: 30px; 
    margin: 2px; 
    cursor: pointer;
}

.button1:hover {
  background-color: #80989c;
  color: white;
}*.hidden {
  display: none !important;
}

div.loading{
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(16, 16, 16, 0.5);
}

@-webkit-keyframes uil-ring-anim {
  0% {
    -ms-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -ms-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-webkit-keyframes uil-ring-anim {
  0% {
    -ms-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -ms-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes uil-ring-anim {
  0% {
    -ms-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -ms-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-ms-keyframes uil-ring-anim {
  0% {
    -ms-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -ms-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes uil-ring-anim {
  0% {
    -ms-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -ms-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-webkit-keyframes uil-ring-anim {
  0% {
    -ms-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -ms-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-o-keyframes uil-ring-anim {
  0% {
    -ms-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -ms-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes uil-ring-anim {
  0% {
    -ms-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -ms-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
.uil-ring-css {
  margin: auto;
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  width: 200px;
  height: 200px;
}
.uil-ring-css > div {
  position: absolute;
  display: block;
  width: 160px;
  height: 160px;
  top: 20px;
  left: 20px;
  border-radius: 80px;
  box-shadow: 0 6px 0 0 #ffffff;
  -ms-animation: uil-ring-anim 1s linear infinite;
  -moz-animation: uil-ring-anim 1s linear infinite;
  -webkit-animation: uil-ring-anim 1s linear infinite;
  -o-animation: uil-ring-anim 1s linear infinite;
  animation: uil-ring-anim 1s linear infinite;
}

</style>
<body style="background-color: #808080 ">
<div id="load" class="loading">
      <div class='uil-ring-css' style='transform:scale(0.79);'>
        <div></div>
      </div>
    </div>
<center>
<div class="ie-fixMinHeight">
<div class="main">
<div class="wrap">
<h1>Extend Time</h1>
 <br>
<div><h1>
  Total: P <span id="total">0</span><br><br>
  Time: <span id="state">NA</span>
</h1>
</div>


  <input type="submit" value="DONE PAYING!!!" onclick="send(1)"/>
  <button id="testButton" class="button button1" hidden>Testk</button>
</div>
</div>
</div>

</center>
<script>
function send(led_sts) 
{
  document.getElementById("testButton").click();
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      
    }
  };
  xhttp.open("GET", "Done_Paying?state="+led_sts, true);
  xhttp.send();
  
  toggleLoading();
}
setInterval(function() 
{
  getAmnt();
  getTotalTime();
  paymentReceived();
}, 200); 

function getAmnt() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("total").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("GET", "pay", true);
  xhttp.send();
}

function getTotalTime() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("state").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "time", true);
  xhttp.send();
}

function paymentReceived() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      if(this.responseText == "done"){
        document.getElementById("state").innerHTML = this.responseText
        location.href = "http://othanoswifi.net";
      }
    }
  };
  xhttp.open("GET", "payment_received", true);
  xhttp.send();
}

window.onload = toggleLoading;
var loadingOverlay = document.querySelector('.loading');

function toggleLoading(){
  document.activeElement.blur();
  if (loadingOverlay.classList.contains('hidden')){
    loadingOverlay.classList.remove('hidden');
  } else {
    loadingOverlay.classList.add('hidden');
  }
}

</script>

</body>
</html>
)=====";
