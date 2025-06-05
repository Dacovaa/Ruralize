<?php
session_start();

function carregarEnv($caminho) {
    if (!file_exists($caminho)) return;

    $linhas = file($caminho, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($linhas as $linha) {
        if (str_starts_with($linha, '#') || !str_contains($linha, '=')) continue;
        list($chave, $valor) = explode('=', $linha, 2);
        $_ENV[trim($chave)] = trim($valor);
    }
}

carregarEnv(__DIR__ . '/.env');

// Configuração do banco de dados com .env
// $host = $_ENV['DB_HOST'];
// $db   = $_ENV['DB_NAME'];
// $user = $_ENV['DB_USER'];
// $pass = $_ENV['DB_PASS'];
// $charset = $_ENV['DB_CHARSET'];

$host = 'localhost';
$db   = 'ruralize1';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}

// Função para verificar login
function estaLogado() {
    return isset($_SESSION['usuario_id']);
}
function getPdo() {
    global $pdo; // Usa a variável global $pdo já criada
    return $pdo;
}

// root@127.0.0.1:3306//
?>

