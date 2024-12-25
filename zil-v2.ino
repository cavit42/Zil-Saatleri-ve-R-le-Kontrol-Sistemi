#include <WiFi.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>

// Wi-Fi Ayarları
const char* ssid = "ANONYMOUS_SSID";
const char* password = "ANONYMOUS_PASSWORD";

// Röle Pini
const int relayPin = 13;  // Röle için GPIO 13 kullanılıyor

// API ve Zamanlama
const char* apiUrl = "http://www.example.com/api/zilsaatleri.php";
unsigned long previousMillisZil = 0;
unsigned long previousMillisSaat = 0;
const long zilInterval = 33000;  // Her 12 saniyede bir API'den zil saatlerini güncelle
const long saatInterval = 1000;  // Her 1 saniyede saat artırma

String zilSaatleri[25];  // Alınan zil saatlerini depolamak için genişletildi (25 yapıldı)
String currentTime = "00:00:00";  // Saat değeri
String lastTime = "";

void setup() {
  Serial.begin(115200);

  // Röle pinini çıkış olarak ayarla
  pinMode(relayPin, OUTPUT);
  digitalWrite(relayPin, HIGH);  // Röleyi başlangıçta kapalı yap (ters mantık)

  // Wi-Fi'ye Bağlan
  Serial.println("Wi-Fi'ye bağlanılıyor...");
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Wi-Fi bağlantısı bekleniyor...");
  }
  Serial.println("Wi-Fi bağlantısı başarılı!");

  // Başlangıçta saati API'den çek
  Serial.println("API'den veri çekiliyor...");
  getZilSaatleriFromApi();
  Serial.println("Başlangıç verileri alındı.");
}

void loop() {
  unsigned long currentMillis = millis();

  // Saat her saniye artacak
  if (currentMillis - previousMillisSaat >= saatInterval) {
    previousMillisSaat = currentMillis;
    updateLocalTime();
    Serial.println("Saat güncellendi: " + currentTime);
  }

  // Her 12 saniyede bir API'den veri çekilecek
  if (currentMillis - previousMillisZil >= zilInterval) {
    previousMillisZil = currentMillis;
    Serial.println("API'den veri çekiliyor...");
    getZilSaatleriFromApi();
    Serial.println("Veriler güncellendi.");
  }

  // Zil saatleri ile anlık saati karşılaştır
  for (int i = 0; i < 25; i++) {
    if (zilSaatleri[i] == currentTime) {
      Serial.println("Zil çalıyor: " + currentTime);
      triggerRelay();  // Röleyi tetikle
    }
  }

  delay(1000);  // 1 saniyede bir döngü
}

// API'den saat ve zil saatlerini çeken fonksiyon
void getZilSaatleriFromApi() {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin(apiUrl);
    int httpCode = http.GET();

    if (httpCode > 0) {
      String payload = http.getString();
      Serial.println("API'den Gelen JSON: ");
      Serial.println(payload);  // JSON verisini seri monitörde göster

      // JSON verisini ayrıştır
      DynamicJsonDocument doc(4096);
      deserializeJson(doc, payload);

      // Anlık saat bilgisini al
      currentTime = doc["current_time"].as<String>();
      Serial.println("Anlık Saat API'den alındı: " + currentTime);

      // Zil saatlerini güncelle
      JsonArray zilArray = doc["zil_saatleri"].as<JsonArray>();
      for (int i = 0; i < zilArray.size() && i < 25; i++) {
        zilSaatleri[i] = zilArray[i]["saat"].as<String>();
        Serial.println("Zil Saati: " + zilSaatleri[i]);
      }
    } else {
      Serial.println("API'den veri alınamadı, kod: " + String(httpCode));
    }

    http.end();
  } else {
    Serial.println("WiFi bağlantısı yok.");
  }
}

// Röleyi tetikleyen fonksiyon
void triggerRelay() {
  Serial.println("Röle tetiklendi!");
  digitalWrite(relayPin, LOW);   // Röleyi aç (ters mantık)
  delay(1000);                   // 1 saniye bekle
  digitalWrite(relayPin, HIGH);  // Röleyi kapat (ters mantık)
  Serial.println("Röle kapatıldı.");
}

// Saat değerini saniye olarak güncelleyen fonksiyon
void updateLocalTime() {
  int hour = currentTime.substring(0, 2).toInt();
  int minute = currentTime.substring(3, 5).toInt();
  int second = currentTime.substring(6, 8).toInt();

  second++;

  if (second >= 60) {
    second = 0;
    minute++;
  }
  if (minute >= 60) {
    minute = 0;
    hour++;
  }
  if (hour >= 24) {
    hour = 0;
  }

  currentTime = (hour < 10 ? "0" : "") + String(hour) + ":" + (minute < 10 ? "0" : "") + String(minute) + ":" + (second < 10 ? "0" : "") + String(second);
}
