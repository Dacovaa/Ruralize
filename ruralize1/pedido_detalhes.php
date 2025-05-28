<?php
$tituloPagina = "Detalhes do Pedido";
require_once 'config.php';

if (!estaLogado()) {
    $_SESSION['erro'] = "Faça login para visualizar os detalhes do pedido!";
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['erro'] = "Pedido inválido!";
    header("Location: pedidos.php");
    exit;
}

$pedidoId = $_GET['id'];
$pdo = getPdo();

// Buscar informações do pedido
$stmt = $pdo->prepare("SELECT * FROM a04_pedido WHERE A04_id = ? AND A03_Usuario_A03_id = ?");
$stmt->execute([$pedidoId, $_SESSION['usuario_id']]);
$pedido = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pedido) {
    $_SESSION['erro'] = "Pedido não encontrado!";
    header("Location: pedidos.php");
    exit;
}

// Buscar itens do pedido
try {
    $pdo = getPdo();
    
    $stmt = $pdo->prepare("SELECT p.A01_nome, i.A05_quantidade, i.A05_precoUnitario, i.A05_subTotal
                          FROM a05_item_pedido i
                          JOIN a01_produto p ON i.A01_Produto_A01_id = p.A01_id
                          WHERE i.A04_Pedido_A04_id = ?");
    $stmt->execute([$pedidoId]);
    $itens = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    die("Erro ao buscar itens do pedido: " . $e->getMessage());
}
include 'header.php';
?>
<link rel="stylesheet" href="styles/pedido_detalhes.css">
<div class="pedido-detalhes-container">
    <h2>Pedido #<?= htmlspecialchars($pedido['A04_id']) ?></h2>

    <div class="pedido-info">
        <p><strong>Status:</strong> <?= htmlspecialchars($pedido['A04_status']) ?></p>
        <p><strong>Data do Pedido:</strong> <?= date('d/m/Y H:i', strtotime($pedido['A04_dataPedido'])) ?></p>
        <p><strong>Total:</strong> R$ <?= number_format($pedido['A04_total'], 2, ',', '.') ?></p>
    </div>

    <div class="endereco-entrega">
        <h3>Endereço de Entrega</h3>
        <p>
            <?= htmlspecialchars($pedido['A04_endereco']) ?>, 
            Nº <?= htmlspecialchars($pedido['A04_numero']) ?> <br>
            <?= htmlspecialchars($pedido['A04_bairro']) ?> - 
            <?= htmlspecialchars($pedido['A04_cidade']) ?>/<?= htmlspecialchars($pedido['A04_estado']) ?> <br>
            CEP: <?= htmlspecialchars($pedido['A04_cep']) ?>
        </p>
    </div>

    <div class="itens-pedido">
        <h3>Itens do Pedido</h3>
        <ul>
            <?php foreach ($itens as $item): ?>
                <li>
                    <?= htmlspecialchars($item['A01_nome']) ?> -
                    <?= $item['A05_quantidade'] ?> x R$ <?= number_format($item['A05_precoUnitario'], 2, ',', '.') ?>
                    <br><span class="subtotal">(Subtotal: R$ <?= number_format($item['A05_subTotal'], 2, ',', '.') ?>)</span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <a href="pedidos.php" class="botao voltar">← Voltar para Meus Pedidos</a>
</div>

