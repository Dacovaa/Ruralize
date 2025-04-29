<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/header.css?v=3">
</head>
<body>
    <header>
        <nav>
            <ul>
                <img class="logo" src="img/logoRuralizeok.png " alt="">
                <div class="separacaoLayoutHeader">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="produtos.php">Produtos</a></li>
                    <li><a href="#">teste</a></li>
                </div>
                
                <?php if (estaLogado()): ?>
                    <div class="separacaoLayoutHeader">
                        <li><a href="carrinho.php">Carrinho</a></li>
                        <li><a href="pedidos.php">Pedidos</a></li>
                        <li><a href="logout.php">Logout (<?= $_SESSION['usuario_nome'] ?>)</a></li>
                    </div>
                    <li><a href="#"><img src="img/Shopping bag.ong" alt=""></a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <?php if (isset($_SESSION['mensagem'])): ?>
            <div class="mensagem"><?= $_SESSION['mensagem'] ?></div>
            <?php unset($_SESSION['mensagem']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['erro'])): ?>
            <div class="erro"><?= $_SESSION['erro'] ?></div>
            <?php unset($_SESSION['erro']); ?>
        <?php endif; ?>