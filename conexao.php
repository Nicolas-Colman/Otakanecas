<?php // conexao.php
try {
    $conn = new PDO("sqlite:banco.db");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("CREATE TABLE IF NOT EXISTS produtos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nome TEXT,
        descricao TEXT,
        imagem TEXT,
        preco REAL,
        disponibilidade INTEGER
    )");
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>