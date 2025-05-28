<?php
$tituloPagina = "Finalizar Compra";
require_once 'config.php';

if (!estaLogado()) {
    $_SESSION['erro'] = "Faça login para finalizar a compra!";
    header("Location: login.php");
    exit;
}

if (empty($_SESSION['carrinho'])) {
    $_SESSION['erro'] = "Seu carrinho está vazio!";
    header("Location: produtos.php");
    exit;
}

// Calcular total do carrinho
$total = 0;
foreach ($_SESSION['carrinho'] as $item) {
    $total += $item['preco'] * $item['quantidade'];
}



include 'header.php';
?>
<link rel="stylesheet" href="styles/checkout.css">

<a href="carrinho.php" class="botao-voltar">←</a>
<div class="checkout-container">
  <h2>Finalizar Compra</h2>

  <div class="checkout-content">
    <!-- Coluna da esquerda: resumo do pedido -->
    <div class="resumo-pedido">
        <div>
            <h3>Resumo do Pedido</h3>
            <ul>
                <?php foreach ($_SESSION['carrinho'] as $item): ?>
                <li>
                    <?= htmlspecialchars($item['nome']) ?> -
                    <?= $item['quantidade'] ?> x R$ <?= number_format($item['preco'], 2, ',', '.') ?>
                </li>
                <?php endforeach; ?>
            </ul>
      </div>
      <p class="total">Total: R$ <?= number_format($total, 2, ',', '.') ?></p>
    </div>
    <a href="checkout_confirmado.php" class="btn btn-confirm">Confirmar Pedido</a>