#ifdef ESP32
  #include <WiFi.h>
  #include <HTTPClient.h>
#else
  #include <ESP8266WiFi.h>
  #include <ESP8266HTTPClient.h>
  #include <WiFiClient.h>
#endif

#include <ArduinoJson.h>
#include <LiquidCrystal_I2C.h>

const char* ssid     = "xxxxxxxx"; //masukkan ssid
const char* password = "xxxxxxxxxxxx"; //masukkan password

//Sesuaikan dengan addres i2c dan ukuran LCD yg digunakan
LiquidCrystal_I2C lcd(0x27, 16, 2);

const int buzzer   = 12; //D6 Nodemcu
const int infrared = 13; //D7 Nodemcu
const int relay = 14; // D5 Nodemcu

String KEY_API = "abc123";


boolean Object = false;
String deviceState;
int id = 1; //id device
 
void setup () {

  Serial.begin(115200);
  WiFi.begin(ssid, password);
  lcd.begin();
  lcd.setCursor(0,0);
  lcd.print(" SMART COUNTER   ");
  lcd.setCursor(0,1);
  lcd.print("  CONVEYOR PROJECT   ");
  delay(5000);
  lcd.clear();

   pinMode(buzzer, OUTPUT);
   pinMode(infrared, INPUT);
   pinMode(relay, OUTPUT);

  while (WiFi.status() != WL_CONNECTED) {

    delay(1000);
    Serial.println("Connecting..");

  }

  if(WiFi.status() == WL_CONNECTED){
    Serial.println("Connected!!!");
  }
  else{
    Serial.println("Connected Failed!!!");
  }

}

void loop() {
  
  if (WiFi.status() == WL_CONNECTED) {

    HTTPClient http;
    int readSensor = digitalRead(infrared);
    //ganti dengan ipaddress komputer anda
    String url = "http://192.168.1.10/smartcounter/getdata.php?";
    http.begin(url + "key_api=" + KEY_API + "&id=" +String(id)+ "&sensor_state=" + String(readSensor));
    int httpCode = http.GET();
    
    if (httpCode > 0) {
      char json[500];
      String payload = http.getString();
      payload.toCharArray(json, 500);
      
      //StaticJsonDocument<200> doc;
      DynamicJsonDocument doc(JSON_OBJECT_SIZE(7));

     // Deserialize the JSON document
       deserializeJson(doc, json);

       String Max   = doc["max"];
       String count = doc["count"];
       String Mode  = doc["mode"];
       String btn   = doc["btn_state"];

       Serial.print("HTTP Code= ");
       Serial.println(httpCode);
       Serial.print("Count = ");
       Serial.println(count);
       Serial.print("Relay = ");
       Serial.println(btn);
       Serial.println("");
       Serial.println(readSensor);
    
     if(btn == "0"){
        digitalWrite(relay, LOW); 
        deviceState = "ON";
      }
      else{
        digitalWrite(relay, HIGH);
        deviceState = "OFF";
      }

     if (readSensor == 1 && Object == false){
         Object = true;
     }
     else if(readSensor == 0 && Object == true){
         Object = false;
         digitalWrite(buzzer, HIGH);
         delay(100);
         digitalWrite(buzzer, LOW);
         delay(100);
     } 

        
         lcd.setCursor(0,0);
         lcd.print("Status = ");
         lcd.print(deviceState);
         lcd.print("  ");
         lcd.setCursor(0,1);
         lcd.print("Count = ");
         lcd.print(count);
         lcd.print("  ");
      
      delay(100); 
    }

    http.end();

  }

}
