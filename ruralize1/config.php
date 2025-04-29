<?php
session_start();

// Configuração do banco de dados
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

