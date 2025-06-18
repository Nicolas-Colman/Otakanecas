<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Otakaneca - Quem Somos</title>
    <style>
        body {
            position: relative;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #0f0f0f;
            color: #e0e0e0;
            overflow-x: hidden;
            z-index: 0;
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
        main {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background: #1a1a1acc; /* leve transparência para destacar do fundo */
            border-radius: 12px;
            box-shadow: 0 0 20px #0ff3;
        }
        h1, h2 {
            color: #0ff;
            text-shadow: 0 0 10px #0ff;
        }
        p {
            font-size: 1.1em;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        a {
            color: #0ff;
            text-decoration: none;
            border-bottom: 1px solid transparent;
            transition: border-color 0.3s;
        }
        a:hover {
            border-color: #0ff;
        }
        .foto-equipe {
            margin: 30px auto;
            max-width: 400px;
            border-radius: 15px;
            box-shadow: 0 0 20px #0ff6;
            overflow: hidden;
        }
        .foto-equipe img {
            width: 100%;
            display: block;
            border-radius: 15px;
        }
        footer {
            text-align: center;
            margin-top: 50px;
            padding: 20px;
            color: #0ff;
            font-size: 0.9em;
            text-shadow: 0 0 5px #0ff;
        }
    </style>
</head>
<body>
<header>Otakaneca</header>

<nav>
    <a href="index.php">Catálogo</a>
    <a href="nos.php">Quem Somos</a>
</nav>

<main>
    <h1>Quem Somos</h1>
    <p>
        A Otakaneca nasceu da paixão por canecas personalizadas e cultura nerd, com foco em oferecer produtos de alta qualidade que tragam alegria e estilo para o dia a dia dos nossos clientes.
    </p>
    <p>
        Nossa missão é entregar canecas exclusivas, feitas com carinho e atenção aos detalhes, para que cada fã possa expressar sua personalidade única.
    </p>
    <h2>Nossa equipe</h2>
    <p>
        Somos um time jovem e dedicado, apaixonado por design, tecnologia e cultura pop. Trabalhamos para criar produtos que conectam pessoas através de temas de animes, games e muito mais.
    </p>
    <div class="foto-equipe">
        <img src="imagens/titan.png" alt="Foto da equipe Otakaneca" />
    </div>
    <h2>Contato</h2>
    <p>
        Quer conversar? Mande uma mensagem pelo WhatsApp: 
        <a href="https://wa.me/5553991010003" target="_blank">(53)991010003</a>
    </p>
</main>

<footer>
    &copy; <?= date('Y') ?> Otakaneca. Todos os direitos reservados.
</footer>
</body>
</html>
