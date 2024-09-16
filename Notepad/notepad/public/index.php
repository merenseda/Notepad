<?php
require_once '../config/database.php'; 
require_once '../controllers/NoteController.php';
$controller = new NoteController($pdo);

// İstekleri işleme
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

switch ($action) {
    case 'view':
        $controller->view($id);
        break;
    case 'add':
        $controller->addNote();
        break;
    case 'edit':
        $controller->editNote();
        break;
    case 'delete':
        $controller->delete($id);
        break;
    default:
        $controller->index();
        break;
}
?>