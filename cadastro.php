<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $is_admin = isset($_POST['is_admin']) ? 1 : 0; // Verifica se é admin

    // Verifica se o email já existe
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $usuarioExistente = $stmt->fetch();

    if ($usuarioExistente) {
        $erro = "Email já cadastrado. Tente outro.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, is_admin) VALUES (:nome, :email, :senha, :is_admin)");
        $stmt->execute(['nome' => $nome, 'email' => $email, 'senha' => $senha, 'is_admin' => $is_admin]);
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
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
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        label {
            display: block;
            margin: 10px 0;
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
        .error {
            color: red;
            text-align: center;
        }
        .login-link {
            text-align: center;
            margin-top: 15px;
        }
        .login-link a {
            color: #007bff;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cadastro</h1>
        <form method="POST">
            <input type="text" name="nome" placeholder="Nome" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <label>
                <input type="checkbox" name="is_admin"> Administrador
            </label>
            <button type="submit">Cadastrar</button>
        </form>
        <?php if (isset($erro)): ?>
            <p class="error"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>
        
        </div>
    </div>
    <a href="painel.php" class="btn" style="display: block; text-align: center; margin-top: 15px; color: #007bff; text-decoration: none; padding: 10px; border: 1px solid #007bff; border-radius: 5px; width: 100px; margin-left: auto; margin-right: auto;">Voltar</a>
</body>
</html>