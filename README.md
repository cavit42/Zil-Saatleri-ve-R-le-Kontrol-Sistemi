Zil Saatleri ve Röle Kontrol Sistemi

Proje Amacı
Bu proje, belirli zamanlarda zil çalmasını ve bir röleyi tetiklemesini sağlayan bir sistemdir. Proje, ESP32 kartı, bir API entegrasyonu ve bir veritabanı ile çalışmaktadır. Özellikle okullar, fabrikalar veya benzeri yerlerdeki zil sistemlerinin otomasyonu için uygundur.

Kullanım Alanları
Okullar: Ders zili için belirli saatlerde zil çalabilir.
Fabrikalar: Vardiya başlangıç ve bitiş saatlerinde işçilere sinyal göndermek için kullanılabilir.
İş yerleri: Mola ve yemek saatlerini duyurmak için ideal bir çözümdür.
Projede Kullanılan Teknolojiler
ESP32: Zil saatlerini kontrol etmek ve röleyi tetiklemek için mikrodenetleyici.
PHP: Zil saatlerinin API ile ESP32'ye iletilmesi ve veritabanı işlemleri için backend çözümü.
MySQL: Zil saatlerinin saklandığı ve yönetildiği veritabanı.
Arduino IDE: ESP32 için kodların yazıldığı ve yüklendiği platform.
Wi-Fi: ESP32'nin API ile iletişim kurmasını sağlar.

Özellikler
Otomatik Zil Kontrolü: Veritabanında belirtilen saatlerde otomatik olarak zil çalma.
Esnek Zamanlama: Haftanın günlerine özel zil saatleri ayarlanabilir.
API Tabanlı Yapı: Saat ve zil bilgileri anlık olarak ESP32 ile senkronize edilir.
Enerji Verimliliği: Röle, yalnızca gerekli olduğunda tetiklenir.
Kolay Kullanıcı Arayüzü: PHP tabanlı bir yönetim arayüzü ile zil saatlerini kolayca yönetebilirsiniz.
Kurulum
ESP32'yi Hazırlayın:

Arduino IDE'den ESP32 kartlarını yükleyin.
Wi-Fi SSID ve şifrenizi kodda güncelleyin.
Arduino kodunu yükleyin.
Veritabanını Kurun:

MySQL üzerinde bir veritabanı oluşturun.
zil_saatleri.sql dosyasını kullanarak gerekli tabloları oluşturun.
PHP API'yi Yükleyin:

PHP dosyalarını bir web sunucusuna yükleyin.
Veritabanı bağlantı bilgilerini api_code.php, zilekle.php ve zil_yonetimi.php dosyalarında güncelleyin.
ESP32 ve Sunucuyu Bağlayın:

ESP32'nin API adresini kodda belirtin.
Sistem, API ile iletişim kurarak zil saatlerini senkronize edecektir.
Klasör Yapısı


├── zil_saatleri.sql        # MySQL veritabanı dosyası
├── zilekle.php             # Yeni zil saatleri eklemek için PHP scripti
├── zilsaatleri.php         # API endpoint'i
├── zil_yonetimi.php        # Zil saatlerini yönetmek için PHP scripti
├── zil-v2.ino              # ESP32 için Arduino kodu

Kullanım
ESP32 cihazı çalıştırıldığında Wi-Fi'ye bağlanır ve API'den güncel zil saatlerini çeker.
Veritabanında tanımlı zil saatlerine ulaştığında röleyi tetikleyerek zil çalar.
Yeni zil saatleri eklemek için zilekle.php dosyasını kullanabilir veya zil_yonetimi.php arayüzünden düzenleyebilirsiniz.
Gelecekteki Geliştirme Fikirleri
Web Arayüzü: Zil saatlerini yönetmek için daha kullanıcı dostu bir web paneli.
Mobil Uygulama: API entegrasyonu ile mobil cihazlardan kontrol.
Bildirim Sistemi: Zil saatleri değiştirildiğinde ilgili kişilere bildirim gönderimi.

Katkıda Bulunun
Bu proje açık kaynaklıdır. Her türlü katkı ve öneriyi memnuniyetle karşılıyoruz.
