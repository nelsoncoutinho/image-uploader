<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';

// Adicionar verificação de erro para o header
if (!file_exists('includes/header.php')) {
    die('Arquivo header.php não encontrado');
}
require_once 'includes/header.php';

// Buscar imagens do banco de dados
try {
    $stmt = $pdo->query("SELECT * FROM images ORDER BY created_at DESC");
    $images = $stmt->fetchAll();
    
    // Melhorar o debug para verificar os caminhos das imagens
    echo "<!-- Debug informação: -->";
    if (!empty($images)) {
        foreach ($images as $image) {
            $fullPath = __DIR__ . '/uploads/' . $image['filename'];
            echo "<!-- Caminho completo: " . $fullPath . " -->";
            echo "<!-- Arquivo existe: " . (file_exists($fullPath) ? 'Sim' : 'Não') . " -->";
        }
    }
} catch (PDOException $e) {
    die('Erro ao buscar imagens: ' . $e->getMessage());
}

?>

<main class="gallery">
    <h1>Galeria de Imagens</h1>
    
    <div class="gallery-grid">
        <?php if (!empty($images)): ?>
            <?php foreach ($images as $image): ?>
                <div class="gallery-item">
                    <a href="view.php?id=<?php echo htmlspecialchars($image['id']); ?>">
                        <img src="<?php echo UPLOAD_DIR . htmlspecialchars($image['filename']); ?>" 
                             alt="<?php echo htmlspecialchars($image['title']); ?>"
                             loading="lazy"
                             onerror="this.onerror=null; this.src='images/placeholder.jpg'; console.log('Erro ao carregar: <?php echo UPLOAD_DIR . $image['filename']; ?>');">
                    </a>
                    <div class="image-info">
                        <h3><?php echo htmlspecialchars($image['title']); ?></h3>
                        <?php if (!empty($image['description'])): ?>
                            <p><?php echo htmlspecialchars($image['description']); ?></p>
                        <?php endif; ?>
                        <span class="upload-date">
                            <?php echo date('d/m/Y', strtotime($image['created_at'])); ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-images">Nenhuma imagem encontrada.</p>
        <?php endif; ?>
    </div>
</main>
