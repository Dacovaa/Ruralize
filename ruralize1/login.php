<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= 'login' ?></title>
    <link rel="stylesheet" href="styles/login.css?v=3">
</head>



<?php
//$tituloPagina = "Login";//
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

<div class="mainLogin">
    <div class="divImagem" style="flex: 1; display: flex; align-items: center; justify-content: center;">
    <img class="imageLogin" src="img/trofeuRuralize.png ">
    </div>
    <div class="formulario">
        <div class="styleFormulario">
        <h2>Login</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">Entrar</button>
        </form>
        <div class="linksBottom">
            <p>Ainda não tem conta? <a class="botaoRegistrar" href="registro.php">Registre-se</a></p>
            <p><a href="index.php">Continuar sem login</a></p>
        </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>