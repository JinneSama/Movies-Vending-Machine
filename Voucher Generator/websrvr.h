ESP8266WebServer server(80);
bool fromWeb = false;
String amnt = "0";
String stotalTime = "00:00m";
String paymentDone = "";
boolean payDoneWeb = false;

void handleRoot() 
{
 fromWeb= true;
 String s = webpage;
 server.send(200, "text/html", s);
}

void extending() 
{
 server.send(200, "text/plane", amnt);
}

void getTotalTime() 
{
 server.send(200, "text/plane", stotalTime);
}

void paymentDoneWeb() 
{
  if(paymentDone == "done"){
    server.send(200, "text/plane", paymentDone);
    paymentDone = "";
    fromWeb = false;
  }
}


void doneExtending() 
{
 String state = "Done";
 String act_state = server.arg("state");
 if(act_state == "1")
 {
    payDoneWeb = true;
 }
 server.send(200, "text/plane", state);
}

void ExtendTime(){
  
}
