<?php
session_start();
require_once 'config.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produtoId = intval($_POST['produto_id']);
    $quantidade = intval($_POST['quantidade']);

    try {
        $stmt = $pdo->prepare("SELECT * FROM a01_produto WHERE A01_id = ?");
        $stmt->execute([$produtoId]);
        $produto = $stmt->fetch();

        if ($produto) {
            if (!isset($_SESSION['carrinho'])) {
                $_SESSION['carrinho'] = [];
            }

            if (isset($_SESSION['carrinho'][$produtoId])) {
                $_SESSION['carrinho'][$produtoId]['quantidade'] += $quantidade;
            } else {
                $_SESSION['carrinho'][$produtoId] = [
                    'id' => $produtoId,
                    'nome' => $produto['A01_nome'],
                    'preco' => $produto['A01_preco'],
                    'quantidade' => $quantidade,
                    'imagem' => $produto['A01_imagem_url']
                ];
            }

            $response['success'] = true;
            $response['message'] = "Produto adicionado ao carrinho!";
        } else {
            $response['message'] = "Produto não encontrado.";
        }
    } catch (PDOException $e) {
        $response['message'] = "Erro ao adicionar produto: " . $e->getMessage();
    }
} else {
    $response['message'] = "Método de requisição inválido.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit;
?>