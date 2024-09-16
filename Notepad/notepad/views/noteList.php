<?php
require_once '../assets/includes/icons.php';
// Veritabanı bağlantısını yap
require_once '../config/database.php';

// Arama ve sıralama parametrelerini al
$ToBeSearched = isset($_GET['search']) ? $_GET['search'] : "";
$sortOption = isset($_GET['sort']) ? $_GET['sort'] : "";

// Sıralama koşulları
$orderBy = "ORDER BY create_date DESC"; // Varsayılan sıralama

switch ($sortOption) {
    case 'oldest':
        $orderBy = "ORDER BY create_date ASC";
        break;
    case 'alphabet_az':
        $orderBy = "ORDER BY title ASC";
        break;
    case 'alphabet_za':
        $orderBy = "ORDER BY title DESC";
        break;
}

// Verileri al
$sql = "SELECT id, title, content,file_path, noteColor FROM notes $orderBy";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Arama işlemi
if (!empty($ToBeSearched)) {
    // Arama terimi varsa, eşleşenleri bul
    $searchList = [];
    $foundsList = [];

    foreach ($notes as $note) {
        if (stripos($note['title'], $ToBeSearched) !== false) {
            $foundsList[] = $note; // Eşleşen notları ekle
        }
    }

    $notes = $foundsList; // Arama sonuçlarını göster
}

// Sayfa başlığı
$pageTitle = 'Notlarım';
ob_start();

?>

<body class="bg-dark text-light">
    <main class="container bg-light text-light col-md-12 rounded mb-1">
        <br>
        <form class="form-inline w-100 mb-3 d-flex align-items-center" method="GET">
            <input class="form-control search-bar w-75" type="search" name="search" placeholder="Arama yapın"
                aria-label="Arama" value="<?= htmlspecialchars($ToBeSearched); ?>">
            <button class="btn btn-outline-dark ml-2" type="submit">Ara</button>
            <a href="?search=" class="btn btn-outline-dark ml-2">Temizle</a>
            <a href="noteAdd.php" class="btn btn-outline-dark ml-2">Yeni Not Ekle</a>

            <!-- Sıralama -->
            <select class="form-select ml-auto mt-2" name="sort" onchange="this.form.submit()">
                <option value="" disabled selected>Sıralama Seçin</option>
                <option value="oldest" <?= $sortOption == 'oldest' ? 'selected' : '' ?>>Oluşturma Tarihi: En Eski</option>
                <option value="newest" <?= $sortOption == 'newest' ? 'selected' : '' ?>>Oluşturma Tarihi: En Yeni</option>
                <option value="alphabet_az" <?= $sortOption == 'alphabet_az' ? 'selected' : '' ?>>Alfabeye Göre: A-Z
                </option>
                <option value="alphabet_za" <?= $sortOption == 'alphabet_za' ? 'selected' : '' ?>>Alfabeye Göre: Z-A
                </option>
            </select>
        </form>
        <div class="row">
            <?php
            if (!empty($notes)) {
                $counter = 0; // Satır başı sayacı
                foreach ($notes as $note) {
                    if ($counter % 6 == 0 && $counter > 0) {
                        echo '</div><div class="row">'; // Her 6 notta yeni satır başlat
                    }
                    ?>
                    <!-- Card -->
                    <div class="col-md-2 mb-3">
                        <div class="card text-bg-dark rounded"
                            style="border: 4px solid <?= htmlspecialchars($note['noteColor']) ?>; width: 100%; height: 19rem;">
                            <b><?= !empty($note['file_path']) ? '&nbsp;' . $fileIcon . '&nbsp;' . htmlspecialchars($note['title']) : "&nbsp;&nbsp;" . htmlspecialchars($note['title']); ?></b>
                            <div class="card-body sınır">
                                <p class="card-title text-secondary">
                                    <a class="text-secondary"
                                        href='noteEdit.php?id=<?= htmlspecialchars($note['id']) ?>'><?= $editIcon ?></a>
                                    <a class="text-secondary"><?= $space ?></a>
                                    <a class="text-secondary"
                                        href='../controllers/NoteController.php?action=delete&id=<?= htmlspecialchars($note['id']) ?>'
                                        onclick="return confirm('Bu notu silmek istediğinizden emin misiniz?')">
                                        <?= $deleteIcon ?>
                                    </a>
                                    <a class="text-secondary"><?= $onespace ?></a>
                                    <a class="text-secondary"
                                        href='../views/noteView.php?id=<?= htmlspecialchars($note['id']) ?>'><?= $showIcon ?></a>
                                </p>
                                <p class="card-text"><?= nl2br($note['content']) ?></p>
                            </div>
                        </div>
                    </div>
                    <!-- /Card -->
                    <?php
                    $counter++;
                }
            } else {
                echo '<p class="text-warning">Not bulunamadı.</p>';
            }
            ?>
        </div>
    </main>
</body>

<?php
$content = ob_get_clean();
require '../views/layout.php';
?>