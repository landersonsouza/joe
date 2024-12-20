<?php
session_start();
require 'config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        h1 {
            text-align: center;
            color: #5c2d91; /* Cor roxa do Nubank */
            font-weight: 700;
        }
        .options {
            text-align: center;
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .btn {
            display: inline-block;
            padding: 15px 25px;
            background-color: #5c2d91; /* Cor roxa do Nubank */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 500;
            transition: background-color 0.3s, transform 0.2s;
        }
        .btn:hover {
            background-color: #4b2273; /* Tom mais escuro */
            transform: translateY(-2px);
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bem-vindo!</h1>
        <div class="options">
            <a href="servicos.php" class="btn">Ir para Serviços</a>
            <a href="efetivo.php" class="btn">Ir para Efetivo</a>
            <a href="ficha_cadastral.php" class="btn">Ficha Cadastral</a>
        </div>
        <div class="footer">
            <p>&copy; <?= date('Y') ?> Seu Nome ou Nome da Empresa</p>
        </div>
    </div>
</body>
</html>