<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/header.css?v=3">
</head>
<body>
    <header>
       <!--  <li><p>olá (<?= $_SESSION['usuario_nome'] ?>)</p></li> -->
        <nav>
            <ul>
                <img class="logo" src="img/logoRuralizeok.png " alt="">
                <div class="separaLogo">
                <div class="separacaoLayoutHeader">
                    <li><a href="index.php">Página inicial</a></li>
                    <li><a href="produtos.php">Produtos</a></li>
                    <li><a href="#">Sobre nós</a></li>
                </div>
                
                <?php if (estaLogado()): ?>
                    <div class="separacaoLayoutHeader">
                        <li><a href="carrinho.php" title="Acessar Carrinho"><img src="img/carrinho.png" alt="entrar no carrinho de compras"></a></li>
                        <li><a href="pedidos.php" title="Meu perfil"><img src="img/profile.png" alt=""></a></li>
                        <li><a href="logout.php" title="Sair"><img src="img/logout.png" alt="sair da sua conta"></a></li>
                    </div>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
                </div>
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