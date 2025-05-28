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
<link rel="stylesheet" href="styles/pedidos.css">
<div class="pedidos-container">
  <h2>Meus Pedidos</h2>

  <?php if (empty($pedidos)): ?>
    <p class="sem-pedidos">Você ainda não realizou nenhum pedido.</p>
  <?php else: ?>
    <div class="lista-pedidos">
      <?php foreach ($pedidos as $pedido): ?>
        <div class="pedido-card">
          <div class="pedido-info">
            <h3>Pedido #<?= htmlspecialchars($pedido['A04_id']) ?></h3>
            <p><strong>Total:</strong> R$ <?= number_format($pedido['A04_total'], 2, ',', '.') ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($pedido['A04_status']) ?></p>
            <p><strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($pedido['A04_dataPedido'])) ?></p>
          </div>
          <div class="pedido-acoes">
            <a href="pedido_detalhes.php?id=<?= $pedido['A04_id'] ?>" class="botao-detalhes">Ver Detalhes</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
