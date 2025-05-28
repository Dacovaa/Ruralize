<?php
$tituloPagina = "Ruralize";
require_once 'config.php';

// Busca os produtos
try {
    $stmt = $pdo->query("SELECT * FROM a01_produto LIMIT 4");
    $produtos = $stmt->fetchAll();
} catch (PDOException $e) {
    $_SESSION['erro'] = "Erro ao carregar produtos: " . $e->getMessage();
}

// Busca as categorias

try {
    $stmt = $pdo->query("SELECT * FROM a02_categoria LIMIT 5");
    $categorias = $stmt->fetchAll();
} catch (PDOException $e) {
    $_SESSION['erro'] = "Erro ao carregar categorias: " . $e->getMessage();
}

include 'header.php';
?>
<link rel="stylesheet" href="styles/nav.css">
<img class="banner" src="img/Banner Ruralize.svg" alt="">
<section class="categorias-produtos">
    <div class="categoria-container">
        <?php if (isset($categorias) && count($categorias) > 0): ?>
            <?php foreach ($categorias as $categoria): ?>
            <!-- faz com que enviemos o id da categoria para a url, assim filtrando no produtos.php -->
                <a class="categoria-link" href="produtos.php?categoria=<?= urlencode($categoria['A02_id']) ?>">
                    <?= htmlspecialchars($categoria['A02_nome']) ?>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="sem-produtos">
                Nenhuma categoria no momento.
            </div>
        <?php endif; ?>
    </div>
</section>
<section class="conteudo">
<h2>Produtos em Destaque</h2>
<div class="produtos-container">
    <?php if (isset($produtos) && count($produtos) > 0): ?>
        <?php foreach ($produtos as $produto): ?>
            <div class="produto-card">
                <div class="produto-imagem">
                    <?php if (!empty($produto['A01_imagem_url'])): ?>
                        <img src="img/<?= htmlspecialchars($produto['A01_imagem_url']) ?>" 
                             alt="<?= htmlspecialchars($produto['A01_nome']) ?>">
                    <?php else: ?>
                        <img src="images/sem-imagem.jpg" alt="Imagem não disponível">
                    <?php endif; ?>
                </div>
                
                <div class="produto-info">
                    <h3><?= htmlspecialchars($produto['A01_nome']) ?></h3>
                    <p class="descricao"><?= htmlspecialchars($produto['A01_descricao']) ?></p>
                    <p class="preco">
                        R$ <?= number_format($produto['A01_preco'], 2, ',', '.') ?>
                    </p>
                    
                    <?php if (estaLogado()): ?>
                        <a href="comprar.php?id=<?= $produto['A01_id'] ?>" class="btn-comprar">Comprar</a>
                    <?php else: ?>
                        <div class="login-alerta">
                            <a href="login.php">Faça login para comprar</a>
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
</section class="conteudo">

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