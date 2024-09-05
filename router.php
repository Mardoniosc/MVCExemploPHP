<?php
// Se o arquivo requisitado realmente existir, não fazer nada
if (file_exists(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

// Caso contrário, carregar o index.php para processar a requisição
require_once __DIR__ . '/index.php';
