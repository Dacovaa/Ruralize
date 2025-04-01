<?php
$tituloPagina = "Confirmação de Pedido";
require_once 'config.php';

if (!estaLogado()) {
    $_SESSION['erro'] = "Faça login para visualizar seu pedido!";
    header("Location: login.php");
    exit;
}

include 'header.php';
?>

<div class="confirmacao-container">
    <h2>Pedido Realizado com Sucesso!</h2>
    
    <?php if (isset($_SESSION['mensagem'])): ?>
        <p class="mensagem-sucesso"> <?= htmlspecialchars($_SESSION['mensagem']) ?> </p>
        <?php unset($_SESSION['mensagem']); ?>
    <?php endif; ?>
    
    <p>Acompanhe o status do seu pedido na sua conta.</p>
    <a href="pedidos.php" class="botao">Meus Pedidos</a>
    <a href="produtos.php" class="botao">Continuar Comprando</a>
</div>

<?php include 'footer.php'; ?>
