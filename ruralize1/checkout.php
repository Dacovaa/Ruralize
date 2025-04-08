<<<<<<< HEAD
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

=======
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


// Processar checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = getPdo();
    
    try {
        $pdo->beginTransaction();

        // Inserir pedido
        $stmt = $pdo->prepare("INSERT INTO a04_pedido (A03_Usuario_A03_id, A04_total, A04_status ,A04_dataPedido) 
            VALUES (?, ?, 'pendente',NOW())");
        $stmt->execute([
            $_SESSION['usuario_id'],
            $total
        ]);
        $pedidoId = $pdo->lastInsertId();

        // Inserir itens do pedido
        foreach ($_SESSION['carrinho'] as $produtoId => $item) {
            $subTotal = $item['quantidade'] * $item['preco'];
            
            $stmt = $pdo->prepare("INSERT INTO a05_item_pedido 
                ( A01_Produto_A01_id, A04_Pedido_A04_id, A05_quantidade, A05_precoUnitario, A05_subTotal) 
                VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $produtoId,
                $pedidoId,
                $item['quantidade'],
                $item['preco'],
                $subTotal
            ]);
        }

        $pdo->commit();
        
        // Limpar carrinho e redirecionar
        unset($_SESSION['carrinho']);
        $_SESSION['mensagem'] = "Pedido #$pedidoId realizado com sucesso!";
        header("Location: confirmacao.php");
        exit;

    } catch (PDOException $e) {
        $pdo->rollBack();
        $_SESSION['erro'] = "Erro no pedido: " . $e->getMessage();
        header("Location: checkout.php");
        exit;
    }
}


include 'header.php';
?>

<div class="checkout-container">
    <h2>Finalizar Compra</h2>
    
    <div class="resumo-pedido">
        <h3>Resumo do Pedido</h3>
        <ul>
            <?php foreach ($_SESSION['carrinho'] as $item): ?>
                <li>
                    <?= htmlspecialchars($item['nome']) ?> -
                    <?= $item['quantidade'] ?> x R$ <?= number_format($item['preco'], 2, ',', '.') ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <p class="total">Total: R$ <?= number_format($total, 2, ',', '.') ?></p>
    </div>

    <form action="checkout.php" method="POST">
        <div class="form-group">
            <h3>Dados de Entrega</h3>
            
            <input type="text" name="endereco" placeholder="Endereço de entrega" required>
        </div>

        <div class="botoes">
            <a href="carrinho.php" class="botao-voltar">Voltar ao Carrinho</a>
            <button type="submit" class="botao-confirmar">Confirmar Pedido</button>
        </div>
    </form>
</div>

>>>>>>> 94153a8f956e56540b905670b510c9ef2536f246
<?php include 'footer.php'; ?>