<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['image'];
        
        // Validações
        if (!in_array($file['type'], ALLOWED_TYPES)) {
            die('Tipo de arquivo não permitido');
        }
        
        if ($file['size'] > MAX_FILE_SIZE) {
            die('Arquivo muito grande');
        }
        
        // Gerar nome único para o arquivo
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $extension;
        
        // Mover arquivo para pasta de uploads
        if (move_uploaded_file($file['tmp_name'], UPLOAD_DIR . $filename)) {
            // Salvar no banco de dados
            $stmt = $pdo->prepare("INSERT INTO images (title, description, filename) VALUES (?, ?, ?)");
            $stmt->execute([$title, $description, $filename]);
            
            header('Location: index.php');
            exit;
        }
    }
    
    die('Erro no upload');
}
