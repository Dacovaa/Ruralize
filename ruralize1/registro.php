
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= 'Cadastro' ?></title>
    <link rel="stylesheet" href="styles/login.css?v=3">
    <link rel="stylesheet" href="styles/registro.css?v=3">
</head>


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


<div class="mainLogin">
    <div class=".divImagem" style="flex: 1; display: flex; align-items: center; justify-content: center;">
    <img class="imageLogin" src="img/trofeuRuralize.png "> 
    </div>
    <div class="formulario">
        <div class="styleFormulario">
            <h2>Registro</h2>
            <form method="POST">
    <form method="POST">
        <div class="etapa1" id="etapa1">
            <input id="nome" type="text" name="nome" placeholder="Nome completo" required>
            <input id="email" type="email" name="email" placeholder="E-mail" required>
            <input id="senha" type="password" name="senha" placeholder="Senha" required>
            <button type="button" onclick="proximaEtapa()">Avançar</button>
        </div>
        <div class="etapa2" id="etapa2">
            <input type="text" name="cep" id="cep" placeholder="CEP" required>
            <input type="text" name="endereco" id="endereco" placeholder="Endereço" required>
            <input type="text" name="bairro" id="bairro" placeholder="Bairro" required>
            <input type="text" name="cidade" id="cidade" placeholder="Cidade" required>
            <input type="text" name="estado" id="estado" placeholder="Estado" required>
            <button type="submit">Registrar</button>
            <p class="voltarEtapa" onclick="etapaAnterior()">Voltar</p>
        </div>
    </form>
    <p>Já tem conta? <a class="" href="login.php">Faça login</a></p>
        </div>
    </div>
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

function proximaEtapa(){
    const nome = document.getElementById("nome").value;
    const email = document.getElementById("email").value;
    const senha = document.getElementById("senha").value;

    if (nome === "" || email === "" || senha === "") {
    alert("Por favor, preencha todos os campos");
    return false;
  }

    document.getElementById('etapa1').style.display = 'none';
    document.getElementById('etapa2').style.display = 'block';
}

function etapaAnterior(){
    document.getElementById('etapa1').style.display = 'block';
    document.getElementById('etapa2').style.display = 'none';
}
</script>

<?php include 'footer.php'; ?>