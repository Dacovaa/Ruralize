<?php
$tituloPagina = "Checkout";
require_once 'config.php';

if (!estaLogado() || empty($_SESSION['carrinho'])) {
    header("Location: index.php");
    exit;
}

// Lógica de finalização de compra
unset($_SESSION['carrinho']);
$_SESSION['mensagem'] = "Compra finalizada com sucesso!";

include 'header.php';
?>

<h2>Obrigado por comprar conosco!</h2>
<p>Seu pedido foi processado com sucesso.</p>
<a href="produtos.php" class="botao">Continuar comprando</a>

<?php include 'footer.php'; ?>