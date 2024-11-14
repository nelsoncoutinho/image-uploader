<?php


if (file_exists(__DIR__ . '/includes/functions.php')) {
} else {
    die();
}

// Agora inclua os arquivos
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/database.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';

// Teste a função
if (function_exists('formatDate')) {
} else {
    die();
}

// Pegar ID da imagem da URL
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    redirectWith('index.php', 'Imagem não encontrada', 'danger');
}

// Buscar detalhes da imagem
$stmt = $pdo->prepare("SELECT * FROM images WHERE id = ?");
$stmt->execute([$id]);
$image = $stmt->fetch();

if (!$image) {
    redirectWith('index.php', 'Imagem não encontrada', 'danger');
}
?>

<div class="image-view">
    <div class="image-container">
        <img src="<?php echo UPLOAD_DIR . $image['filename']; ?>" 
             alt="<?php echo htmlspecialchars($image['title']); ?>">
    </div>
    
    <div class="image-info">
        <h1><?php echo htmlspecialchars($image['title']); ?></h1>
        
        <div class="metadata">
            <p class="upload-date">
                Enviado em: <?php echo formatDate($image['created_at']); ?>
            </p>
        </div>

        <?php if ($image['description']): ?>
            <div class="description">
                <h3>Descrição:</h3>
                <p><?php echo nl2br(htmlspecialchars($image['description'])); ?></p>
            </div>
        <?php endif; ?>

        <div class="actions">
            <a href="<?php echo UPLOAD_DIR . $image['filename']; ?>" 
               class="button" download>
                Download
            </a>
            
            <!-- Link de compartilhamento -->
            <input type="text" 
                   value="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" 
                   readonly 
                   onclick="this.select();" 
                   class="share-link">
            
            <?php if (isset($_SESSION['admin'])): ?>
                <form action="delete.php" method="POST" class="delete-form">
                    <input type="hidden" name="id" value="<?php echo $image['id']; ?>">
                    <button type="submit" class="button delete" 
                            onclick="return confirm('Tem certeza que deseja excluir esta imagem?');">
                        Excluir
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Adicione estes estilos ao seu arquivo CSS -->
<style>
.image-view {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.image-container {
    margin-bottom: 20px;
    text-align: center;
}

.image-container img {
    max-width: 100%;
    max-height: 800px;
    object-fit: contain;
}

.image-info {
    background: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
}

.metadata {
    color: #666;
    font-size: 0.9em;
    margin: 10px 0;
}

.description {
    margin: 20px 0;
    line-height: 1.6;
}

.actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
    flex-wrap: wrap;
}

.button {
    display: inline-block;
    padding: 10px 20px;
    background: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    border: none;
    cursor: pointer;
}

.button:hover {
    background: #0056b3;
}

.button.delete {
    background: #dc3545;
}

.button.delete:hover {
    background: #c82333;
}

.share-link {
    flex: 1;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.delete-form {
    display: inline;
}
</style>

<?php
// Se quiser adicionar um sistema de comentários básico:
if (isset($_POST['comment'])) {
    $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
    if (!empty($comment)) {
        $stmt = $pdo->prepare("INSERT INTO comments (image_id, comment) VALUES (?, ?)");
        $stmt->execute([$id, $comment]);
        redirectWith("view.php?id=$id", 'Comentário adicionado com sucesso');
    }
}

// Buscar comentários
$stmt = $pdo->prepare("SELECT * FROM comments WHERE image_id = ? ORDER BY created_at DESC");
$stmt->execute([$id]);
$comments = $stmt->fetchAll();
?>

<!-- Seção de comentários -->
<div class="comments-section">
    <h3>Comentários</h3>
    
    <form action="" method="POST" class="comment-form">
        <textarea name="comment" placeholder="Deixe seu comentário..." required></textarea>
        <button type="submit" class="button">Comentar</button>
    </form>

    <div class="comments-list">
        <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <p><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
                <small><?php echo formatDate($comment['created_at']); ?></small>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
.comments-section {
    margin-top: 40px;
}

.comment-form {
    margin: 20px 0;
}

.comment-form textarea {
    width: 100%;
    min-height: 100px;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.comments-list {
    margin-top: 20px;
}

.comment {
    background: #fff;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-bottom: 10px;
}

.comment small {
    color: #666;
    display: block;
    margin-top: 5px;
}
</style>

</div>
</body>
</html>
