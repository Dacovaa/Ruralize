<?php
$tituloPagina = "Ruralize";
require_once 'config.php';

include 'header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $stmt = $pdo->prepare("SELECT * FROM A01_produto WHERE A01_id = ?");
        $stmt->execute([$id]);
        $produto = $stmt->fetch();

        if (!$produto) {
            echo "Produto não encontrado.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Erro ao carregar produto: " . $e->getMessage();
        exit;
    }
} else {
    echo "ID do produto não informado.";
    exit;
}

try {
    $stmt = $pdo->query("SELECT * FROM a01_produto LIMIT 4");
    $produtos = $stmt->fetchAll();
} catch (PDOException $e) {
    $_SESSION['erro'] = "Erro ao carregar produtos: " . $e->getMessage();
}



$idAtual = $_GET['id'] ?? null;

// vamo filtrar p aparecer só os outros e usar no interessados
$produtosFiltrados = array_filter($produtos, function($p) use ($idAtual) {
    return $p['A01_id'] != $idAtual;
});


?>

<link rel="stylesheet" href="styles/nav.css">
<link rel="stylesheet" href="styles/comprar.css">

<a href="index.php" class="botao-voltar">←</a>
<div class="container-interesse">
    <p class="interesse">Você também pode estar interessado: </p>
    <div>
       <?php foreach (array_slice($produtosFiltrados, 0, 3) as $relacionado): ?>
    <a class="comprar-interesse" href="comprar.php?id=<?= urlencode($relacionado['A01_id']) ?>">
        <?= htmlspecialchars($relacionado['A01_nome']) ?> - 
    </a>
<?php endforeach; ?>
    </div>
</div>
<section class="section-comprar">
    <div class="comprar-imagem">
       <?php if (!empty($produto['A01_imagem_url'])): ?>
                        <img src="img/<?= htmlspecialchars($produto['A01_imagem_url']) ?>" 
                             alt="<?= htmlspecialchars($produto['A01_nome']) ?>">
                    <?php else: ?>
                        <img src="images/sem-imagem.jpg" alt="Imagem não disponível">
                    <?php endif; ?>
    </div>
    <div class="comprar-descricao">
        <h1 class="comprar-titulo"><?= htmlspecialchars($produto['A01_nome']) ?></h1>
        <div class="comprar-infos">
            <p class="comprar-paragrafo" ><?= nl2br(htmlspecialchars($produto['A01_descricao'])) ?></p>
            <p class="comprar-preco">R$ <?= number_format($produto['A01_preco'], 2, ',', '.') ?> <strong class="comprar-off">5% off</strong> </p>
        </div>

        <form class="form-adicionar" onsubmit="adicionarAoCarrinho(event, <?= $produto['A01_id'] ?>)">
            <div>
                <label for="quantidade-<?= $produto['A01_id'] ?>">Quantidade:</label>
                <input type="number" id="quantidade-<?= $produto['A01_id'] ?>" name="quantidade" value="1" min="1"
                    class="quantidade-input">
            </div>
            <button class="btn-adicionar" type="submit" class="botao-add">
                <i class="fas fa-cart-plus"></i> Adicionar ao carrinho
            </button>
        </form>
</div>

<div id="toast" class="toast"></div>
</section>

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
            mostrarToast(`
        Adicionado ao carrinho. 
        <a href="carrinho.php" style="
            display: inline-block;
            margin-left: 10px;
            padding: 5px 10px;
            background-color: #ffffff33;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        ">
            Ver Carrinho
        </a>
    `);
    });
}

function mostrarToast(mensagem, tipo = 'sucesso') {
    const toast = document.getElementById('toast');
    toast.textContent = mensagem;
    toast.innerHTML = mensagem;
    toast.className = `toast ${tipo}`;
    toast.style.display = 'block';

    setTimeout(() => {
        toast.style.display = 'none';
    }, 3000);
}
</script>
