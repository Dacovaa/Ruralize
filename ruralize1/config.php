<<<<<<< HEAD
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
=======
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
>>>>>>> 94153a8f956e56540b905670b510c9ef2536f246
?>