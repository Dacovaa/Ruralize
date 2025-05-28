<?php
require_once 'config.php';

if (!estaLogado()) {
    $_SESSION['erro'] = "Faça login para finalizar a compra!";
    header("Location: login.php");
    exit;
}

$total = 0;
foreach ($_SESSION['carrinho'] as $item) {
    $total += $item['preco'] * $item['quantidade'];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = getPdo();
    
    try {
        $pdo->beginTransaction();

        // Inserir pedido
        $stmt = $pdo->prepare("INSERT INTO a04_pedido (A03_Usuario_A03_id, A04_total, A04_status ,A04_dataPedido, A04_cep, A04_endereco, A04_bairro,A04_cidade, A04_estado, A04_numero) 
            VALUES (?, ?, 'pendente',NOW(),?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_SESSION['usuario_id'],
            $total,
            $_POST['cep'],
            $_POST['endereco'],
            $_POST['bairro'],
            $_POST['cidade'],
            $_POST['estado'],
            $_POST['numero']
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
        header("Location: pedidos.php");
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
<link rel="stylesheet" href="styles/checkout_confirmado.css">
<link rel="stylesheet" href="styles/styles.css">
<main>
<a href="checkout.php" class="botao-voltar">←</a>

<section class="checkout-form">
      <form action="checkout_confirmado.php" method="POST">
        <h3>Dados de Entrega</h3>

        <div class="form-group">
          <input type="text" name="cep" id="cep" placeholder="CEP" required>
            <input type="text" name="endereco" id="endereco" placeholder="Endereço" required>
            <input type="text" name="bairro" id="bairro" placeholder="Bairro" required>
            <input type="text" name="cidade" id="cidade" placeholder="Cidade" required>
            <input type="text" name="estado" id="estado" placeholder="Estado" required>
            <input type="text" name="numero" id="numero" placeholder="Numero" required>
        </div>

        <div class="form-buttons">
          <a href="carrinho.php" class="btn btn-back">Voltar ao Carrinho</a>
          <button type="submit" class="btn btn-confirm">Confirmar Pedido</button>
        </div>
      </form>
    </section>
  </div>
</div>
</main>

<script>
document.getElementById('cep').addEventListener('blur', function() {
    var cep = this.value.replace(/\D/g, '');
    if (cep.length === 8) {
        fetch('https://viacep.com.br/ws/' + cep + '/json/')
        .then(response => response.json())
        .then(data => {
            if (!data.erro) {
                document.getElementById('endereco').value = data.logradouro;
                document.getElementById('bairro').value = data.bairro;
                document.getElementById('cidade').value = data.localidade;
                document.getElementById('estado').value = data.uf;
            } else {
                alert('CEP não encontrado.');
            }
        })
        .catch(error => console.error('Erro ao buscar CEP:', error));
    }
});

</script>