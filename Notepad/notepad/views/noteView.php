<?php
require_once '../assets/includes/icons.php';
// Veritabanı bağlantısını yap
require_once '../config/database.php';

// Not ID'sini al
$noteId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Not verisini al
$stmt = $pdo->prepare("SELECT id, title, content, file_path, noteColor FROM notes WHERE id = ?");
$stmt->execute([$noteId]);
$note = $stmt->fetch(PDO::FETCH_ASSOC);

// note değişkenini kontrol et
if ($note === false) {
    $error = "Not verisi mevcut değil.";
    ob_start();
    ?>
    <h1>Hata</h1>
    <p><?= htmlspecialchars($error) ?></p>
    <a href="../views/noteList.php" class="text-black">Geri Dön</a>
    <?php
    $content = ob_get_clean();
    require 'layout.php';
    exit; // Hata durumunda işlemi sonlandır
}

$noteColor = htmlspecialchars($note['noteColor']) ?: "#4a4a4a";

$pageTitle = "Not - " . htmlspecialchars($note['title']);
ob_start();
?>

<div class="m-2">
    <?php
    if (!empty($note['file_path'])) {
        echo '<button type="button" class="btn btn-outline-info ml-2" data-toggle="modal" data-target="#imageModal">' . $showPictureIcon . '</button>';
    }
    ?>
    <button type="button" class="btn btn-outline-danger ml-2"
        onclick="window.location.href='../controllers/NoteController.php?action=delete&id=<?php echo htmlspecialchars($note['id']); ?>'">
        <?= $noteDeleteIcon ?>
        <button type="button" class="btn btn-outline-warning ml-2"
            onclick="window.location.href='noteEdit.php?id=<?php echo htmlspecialchars($note['id']); ?>'">
            <?= $noteEditIcon; ?>
        </button>
</div>

</div>
<div class="note-container rounded m-2" style="border: 4px solid <?= $noteColor ?>;">
    <?php
    if (!empty($note['file_path'])) {
        echo '<img src="' . htmlspecialchars($note['file_path']) . '" class="note-image">';
    }
    ?>
    <div>
        <p><?= nl2br($note['content']) ?></p>
    </div>
</div>
<hr>
<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="custom-modal-dialog modal-dialog modal-dialog-centered" role="document">
        <div class="custom-modal-content modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Çıkmak için <kbd>ESC</kbd></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><?= $closeIcon ?></span>
                </button>
            </div>
            <div class="custom-modal-body modal-body">
                <img src="<?= htmlspecialchars($note['file_path']) ?>" class="img-fluid" style="object-fit: contain;"
                    alt="Resim">
            </div>
        </div>
    </div>
</div>
</div>
<!-- /Modal -->
 
<?php
$content = ob_get_clean();
require 'layout.php';
?>