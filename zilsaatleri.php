<?php
header('Content-Type: application/json');
date_default_timezone_set('Europe/Istanbul');

try {
    // Veritabanı bağlantısı (PDO kullanarak)
    $db = new PDO("mysql:host=localhost;dbname=anonymous_db;charset=utf8", 'anonymous_db', 'ANONYMOUS_DB_PASSWORD');
    // PDO hata modunu etkinleştir
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    
    // Şu anki zamanı alın
    $cagriZamani = date('Y-m-d H:i:s');

    // API çağrı zamanını veritabanına kaydedin
    $sql = "INSERT INTO api_cagrilari (cagri_zamani, aciklama) VALUES (:cagri_zamani, :aciklama)";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':cagri_zamani' => $cagriZamani,
        ':aciklama' => 'API çağrısı kaydedildi'
    ]);

    // Şu anki günü alalım (1 = Pazartesi, 7 = Pazar)
    $gun = date('N');
    $gunIsimleri = ['Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi', 'Pazar'];

    // SQL sorgusu: O gün çalacak zil saatlerini seç ve saatlere göre sırala
    $sql = "SELECT saat, aciklama FROM zil_saatleri WHERE ";

    switch ($gun) {
        case 1:
            $sql .= "pazartesi = 1";
            break;
        case 2:
            $sql .= "sali = 1";
            break;
        case 3:
            $sql .= "carsamba = 1";
            break;
        case 4:
            $sql .= "persembe = 1";
            break;
        case 5:
            $sql .= "cuma = 1";
            break;
        case 6:
            $sql .= "cumartesi = 1";
            break;
        case 7:
            $sql .= "pazar = 1";
            break;
    }

    // Saatlere göre küçükten büyüğe sıralama
    $sql .= " ORDER BY saat ASC";

    // Sorguyu hazırla ve çalıştır
    $stmt = $db->prepare($sql);
    $stmt->execute();

    // Sonuçları al
    $zil_saatleri = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Gün ismini açıklamaya ekle
    foreach ($zil_saatleri as &$zil) {
        $zil['aciklama'] .= ' - ' . $gunIsimleri[$gun - 1];  // Gün ismini ekle
    }

    // Anlık saat bilgisini al ve sonuçlara ekle
    $currentTime = date('H:i:s');
    $response = [
        'current_time' => $currentTime,  // Anlık saat bilgisi
        'zil_saatleri' => $zil_saatleri  // Zil saatleri
    ];

    // JSON formatına çevir ve çıktıyı göster
    echo json_encode($response);

} catch (PDOException $e) {
    // Hata durumunda mesajı göster
    echo 'Bağlantı hatası: ' . $e->getMessage();
}
?>
