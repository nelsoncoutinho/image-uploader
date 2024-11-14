<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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
    <header class="main-header">
        <div class="header-container">
            <a href="index.php" class="logo">
                <img src="assets/images/logo.svg" alt="LOGO" class="logo-img">
            </a>
            <nav class="main-nav">
                <ul>
                    <li><a href="index.php" class="nav-link">Início</a></li>
                    <li><a href="gallery.php" class="nav-link">Galeria</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <?php echo showMessages(); ?> 