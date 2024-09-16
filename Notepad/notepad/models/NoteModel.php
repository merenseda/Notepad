<?php

require_once "../config/database.php";
class NoteModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllNotes()
    {
        $stmt = $this->pdo->query('SELECT id, title, content FROM notes');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchNotes($searchTerm, $orderBy)
    {
        $sql = "SELECT * FROM notes WHERE title LIKE :searchTerm $orderBy";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':searchTerm' => "%$searchTerm%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNoteById($id)
    {
        try {
            $stmt = $this->pdo->prepare('SELECT id, title, content FROM notes WHERE id = ?');
            $stmt->execute([$id]);
            $note = $stmt->fetch();
            if (!$note) {
                echo "Veri bulunamadı.";
            }
            return $note;
        } catch (Exception $e) {
            echo "Hata: " . $e->getMessage();
        }
    }

    // Yeni not ekleme
    public function addNote($title, $content, $filePath , $noteColor)
    {
        $stmt = $this->pdo->prepare("INSERT INTO notes (title, content, file_path, noteColor, create_date) VALUES (?, ?, ?, ?, NOW())");
        return $stmt->execute([$title, $content, $filePath, $noteColor]);
    }

    // Mevcut notu güncelleme
    public function updateNote($id, $title, $content, $filePath, $noteColor)
    {
        $stmt = $this->pdo->prepare("UPDATE notes SET title = ?, content = ?,file_path = ?, noteColor = ? WHERE id = ?");
        return $stmt->execute([$title, $content, $filePath, $noteColor, $id]);
    }

    public function deleteNoteById($id)
    {
        $sql = "DELETE FROM notes WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    }
}

function redirectToPreviousPage($defaultPage = '/') {
    if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
        // Referer mevcutsa kullanıcıyı önceki sayfaya yönlendir
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        // Referer yoksa varsayılan bir sayfaya yönlendir
        header('Location: ' . $defaultPage);
    }
    exit();
}
?>