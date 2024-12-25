Proje Amacı
Bu proje, belirli zamanlarda zil çalmasını ve bir röleyi tetiklemesini sağlayan bir otomasyon sistemidir. Sistem, ESP32 kartı, bir API entegrasyonu ve bir veritabanı ile çalışır. Okullar, fabrikalar ve iş yerleri gibi alanlarda zil sistemlerinin otomasyonu için uygundur.

Kullanım Alanları
Okullar: Ders başlangıç ve bitişlerinde zil çalabilir.
Fabrikalar: Vardiya başlangıç ve bitiş saatlerini işçilere duyurabilir.
İş Yerleri: Mola ve yemek saatlerini duyurmak için kullanılabilir.
Projede Kullanılan Teknolojiler
ESP32: Zil saatlerini kontrol etmek ve röleyi tetiklemek için mikrodenetleyici.
PHP: API ve veritabanı işlemleri için backend çözümü.
MySQL: Zil saatlerinin saklandığı ve yönetildiği veritabanı.
Arduino IDE: ESP32 için kodların yazıldığı ve yüklendiği platform.
Wi-Fi: ESP32'nin API ile iletişim kurmasını sağlar.
Özellikler
Otomatik Zil Kontrolü: Veritabanında belirtilen saatlerde otomatik olarak zil çalar.
Esnek Zamanlama: Haftanın günlerine özel zil saatleri ayarlanabilir.
API Tabanlı Yapı: Saat ve zil bilgileri ESP32 ile senkronize edilir.
Enerji Verimliliği: Röle yalnızca gerekli olduğunda tetiklenir.
Kolay Yönetim: PHP tabanlı bir yönetim arayüzü ile zil saatlerini kolayca yönetebilirsiniz.
Kurulum
1. ESP32'yi Hazırlayın
Arduino IDE'yi kullanarak ESP32 kartlarını yükleyin.
Wi-Fi SSID ve şifrenizi zil-v2.ino dosyasındaki kodda güncelleyin.
Arduino kodunu ESP32'ye yükleyin.
2. Veritabanını Kurun
MySQL üzerinde bir veritabanı oluşturun.
zil_saatleri.sql dosyasını kullanarak gerekli tabloları oluşturun.
3. PHP API'yi Yükleyin
PHP dosyalarını bir web sunucusuna yükleyin.
Veritabanı bağlantı bilgilerini api_code.php, zilekle.php ve zil_yonetimi.php dosyalarında güncelleyin.
4. ESP32 ve Sunucuyu Bağlayın
ESP32'nin API adresini kodda tanımlayın.
ESP32, API ile iletişim kurarak zil saatlerini senkronize edecektir.

Klasör Yapısı
├── zil_saatleri.sql        # MySQL veritabanı dosyası
├── zilekle.php             # Yeni zil saatleri eklemek için PHP scripti
├── zilsaatleri.php         # API endpoint'i
├── zil_yonetimi.php        # Zil saatlerini yönetmek için PHP scripti
├── zil-v2.ino              # ESP32 için Arduino kodu

Kullanım
ESP32 cihazını çalıştırdığınızda:
Wi-Fi ağına bağlanır.
API'den güncel zil saatlerini çeker.
Veritabanında tanımlı zil saatlerinde röleyi tetikleyerek zil çalar.
Zil saatlerini düzenlemek için:
zilekle.php dosyasını kullanarak yeni saatler ekleyebilirsiniz.
zil_yonetimi.php dosyasını kullanarak mevcut saatleri güncelleyebilirsiniz.

Bu proje açık kaynaklıdır ve her türlü katkıya açıktır. Öneri, hata bildirimi veya geliştirme fikirlerinizi memnuniyetle karşılarım
