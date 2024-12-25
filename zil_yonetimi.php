<?php
// Veritabanı bağlantısı
try {
    $db = new PDO("mysql:host=localhost;dbname=anonymous_db;charset=utf8", 'anonymous_db', 'ANONYMOUS_DB_PASSWORD');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

        if (!empty($_POST['id'])) {
            // Güncelleme işlemi
            $id = $_POST['id'];
            $stmt = $db->prepare("UPDATE zil_saatleri SET saat=?, aciklama=?, pazartesi=?, sali=?, carsamba=?, persembe=?, cuma=?, cumartesi=?, pazar=? WHERE id=?");
            $stmt->execute([$saat, $aciklama, $pazartesi, $sali, $carsamba, $persembe, $cuma, $cumartesi, $pazar, $id]);
        } else {
            // Ekleme işlemi
            $stmt = $db->prepare("INSERT INTO zil_saatleri (saat, aciklama, pazartesi, sali, carsamba, persembe, cuma, cumartesi, pazar) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$saat, $aciklama, $pazartesi, $sali, $carsamba, $persembe, $cuma, $cumartesi, $pazar]);
        }
        header('Location: zil_yonetimi.php');
        exit();
    }

    // Silme işlemi
    if (isset($_GET['sil'])) {
        $stmt = $db->prepare("DELETE FROM zil_saatleri WHERE id=?");
        $stmt->execute([$_GET['sil']]);
        header('Location: zil_yonetimi.php');
        exit();
    }

    // Düzenleme için mevcut zil saatini getir
    $editZil = null;
    if (isset($_GET['duzenle'])) {
        $stmt = $db->prepare("SELECT * FROM zil_saatleri WHERE id=?");
        $stmt->execute([$_GET['duzenle']]);
        $editZil = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tüm zil saatlerini listeleme
    $stmt = $db->query("SELECT * FROM zil_saatleri ORDER BY saat ASC");
    $ziller = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Son API çağrısı zamanını al
    $stmt = $db->query("SELECT cagri_zamani FROM api_cagrilari ORDER BY cagri_zamani DESC LIMIT 1");
    $lastApiCall = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zil Yönetim Paneli</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-4">Zil Ekle/Düzenle</h2>
        <form method="POST" class="mb-4">
            <input type="hidden" name="id" value="<?= $editZil['id'] ?? '' ?>">
            <div class="form-group">
                <label for="saat">Saat</label>
                <input type="time" name="saat" id="saat" class="form-control" value="<?= $editZil['saat'] ?? '' ?>" required>
            </div>
            <div class="form-group">
                <label for="aciklama">Açıklama</label>
                <input type="text" name="aciklama" id="aciklama" class="form-control" value="<?= $editZil['aciklama'] ?? '' ?>" required>
            </div>
            <div class="form-group">
                <label>Günler</label><br>
                <input type="checkbox" name="pazartesi" <?= isset($editZil['pazartesi']) && $editZil['pazartesi'] ? 'checked' : '' ?>> Pazartesi<br>
                <input type="checkbox" name="sali" <?= isset($editZil['sali']) && $editZil['sali'] ? 'checked' : '' ?>> Salı<br>
                <input type="checkbox" name="carsamba" <?= isset($editZil['carsamba']) && $editZil['carsamba'] ? 'checked' : '' ?>> Çarşamba<br>
                <input type="checkbox" name="persembe" <?= isset($editZil['persembe']) && $editZil['persembe'] ? 'checked' : '' ?>> Perşembe<br>
                <input type="checkbox" name="cuma" <?= isset($editZil['cuma']) && $editZil['cuma'] ? 'checked' : '' ?>> Cuma<br>
                <input type="checkbox" name="cumartesi" <?= isset($editZil['cumartesi']) && $editZil['cumartesi'] ? 'checked' : '' ?>> Cumartesi<br>
                <input type="checkbox" name="pazar" <?= isset($editZil['pazar']) && $editZil['pazar'] ? 'checked' : '' ?>> Pazar<br>
            </div>
            <button type="submit" class="btn btn-primary">Kaydet</button>
        </form>

        <!-- Zil Saatleri Tablosu -->
        <h2>Zil Listesi</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Saat</th>
                    <th>Açıklama</th>
                    <th>Günler</th>
                    <th>İşlem</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($ziller)): ?>
                    <?php foreach ($ziller as $zil): ?>
                    <tr>
                        <td><?= $zil['saat'] ?></td>
                        <td><?= $zil['aciklama'] ?></td>
                        <td>
                            <?= $zil['pazartesi'] ? 'Pazartesi ' : '' ?>
                            <?= $zil['sali'] ? 'Salı ' : '' ?>
                            <?= $zil['carsamba'] ? 'Çarşamba ' : '' ?>
                            <?= $zil['persembe'] ? 'Perşembe ' : '' ?>
                            <?= $zil['cuma'] ? 'Cuma ' : '' ?>
                            <?= $zil['cumartesi'] ? 'Cumartesi ' : '' ?>
                            <?= $zil['pazar'] ? 'Pazar ' : '' ?>
                        </td>
                        <td>
                            <a href="zil_yonetimi.php?duzenle=<?= $zil['id'] ?>" class="btn btn-warning btn-sm">Düzenle</a>
                            <a href="zil_yonetimi.php?sil=<?= $zil['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Silmek istediğinize emin misiniz?')">Sil</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">Zil saati bulunamadı.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Son API çağrısı zamanı -->
        <h4>Son API Çağrısı Zamanı</h4>
        <p><?= $lastApiCall['cagri_zamani'] ?? 'Henüz API çağrısı yapılmamış.' ?></p>
    </div>
</body>
</html>
