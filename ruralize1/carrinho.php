<?php

$tituloPagina = "Carrinho de Compras";
require_once 'config.php';

// Verificar autenticação
if (!estaLogado()) {
    $_SESSION['erro'] = "Faça login para acessar o carrinho!";
    header("Location: login.php");
    exit;
}

// Processar ações
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Atualizar quantidade de itens no carrinho
    if (isset($_POST['atualizar'])) {
        foreach ($_POST['quantidade'] as $produtoId => $quantidade) {
            if (isset($_SESSION['carrinho'][$produtoId])) {
                if ($quantidade > 0) {
                    $_SESSION['carrinho'][$produtoId]['quantidade'] = $quantidade;
                } else {
                    unset($_SESSION['carrinho'][$produtoId]);
                }
            }
        }
        $_SESSION['mensagem'] = "Carrinho atualizado!";
        header("Location: carrinho.php");
        exit;
    }

    // Remover item do carrinho
    if (isset($_POST['remover'])) {
        $produtoId = intval($_POST['remover']);
        if (isset($_SESSION['carrinho'][$produtoId])) {
            unset($_SESSION['carrinho'][$produtoId]);
            $_SESSION['mensagem'] = "Produto removido do carrinho!";
        }
        header("Location: carrinho.php");
        exit;
    }
}

include 'header.php';
?>

<div class="carrinho-container">
    <h2>Seu Carrinho</h2>
    
    <?php if (!empty($_SESSION['carrinho'])): ?>
        <form action="carrinho.php" method="POST">
            <div class="itens-carrinho">
                <?php 
                $total = 0;
                foreach ($_SESSION['carrinho'] as $produtoId => $item): 
                    $subtotal = $item['preco'] * $item['quantidade'];
                    $total += $subtotal;
                ?>
                    <div class="item-carrinho">
                        <div class="item-imagem">
                            <img src="img/<?= htmlspecialchars($item['imagem']) ?>" 
                                 alt="<?= htmlspecialchars($item['nome']) ?>">
                        </div>
                        
                        <div class="item-info">
                            <h3><?= htmlspecialchars($item['nome']) ?></h3>
                            <p class="preco-unitario">
                                R$ <?= number_format($item['preco'], 2, ',', '.') ?> cada
                            </p>
                            
                            <div class="quantidade-controle">
                                <label for="quantidade-<?= $produtoId ?>">Quantidade:</label>
                                <input type="number" name="quantidade[<?= $produtoId ?>]" 
                                       value="<?= $item['quantidade'] ?>" min="1" class="quantidade-input">
                            </div>
                            
                            <p class="subtotal">
                                Subtotal: R$ <?= number_format($subtotal, 2, ',', '.') ?>
                            </p>
                            
                            <button type="submit" name="remover" value="<?= $produtoId ?>" 
                                    class="botao-remover">
                                Remover
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="resumo-carrinho">
    <h3>Total do Pedido</h3>
    <p class="total">R$ <?= number_format($total, 2, ',', '.') ?></p>
    
    <div class="botoes-carrinho">
        <button type="submit" name="atualizar" class="botao-atualizar">Atualizar Carrinho</button>
        <a href="checkout.php" class="botao-checkout">Finalizar Compra</a>
    </div>
</div>
        </form>
    <?php else: ?>
        <div class="carrinho-vazio">
            <i class="fas fa-shopping-cart"></i>
            <p>Seu carrinho está vazio</p>
            <a href="produtos.php" class="botao">Continuar Comprando</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>