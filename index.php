<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';

// Adicionar verificação de erro para o header
if (!file_exists('includes/header.php')) {
}
require_once 'includes/header.php';


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Imagens</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Upload de Imagens</h1>
        
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="image" accept="image/*" required>
            <input type="text" name="title" placeholder="Título da imagem" required>
            <textarea name="description" placeholder="Descrição (opcional)"></textarea>
            <button type="submit">Enviar Imagem</button>
        </form>

        
    </div>
</body>
</html>
