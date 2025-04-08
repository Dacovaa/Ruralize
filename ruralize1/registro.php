<?php
$tituloPagina = "Registro";
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $email, $senha]);
        $_SESSION['mensagem'] = "Registro realizado com sucesso! Faça login.";
        header("Location: login.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['erro'] = "Erro ao registrar: " . $e->getMessage();
    }
}

include 'header.php';
?>

<h2>Registro</h2>
<form method="POST">
    <input type="text" name="nome" placeholder="Nome completo" required>
    <input type="email" name="email" placeholder="E-mail" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <button type="submit">Registrar</button>
</form>
<p>Já tem conta? <a href="login.php">Faça login</a></p>

<?php include 'footer.php'; ?>