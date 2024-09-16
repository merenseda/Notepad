<?php
require_once '../config/database.php';
require_once '../models/NoteModel.php';
require_once '../controllers/NoteController.php';

$noteModel = new NoteModel($pdo);
$noteController = new NoteController($pdo);


// Not ID'sini al
$noteId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Not verisini al
$stmt = $pdo->prepare("SELECT id, title, content, file_path, noteColor FROM notes WHERE id = ?");
$stmt->execute([$noteId]);
$note = $stmt->fetch(PDO::FETCH_ASSOC);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $noteController->editNote();
}
$noteColor = isset($note['noteColor']) ? $note['noteColor'] : '#ffffff';
$pageTitle = 'Notu Düzenle';
ob_start();
?>

<body class="bg-dark text-light">
    <main class="container bg-light text-light col-md-6 rounded mb-3">
        <form method="post" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
            <!-- Not ID'sini gizli input ile gönder -->
            <input type="hidden" name="id" value="<?= $note['id']; ?>">

            <!-- Title -->
            <div class="form-group">
                <label for="title" class="text-secondary">Not Başlığı:</label>
                <input type="text" id="title" name="title" class="form-control shadow-sm" value="<?= $note['title']; ?>" required>
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="text-secondary">Not İçeriği:</label>
                <!-- Include stylesheet -->
                <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />

                <!-- Create the editor container -->
                <div class="radius" id="editor" style="position: relative; z-index: 10;">
                    <?= $note['content']; ?>
                </div>

                <!-- Create a textarea to store data -->
                <textarea id="content" name="content" style="display: none;"></textarea>

                <!-- Include the Quill library -->
                <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
                <!-- Initialize Quill editor -->
                <script>
                    // Initialize Quill editor
                    const quill = new Quill('#editor', {
                        theme: 'snow'
                    });

                    // Function to sync Quill content with textarea
                    function syncQuillWithTextarea() {
                        document.getElementById('content').value = quill.root.innerHTML;
                    }

                    // Listen for changes in the editor and update textarea
                    quill.on('text-change', syncQuillWithTextarea);

                    // Initial sync on page load
                    syncQuillWithTextarea();
                </script>
            </div>

            <!-- File Upload & Color Picker -->
            <div class="form-group d-flex align-items-center">
                <!-- File Upload -->
                <div>
                    <label for="file" class="text-secondary">Dosya Yükle (isteğe bağlı):</label>
                    <input type="file" id="file" name="file" class="form-control-file">
                    <p class="text-muted">Resmi silmek için bu alanı boş bırakınız.</p>
                </div>
                <!-- Color Picker -->
                <div class="ml-3">
                    <label for="exampleColorInput" class="form-label">Not Rengi:</label>
                    <input type="color" class="form-control form-control-color" id="noteColorPicker" name="noteColor" value="<?= $note['noteColor']; ?>" title="Not Rengi">
                </div>
            </div>

            <!-- Button -->
            <button type="submit" class="btn btn-secondary btn-block">Notu Güncelle</button>
        </form>
    </main>
</body>

<?php
$content = ob_get_clean();
require '../views/layout.php';
?>
