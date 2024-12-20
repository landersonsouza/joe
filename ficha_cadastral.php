<?php
session_start();
require 'config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Obtém o ID do usuário logado
$userId = $_SESSION['user_id'];

// Busca os dados do usuário
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
$stmt->execute(['id' => $userId]);
$usuario = $stmt->fetch();

if (!$usuario) {
    echo "Usuário não encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha Cadastral</title>
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
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .info {
            margin-bottom: 15px;
        }
        .btn {
            display: inline-block;
            margin: 20px 0;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ficha Cadastral</h1>
        <div class="info"><strong>ID:</strong> <?= htmlspecialchars($usuario['id']) ?></div>
        <div class="info"><strong>Nome:</strong> <?= htmlspecialchars($usuario['nome']) ?></div>
        <div class="info"><strong>Email:</strong> <?= htmlspecialchars($usuario['email']) ?></div>
        <div class="info"><strong>Data de Cadastro:</strong> <?= htmlspecialchars($usuario['data_cadastro']) ?></div>
        <!-- Adicione mais campos conforme necessário -->

        <div style="text-align: center;">
            <a href="painel.php" class="btn">Voltar ao Painel</a>
        </div>
    </div>
</body>
</html>