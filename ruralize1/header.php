<<<<<<< HEAD
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $tituloPagina ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1><?= $tituloPagina ?></h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="produtos.php">Produtos</a></li>
                
                <?php if (estaLogado()): ?>
                    <li><a href="carrinho.php">Carrinho</a></li>
                    <li><a href="logout.php">Logout (<?= $_SESSION['usuario_nome'] ?>)</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="registro.php">Registrar</a></li>
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
=======
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $tituloPagina ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="produtos.php">Produtos</a></li>
                
                <?php if (estaLogado()): ?>
                    <li><a href="carrinho.php">Carrinho</a></li>
                    <li><a href="pedidos.php">Pedidos</a></li>
                    <li><a href="logout.php">Logout (<?= $_SESSION['usuario_nome'] ?>)</a></li>
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
>>>>>>> 94153a8f956e56540b905670b510c9ef2536f246
        <?php endif; ?>