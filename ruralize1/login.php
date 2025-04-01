<?php
$tituloPagina = "Login";
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare("SELECT * FROM a03_usuario WHERE A03_email = ? AND A03_senha = ?");
    $stmt->execute([$email, $senha]);
    $usuario = $stmt->fetch();

    if ($usuario) {
        $_SESSION['usuario_id'] = $usuario['A03_id'];
        $_SESSION['usuario_nome'] = $usuario['A03_nome'];
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['erro'] = "Credenciais inválidas!";
    }
}


include 'header.php';
?>

<div style="display: flex; height: 100vh;">
    <div style="flex: 1; display: flex; align-items: center; justify-content: center;">
    <img src="img/Login.png "style="max-width: 100%; height: auto;"> 
    </div>
    <div style="flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <h2>Login</h2>
        <form method="POST" style="display: flex; flex-direction: column; align-items: center; width: 100%; max-width: 400px;">
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">Entrar</button>
        </form>
        <p style="margin-top: 10px; text-align: center;">Ainda não tem conta? <a href="registro.php">Registre-se</a></p>
    </div>
</div>

<?php include 'footer.php'; ?>