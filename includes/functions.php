<?php

/**
 * Formata a data para o padrão brasileiro
 * @param string $date A data a ser formatada
 * @return string Data formatada
 */
function formatDate($date) {
    if (!$date) return '';
    
    $timestamp = strtotime($date);
    if ($timestamp === false) return '';
    
    return date('d/m/Y H:i', $timestamp);
}

/**
 * Gera um nome único para o arquivo
 */
function generateUniqueFilename($originalName) {
    $extension = pathinfo($originalName, PATHINFO_EXTENSION);
    return uniqid() . '_' . time() . '.' . $extension;
}

/**
 * Limita o texto a um número específico de caracteres
 */
function limitText($text, $limit = 100) {
    if (strlen($text) <= $limit) {
        return $text;
    }
    return substr($text, 0, $limit) . '...';
}

/**
 * Valida o tipo de arquivo
 */
function isValidFileType($type) {
    return in_array($type, ALLOWED_TYPES);
}

/**
 * Valida o tamanho do arquivo
 */
function isValidFileSize($size) {
    return $size <= MAX_FILE_SIZE;
}

/**
 * Retorna mensagem de erro formatada
 */
function showError($message) {
    return "<div class='alert alert-danger'>$message</div>";
}

/**
 * Retorna mensagem de sucesso formatada
 */
function showSuccess($message) {
    return "<div class='alert alert-success'>$message</div>";
}

/**
 * Redireciona com mensagem
 */
function redirectWith($url, $message, $type = 'success') {
    $_SESSION['message'] = $message;
    $_SESSION['message_type'] = $type;
    header("Location: $url");
    exit;
}

/**
 * Exibe mensagens da sessão
 */
function showMessages() {
    if (isset($_SESSION['message'])) {
        $type = $_SESSION['message_type'] ?? 'success';
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
        return "<div class='alert alert-$type'>$message</div>";
    }
    return '';
} 