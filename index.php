<?php include 'conexao.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Otakanecas - Catálogo</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #0f0f0f;
            color: #e0e0e0;
        }
        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url('imagens/fundo.png') no-repeat center center/cover;
            filter: blur(18px);
            z-index: -1;
            opacity: 0.6;
        }
        header {
            background: #1a1a1a;
            padding: 20px;
            text-align: center;
            color: #0ff;
            font-size: 2em;
            text-shadow: 0 0 10px #0ff;
        }
        /* Menu */
        nav {
            background: #121212;
            padding: 10px 0;
            text-align: center;
            box-shadow: 0 0 10px #0ff5;
            margin-bottom: 20px;
        }
        nav a {
            color: #0ff;
            text-decoration: none;
            font-weight: 600;
            margin: 0 20px;
            font-size: 1.1em;
            padding: 6px 12px;
            border-radius: 6px;
            transition: background-color 0.3s, box-shadow 0.3s;
            display: inline-block;
        }
        nav a:hover {
            background-color: #0ff;
            color: #000;
            box-shadow: 0 0 15px #0ff;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
        }
        .produto {
            background: #1a1a1a;
            border: 1px solid #333;
            border-radius: 12px;
            box-shadow: 0 0 15px #0ff3;
            margin: 15px;
            padding: 15px;
            width: 220px;
            text-align: center;
            transition: transform 0.3s;
        }
        .produto:hover {
            transform: scale(1.05);
            box-shadow: 0 0 25px #0ff6;
        }
        .produto img {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        .produto h3 {
            margin: 10px 0 5px;
            color: #0ff;
        }
        .produto p {
            font-size: 0.9em;
        }
        .btn {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            background: #0ff;
            color: #000;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            box-shadow: 0 0 10px #0ff;
        }
        .btn:hover {
            background: #0cc;
        }
    </style>
</head>
<body>
<header>Otakaneca - Catálogo de Canecas</header>

<nav>
    <a href="index.php">Catálogo</a>
    <a href="nos.php">Quem Somos</a>
    <a href="personalize.php">Personalize</a>
</nav>

<div class="container">
    <?php
    $produtos = $conn->query("SELECT * FROM produtos");
    foreach ($produtos as $produto): ?>
        <div class="produto">
            <img src="imagens/<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
            <h3><?= htmlspecialchars($produto['nome']) ?></h3>
            <p><?= htmlspecialchars($produto['descricao']) ?></p>
            <p>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
            <p><?= $produto['disponibilidade'] ? "Disponível" : "Indisponível" ?></p>
            <?php if ($produto['disponibilidade']): ?>
                <a class="btn" href="https://wa.me/5553991010003?text=Ol%C3%A1%2C+tenho+interesse+na+caneca+<?= urlencode($produto['nome']) ?>" target="_blank">Comprar</a>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
