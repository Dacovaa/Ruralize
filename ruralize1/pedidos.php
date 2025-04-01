<?php
$tituloPagina = "Meus Pedidos";
require_once 'config.php';

if (!estaLogado()) {
    $_SESSION['erro'] = "Faça login para visualizar seus pedidos!";
    header("Location: login.php");
    exit;
}

$pdo = getPdo();
$stmt = $pdo->prepare("SELECT * FROM a04_pedido WHERE A03_Usuario_A03_id = ? ORDER BY A04_dataPedido DESC");
$stmt->execute([$_SESSION['usuario_id']]);
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'header.php';
?>

<div class="pedidos-container">
    <h2>Meus Pedidos</h2>
    
    <?php if (empty($pedidos)): ?>
        <p>Você ainda não realizou nenhum pedido.</p>
    <?php else: ?>
        <ul class="lista-pedidos">
            <?php foreach ($pedidos as $pedido): ?>
                <li>
                    <strong>Pedido #<?= htmlspecialchars($pedido['A04_id']) ?></strong> -
                    Total: R$ <?= number_format($pedido['A04_total'], 2, ',', '.') ?> -
                    Status: <?= htmlspecialchars($pedido['A04_status']) ?> -
                    Data: <?= date('d/m/Y H:i', strtotime($pedido['A04_dataPedido'])) ?>
                    <a href="pedido_detalhes.php?id=<?= $pedido['A04_id'] ?>" class="botao">Ver Detalhes</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
