<?php
$tituloPagina = "Ruralize";
require_once 'config.php';

// Busca os produtos em destaque no banco de dados
try {
    $stmt = $pdo->query("SELECT * FROM produtos LIMIT 3");
    $produtos = $stmt->fetchAll();
} catch (PDOException $e) {
    $_SESSION['erro'] = "Erro ao carregar produtos: " . $e->getMessage();
}

include 'header.php';
?>

<h2>Produtos em Destaque</h2>
<div class="produtos-container">
    <?php if (isset($produtos) && count($produtos) > 0): ?>
        <?php foreach ($produtos as $produto): ?>
            <div class="produto-card">
                <div class="produto-imagem">
                    <?php if (!empty($produto['imagem'])): ?>
                        <img src="img/<?= htmlspecialchars($produto['imagem']) ?>" 
                             alt="<?= htmlspecialchars($produto['nome']) ?>">
                    <?php else: ?>
                        <img src="images/sem-imagem.jpg" alt="Imagem não disponível">
                    <?php endif; ?>
                </div>
                
                <div class="produto-info">
                    <h3><?= htmlspecialchars($produto['nome']) ?></h3>
                    <p class="descricao"><?= htmlspecialchars($produto['descricao']) ?></p>
                    <p class="preco">
                        R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                    </p>
                    
                    <?php if (estaLogado()): ?>
                        <form class="form-adicionar" onsubmit="adicionarAoCarrinho(event, <?= $produto['id'] ?>)">
                            <label for="quantidade-<?= $produto['id'] ?>">Quantidade:</label>
                            <input type="number" id="quantidade-<?= $produto['id'] ?>" 
                                   name="quantidade" value="1" min="1" class="quantidade-input">
                            <button type="submit" class="botao-add">
                                <i class="fas fa-cart-plus"></i> Adicionar
                            </button>
                        </form>
                    <?php else: ?>
                        <div class="login-alerta">
                            <a href="login.php">Faça login</a> para comprar
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="sem-produtos">
            Nenhum produto em destaque no momento.
        </div>
    <?php endif; ?>
</div>

<!-- Toast para mensagens -->
<div id="toast" class="toast"></div>

<script>
// Função para adicionar ao carrinho via AJAX
function adicionarAoCarrinho(event, produtoId) {
    event.preventDefault(); // Impede o envio tradicional do formulário

    const quantidade = document.getElementById(`quantidade-${produtoId}`).value;

    fetch('adicionar_carrinho.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `produto_id=${produtoId}&quantidade=${quantidade}`,
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro na resposta do servidor');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            mostrarToast(data.message);
        } else {
            mostrarToast(data.message, 'erro');
        }
    })
    .catch(error => {
        mostrarToast('Adicionado ao carrinho.');
    });
}

// Função para exibir mensagens toast
function mostrarToast(mensagem, tipo = 'sucesso') {
    const toast = document.getElementById('toast');
    toast.textContent = mensagem;
    toast.className = `toast ${tipo}`;
    toast.style.display = 'block';

    setTimeout(() => {
        toast.style.display = 'none';
    }, 3000);
}
</script>

<?php include 'footer.php'; ?>