<?php
require_once '../models/NoteModel.php';

class NoteController
{
    private $noteModel;

    public function __construct($pdo)
    {
        $this->noteModel = new NoteModel($pdo);
    }

    public function listNotes()
    {
        $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
        $sortOption = isset($_GET['sort']) ? $_GET['sort'] : '';

        // Sıralama seçenekleri
        $orderBy = 'ORDER BY create_date DESC';
        switch ($sortOption) {
            case 'oldest':
                $orderBy = 'ORDER BY create_date ASC';
                break;
            case 'alphabet_az':
                $orderBy = 'ORDER BY title ASC';
                break;
            case 'alphabet_za':
                $orderBy = 'ORDER BY title DESC';
                break;
        }

        // Arama işlemi
        $notes = $this->noteModel->searchNotes($searchTerm, $orderBy);

        if ($notes === false) {
            echo "Veri çekme hatası.";
        } elseif (empty($notes)) {
            echo "Not bulunamadı.";
        } else {
            // Notları işleyin
        }

        // View'e veri gönder
        require '../views/noteList.php';
    }

    public function index()
    {
        // Veritabanından notları çek
        $notes = $this->noteModel->getAllNotes();

        // Notları view'e gönder
        require 'views/noteList.php';
    }

    public function view($id)
    {
        $note = $this->noteModel->getNoteById($id);
        if ($note) {
            require '../views/noteView.php';
        } else {
            echo "Not verisi mevcut değil.";
        }
    }

    // Yeni not ekleme işlemi
    public function addNote()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $noteColor = $_POST['noteColorPicker'];

            // Dosya işlemi
            $filePath = null;
            if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                $filePath = '../uploads/' . basename($_FILES['file']['name']);
                move_uploaded_file($_FILES['file']['tmp_name'], $filePath);
            }

            $this->noteModel->addNote($title, $content, $filePath, $noteColor);
            header("Location: ../views/noteList.php");
        }
    }

    // Mevcut notu güncelleme işlemi
    public function editNote()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $content = $_POST['content'];
            $noteColor = $_POST['noteColor'];

            // Dosya işlemi
            $filePath = null;
            if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                $filePath = '../uploads/' . basename($_FILES['file']['name']);
                move_uploaded_file($_FILES['file']['tmp_name'], $filePath);
            }

            $this->noteModel->updateNote($id, $title, $content, $filePath, $noteColor);
            header("Location: ../views/noteList.php");
        }
    }

    public function deleteNoteById($id)
    {
        $this->noteModel->deleteNoteById($id);
       header: redirectToPreviousPage();
    }
}

// Eylemi kontrol edin ve uygun yöntemi çağırın
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = $_GET['id'] ?? null;

    if ($id) {
        $controller = new NoteController($pdo);
        $controller->deleteNoteById($id);
    }
}
?>