<<<<<<< HEAD
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

=======
<?php
$tituloPagina = "Registro";
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $cep = $_POST['cep'];
    $endereco = $_POST['endereco'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];

    try {
        $stmt = $pdo->prepare("INSERT INTO a03_usuario (A03_nome, A03_email, A03_senha, A03_cep, A03_endereco, A03_bairro, A03_cidade, A03_estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nome, $email, $senha, $cep, $endereco, $bairro, $cidade, $estado]);
        $_SESSION['mensagem'] = "Registro realizado com sucesso! Faça login.";
        header("Location: login.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['erro'] = "Erro ao registrar: " . $e->getMessage();
    }
}

include 'header.php';
?>


<div style="display: flex; height: 100vh;">
    <div style="flex: 1; display: flex; align-items: center; justify-content: center;">
    <img src="img/Login.png "style="max-width: 100%; height: auto;"> 
    </div>
    <div style="flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <h2>Registro</h2>
        <form method="POST" style="display: flex; flex-direction: column; align-items: center; width: 100%; max-width: 400px;">
<form method="POST">
    <input type="text" name="nome" placeholder="Nome completo" required>
    <input type="email" name="email" placeholder="E-mail" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <input type="text" name="cep" id="cep" placeholder="CEP" required>
    <input type="text" name="endereco" id="endereco" placeholder="Endereço" required>
    <input type="text" name="bairro" id="bairro" placeholder="Bairro" required>
    <input type="text" name="cidade" id="cidade" placeholder="Cidade" required>
    <input type="text" name="estado" id="estado" placeholder="Estado" required>
    <button type="submit">Registrar</button>
</form>
<p style="margin-top: 10px; text-align: center;">Já tem conta? <a href="login.php">Faça login</a></p>

<script>
document.getElementById('cep').addEventListener('blur', function() {
    var cep = this.value.replace(/\D/g, '');
    if (cep.length === 8) {
        fetch('https://viacep.com.br/ws/' + cep + '/json/')
        .then(response => response.json())
        .then(data => {
            if (!data.erro) {
                document.getElementById('endereco').value = data.logradouro;
                document.getElementById('bairro').value = data.bairro;
                document.getElementById('cidade').value = data.localidade;
                document.getElementById('estado').value = data.uf;
            } else {
                alert('CEP não encontrado.');
            }
        })
        .catch(error => console.error('Erro ao buscar CEP:', error));
    }
});
</script>

>>>>>>> 94153a8f956e56540b905670b510c9ef2536f246
<?php include 'footer.php'; ?>