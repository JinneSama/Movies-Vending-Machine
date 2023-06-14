#include <LiquidCrystal_I2C.h>
#include <Wire.h>
#include <ESP8266TelnetClient.h>
#include <ESP8266WiFi.h>
#include <ESP8266WiFiMulti.h>
#include <WiFiClient.h>
#include <ESP8266WebServer.h>
#include "index.h"
#include "websrvr.h"

//put here your raspi ip address, and login details
IPAddress mikrotikRouterIp (192,168,100,8);
const char* user = "NodeMCU";
const char* pwd = "Cla%1226"; 

const char* ssid     = "PLDC_FCK_SHT";
const char* password = "junnienie-123";


ESP8266WiFiMulti WiFiMulti;

WiFiClient client;
                                 
ESP8266telnetClient tc(client); 

LiquidCrystal_I2C lcd(0x27,20,4); 

const int button1 = 14;     
const int button5 =  12;     
const int buttonOK =  16;    
const int buttonPay =  15;    

int amount = 0;
int totalTime = 0;
int totalAmount = 0;
int timeOut = 30;
int minuite = 0;
int hour = 0;

String hourIndicator;
String minIndicator;

bool stopAnimation;
int period = 500;
unsigned long time_now = 0;
int animCursor = 1;
bool isIdle = true;

bool paying = false;

bool getVoucher = false;
int voucherPeriod = 30;

//Needed for the Account Creation
String payerTime;
String voucherCode;

bool btnPressed = false;

void setup() {
  Serial.begin(115200);
  SetupTelnet();
  
  pinMode(button1, INPUT);
  pinMode(button5, INPUT);
  pinMode(buttonOK, INPUT);

  Wire.begin(4,5);
  lcd.init();
  lcd.init();
  lcd.backlight();
  
  lcd.home();
  lcd.setCursor(1,0);
  lcd.print("Connecting...");
  lcd.setCursor(2,1);
  lcd.print("Please Wait");
  lcd.clear();

  Serial.println(WiFi.localIP());
  server.on("/", handleRoot);
  server.on("/Done_Paying", doneExtending);
  server.on("/pay", extending);
  server.on("/time", getTotalTime);
  server.on("/payment_received", paymentDoneWeb);
  server.begin();
}

void SetupTelnet(){
  WiFi.mode(WIFI_STA);
  WiFiMulti.addAP(ssid, password);

  Serial.println();
  Serial.println();

  while (WiFiMulti.run() != WL_CONNECTED) {
    Serial.print(".");
    delay(500);
  }
  tc.setPromptChar('>');
  char key = 0;
  do{
    key = Serial.read();
  }while(key<=0);
    if(tc.login(mikrotikRouterIp, user, pwd)){
  }
}

void loop() {
  server.handleClient();
  if (digitalRead(button1) == HIGH && !btnPressed && paying) {
    amount += 1;
    minuite += 15;
    lcdPaying();
    delay(100);
  }else if (digitalRead(button5) == HIGH && !btnPressed && paying) {
    amount += 5;
    hour += 1;
    lcdPaying();
    delay(100);
  }else if (digitalRead(buttonPay) == HIGH && !btnPressed && paying) {
    btnPressed = true;
    if(amount > 0){
      setTotalTime();
      paying = false;
    }
    delay(100);
  }else if (digitalRead(buttonOK) == HIGH && !btnPressed) {
    btnPressed = true;
    delay(100);
    if(!fromWeb){
      generateVoucher();
    }else{
      paymentDone = "done";
      startIdle();
      getVoucher = false;
      voucherPeriod = 30;
      Serial.println("Paid");
      delay(100);
    }
  }else if(digitalRead(button1) == LOW && digitalRead(button5) == LOW && digitalRead(buttonOK) == LOW && digitalRead(buttonPay) == LOW)
  {
    btnPressed = false;
    delay(100);
  }

  if(payDoneWeb){
    if(amount > 0){
      setTotalTime();
      paying = false;
    }
  }
  if(isIdle){
    lcdIdle();
  }

  if(stopAnimation){
    lcd.clear();
    lcdPaying();
    stopAnimation = false;
  }

  if(getVoucher){
    displayVoucher();
  }
}

void setUpAccount(){
  String script = " ip hotspot user add name=" + voucherCode;
  script += " profile=HSRate limit-uptime=" + payerTime + ":00";

  char final_script[script.length() + 1];
  script.toCharArray(final_script , script.length() + 1);
  tc.sendCommand(final_script);
}

void displayVoucher(){
  if(fromWeb){
    voucherPeriod = 0;
  }else{
  
  lcd.setCursor(14,1);
  lcd.print(voucherPeriod);
  
  time_now = millis();
  while(millis() < time_now + 1000){
    if(digitalRead(buttonPay) == HIGH)
    {
      startIdle();
      getVoucher = false;
      voucherPeriod = 30;
      delay(100);
    }
  }
  }
  
  if(voucherPeriod == 0){
    fromWeb = false;
    startIdle();
    getVoucher = false;
    voucherPeriod = 30;
  }else{
    voucherPeriod -= 1;
  }
  
}

void generateVoucher()
{
  voucherCode = "";
  randomSeed(millis());
  for(int x = 0 ; x < 6 ; x++){
    voucherCode += String(random(10));
  }

  lcd.clear();
  lcd.setCursor(5,0);
  lcd.print(voucherCode);

  lcd.setCursor(0,1);
  lcd.print("Voucher Code");
  getVoucher = true;

  setUpAccount();
}

void setTotalTime()
{
  payerTime = hourIndicator + minIndicator;
  totalAmount = amount;
  hour = 0;
  minuite = 0;
  amount = 0;
  delay(10);
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("PAY NOW TO START");
  lcd.setCursor(3,1);
  lcd.print("Total: P" + String(totalAmount));
}

void lcdPaying()
{
  int newAmount = amount;
  
  lcd.setCursor(1,0);
  lcd.print("Enter Amount:");
  lcd.setCursor(0,1);
  lcd.print("P" + String(amount));
  lcd.setCursor(10,1);

  if (newAmount >=50){
    hour = round((newAmount/50) - 0.5) * 48;
    newAmount = newAmount % 50;
  }
  
  if (newAmount >=20){
    if(amount > 50){
      hour += round((newAmount/20) - 0.5) * 15;
      newAmount = newAmount % 20;
    }else{
      hour = round((newAmount/20) - 0.5) * 15;
      newAmount = newAmount % 20;
    }
  }
  
  if (newAmount >=10){
    if(amount > 20){
      hour += round((newAmount/10) - 0.5) * 5;
      newAmount = newAmount % 10;
    }else{
      hour = round((newAmount/10) - 0.5) * 5;
      newAmount = newAmount % 10;
    }
  }
  
  if (newAmount >=5){
    if(amount > 10){
      hour += round((newAmount/5) - 0.5) * 2;
      minuite = (newAmount - 5) * 15;
    }else{
      hour = round((newAmount/5) - 0.5) * 2;
      minuite = (newAmount - 5) * 15;
    }
  }

  if(minuite == 60)
  {
    hour += 1;
    minuite = 0;
  }

  if(minuite < 10){
    minIndicator = "0" + String(minuite);
  }else{
    minIndicator = String(minuite);
  }

  if(hour < 10){
    hourIndicator = "0" + String(hour) + ":";
  }else{
    hourIndicator = String(hour) + ":";
  }
  lcd.print(hourIndicator + minIndicator + "m");

  if(fromWeb){
    amnt = String(amount); 
    stotalTime = hourIndicator + minIndicator + "m";
  }
}

void startIdle()
{
  isIdle = true;
  animCursor = 1;
  lcd.clear();
}
void lcdIdle()
{
  time_now = millis();
  while(millis() < time_now + period){
    if(digitalRead(buttonPay) == HIGH)
    {
      stopAnimation = true;
      isIdle = false;
      paying = true;
      delay(100);
    }

    if(fromWeb){
      stopAnimation = true;
      isIdle = false;
      paying = true;
      delay(100);
    }
  }
  
  if(animCursor == 5)
  {
    animCursor += 1;
    lcd.setCursor(4,0);
    lcd.print("OTHANOS!");
    lcd.setCursor(1,1);
    lcd.print("And Start Now!");
    
  }else if(animCursor == 6)
  {
    animCursor = 1;
    lcd.setCursor(0,0);
    lcd.print("                ");
  }else{
    animCursor += 1;
    lcd.setCursor(((animCursor-1) - 1),0);
    lcd.print("=");
    lcd.setCursor((17 - animCursor),0);
    lcd.print("=");
    lcd.setCursor(1,1);
    lcd.print("Tap Pay Button");
  }
  
}
