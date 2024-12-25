<?php
// Veritabanı bağlantısı (PDO)
try {
    $db = new PDO("mysql:host=localhost;dbname=anonymous_db;charset=utf8", 'anonymous_db', 'ANONYMOUS_DB_PASSWORD');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Zil saatleri listeleme (tüm kayıtları getir)
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $stmt = $db->query("SELECT * FROM zil_saatleri ORDER BY saat ASC");
        $ziller = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($ziller);
        exit();
    }

    // Zil ekleme veya güncelleme işlemi
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $saat = $_POST['saat'];
        $aciklama = $_POST['aciklama'];
        $pazartesi = isset($_POST['pazartesi']) ? 1 : 0;
        $sali = isset($_POST['sali']) ? 1 : 0;
        $carsamba = isset($_POST['carsamba']) ? 1 : 0;
        $persembe = isset($_POST['persembe']) ? 1 : 0;
        $cuma = isset($_POST['cuma']) ? 1 : 0;
        $cumartesi = isset($_POST['cumartesi']) ? 1 : 0;
        $pazar = isset($_POST['pazar']) ? 1 : 0;
        
        // Güncelleme işlemi
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $id = $_POST['id'];
            $sql = "UPDATE zil_saatleri SET saat=?, aciklama=?, pazartesi=?, sali=?, carsamba=?, persembe=?, cuma=?, cumartesi=?, pazar=? WHERE id=?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$saat, $aciklama, $pazartesi, $sali, $carsamba, $persembe, $cuma, $cumartesi, $pazar, $id]);
            echo "Zil güncellendi!";
        } else { 
            // Ekleme işlemi
            $sql = "INSERT INTO zil_saatleri (saat, aciklama, pazartesi, sali, carsamba, persembe, cuma, cumartesi, pazar) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$saat, $aciklama, $pazartesi, $sali, $carsamba, $persembe, $cuma, $cumartesi, $pazar]);
            echo "Zil başarıyla eklendi!";
        }
        exit();
    }
} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zil Yönetim Paneli</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Zil Ekle/Düzenle</h2>
    <form id="zilForm">
        <input type="hidden" name="id" id="id">
        Saat: <input type="time" name="saat" id="saat" required><br><br>
        Açıklama: <input type="text" name="aciklama" id="aciklama" required><br><br>
        Günler:<br>
        <input type="checkbox" name="pazartesi" id="pazartesi"> Pazartesi<br>
        <input type="checkbox" name="sali" id="sali"> Salı<br>
        <input type="checkbox" name="carsamba" id="carsamba"> Çarşamba<br>
        <input type="checkbox" name="persembe" id="persembe"> Perşembe<br>
        <input type="checkbox" name="cuma" id="cuma"> Cuma<br>
        <input type="checkbox" name="cumartesi" id="cumartesi"> Cumartesi<br>
        <input type="checkbox" name="pazar" id="pazar"> Pazar<br><br>
        <input type="submit" value="Kaydet">
    </form>

    <h2>Zil Listesi</h2>
    <table id="zilListesi" border="1">
        <thead>
            <tr>
                <th>Saat</th>
                <th>Açıklama</th>
                <th>Günler</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            <!-- Ziller buraya yüklenecek -->
        </tbody>
    </table>

    <script>
        // Sayfa yüklendiğinde zil saatlerini listele
        $(document).ready(function() {
            listeleZiller();

            // Form gönderimi
            $('#zilForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'zil_yonetimi.php',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert(response);
                        listeleZiller(); // Güncel listeyi çek
                        $('#zilForm')[0].reset(); // Formu temizle
                    }
                });
            });
        });

        // Zil saatlerini listeleyen fonksiyon
        function listeleZiller() {
            $.ajax({
                type: 'GET',
                url: 'zil_yonetimi.php',
                success: function(response) {
                    var ziller = JSON.parse(response);
                    var html = '';
                    ziller.forEach(function(zil) {
                        html += '<tr>';
                        html += '<td>' + zil.saat + '</td>';
                        html += '<td>' + zil.aciklama + '</td>';
                        html += '<td>';
                        html += zil.pazartesi == 1 ? 'Pazartesi ' : '';
                        html += zil.sali == 1 ? 'Salı ' : '';
                        html += zil.carsamba == 1 ? 'Çarşamba ' : '';
                        html += zil.persembe == 1 ? 'Perşembe ' : ''; 
                        html += zil.cuma == 1 ? 'Cuma ' : '';
                        html += zil.cumartesi == 1 ? 'Cumartesi ' : '';
                        html += zil.pazar == 1 ? 'Pazar ' : '';
                        html += '</td>';
                        html += '<td><button onclick="duzenleZil(' + zil.id + ')">Düzenle</button></td>';
                        html += '</tr>';
                    });
                    $('#zilListesi tbody').html(html);
                }
            });
        }

        // Zil düzenleme işlemi için verileri forma yükle
        function duzenleZil(id) {
            $.ajax({
                type: 'GET',
                url: 'zil_yonetimi.php',
                success: function(response) {
                    var ziller = JSON.parse(response);
                    var zil = ziller.find(z => z.id == id);
                    $('#id').val(zil.id);
                    $('#saat').val(zil.saat);
                    $('#aciklama').val(zil.aciklama);
                    $('#pazartesi').prop('checked', zil.pazartesi == 1);
                    $('#sali').prop('checked', zil.sali == 1);
                    $('#carsamba').prop('checked', zil.carsamba == 1);
                    $('#persembe').prop('checked', zil.persembe == 1);
                    $('#cuma').prop('checked', zil.cuma == 1);
                    $('#cumartesi').prop('checked', zil.cumartesi == 1);
                    $('#pazar').prop('checked', zil.pazar == 1);
                }
            });
        }
    </script>
</body>
</html>
