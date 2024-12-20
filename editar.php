<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Verifica se o ID do usuário está setado
if (!isset($_GET['id'])) {
    header("Location: efetivo.php");
    exit();
}

$id = $_GET['id'];

// Busca o usuário a ser editado
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
$stmt->execute(['id' => $id]);
$usuario = $stmt->fetch();

if (!$usuario) {
    header("Location: efetivo.php");
    exit();
}

// Processa o formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = !empty($_POST['senha']) ? password_hash($_POST['senha'], PASSWORD_DEFAULT) : null;

    // Atualiza os dados do usuário
    $stmt = $pdo->prepare("UPDATE usuarios SET nome = :nome, email = :email" . ($senha ? ", senha = :senha" : "") . " WHERE id = :id");
    $params = ['nome' => $nome, 'email' => $email, 'id' => $id];
    if ($senha) {
        $params['senha'] = $senha;
    }
    $stmt->execute($params);

    header("Location: efetivo.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 400px;
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
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .btn {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        .btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Usuário</h1>
        <form method="POST">
            <input type="text" name="nome" placeholder="Nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
            <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
            <input type="password" name="senha" placeholder="Nova Senha (deixe em branco para não alterar)">
            <button type="submit">Salvar</button>
        </form>
        <a href="efetivo.php" class="btn">Voltar</a>
    </div>
</body>
</html>