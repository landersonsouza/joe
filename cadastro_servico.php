<?php
session_start();
require 'config.php';

// Ativar exibição de erros (opcional, para depuração)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $quantidade = (int) $_POST['quantidade'];  // Certifique-se de que é um inteiro

    // Inserir novo serviço
    $stmt = $pdo->prepare("INSERT INTO servicos (nome, descricao, quantidade) VALUES (:nome, :descricao, :quantidade)");

    try {
        $stmt->execute(['nome' => $nome, 'descricao' => $descricao, 'quantidade' => $quantidade]);
        header("Location: servicos.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Novo Serviço</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        button:hover {
            background-color: #218838;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #007bff;
            text-decoration: none;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cadastrar Novo Serviço</h1>
        <form method="POST" action="cadastro_servico.php">
            <input type="text" name="nome" placeholder="Nome do Serviço" required>
            <textarea name="descricao" placeholder="Descrição do Serviço" required></textarea>
            <input type="number" name="quantidade" placeholder="Quantidade de Vagas" required>
            <button type="submit">Cadastrar Serviço</button>
        </form>
        <div class="back-link">
            <p><a href="servicos.php">Voltar</a></p>
        </div>
    </div>
</body>
</html>