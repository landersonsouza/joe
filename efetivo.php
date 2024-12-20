<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Processa a pesquisa
$search = '';
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

// Busca todos os usuários cadastrados com opção de pesquisa
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE nome LIKE :search ORDER BY id");
$stmt->execute(['search' => '%' . $search . '%']);
$usuarios = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários Cadastrados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
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
        .logout-link {
            text-align: center;
            margin-top: 20px;
        }
        .search-container {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Usuários Cadastrados</h1>
        
        <a href="cadastro.php" class="btn">Cadastrar Novo Usuário</a>
        
        <div class="search-container">
            <form method="POST">
                <input type="text" name="search" placeholder="Pesquisar por nome" value="<?= htmlspecialchars($search) ?>" required>
                <button type="submit" class="btn">Pesquisar</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($usuarios)): ?>
                    <tr>
                        <td colspan="4">Nenhum usuário cadastrado.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= htmlspecialchars($usuario['id']) ?></td>
                            <td><?= htmlspecialchars($usuario['nome']) ?></td>
                            <td><?= htmlspecialchars($usuario['email']) ?></td>
                            <td>
                                <a href="editar.php?id=<?= htmlspecialchars($usuario['id']) ?>" class="btn">Editar</a>
                                <a href="deletar.php?id=<?= htmlspecialchars($usuario['id']) ?>" class="btn" onclick="return confirm('Tem certeza que deseja deletar este usuário?');">Deletar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="logout-link">
            <p><a href="logout.php">Sair</a></p>
        </div>
    </div>
</body>
</html>