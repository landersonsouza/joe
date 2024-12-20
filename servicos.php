<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['user_id'];

// Busca os serviços disponíveis
$stmt = $pdo->query("SELECT * FROM servicos");
$servicos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviços Disponíveis</title>
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
        p {
            text-align: center;
            color: #555;
        }
        .error {
            color: red;
            text-align: center;
        }
        .success {
            color: green;
            text-align: center;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            background: #e9ecef;
            margin: 10px 0;
            padding: 15px;
            border-radius: 5px;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            float: right;
        }
        button:hover {
            background-color: #218838;
        }
        .admin-section {
            margin-top: 20px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        .logout-link {
            text-align: center;
            margin-top: 20px;
        }
        .inscrito {
            color: green;
            font-weight: bold;
            margin-top: 10px;
        }
        .escalado {
            color: blue;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Serviços Disponíveis</h1>

        <!-- Mensagens de erro e sucesso -->
        <?php if (isset($_SESSION['erro'])): ?>
            <p class="error"><?= htmlspecialchars($_SESSION['erro']) ?></p>
            <?php unset($_SESSION['erro']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['success'])): ?>
            <p class="success"><?= htmlspecialchars($_SESSION['success']) ?></p>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <ul>
            <?php foreach ($servicos as $servico): ?>
                <?php
                // Verifica se o usuário já está inscrito neste serviço e qual é seu estado
                $stmt = $pdo->prepare("SELECT * FROM voluntarios WHERE usuario_id = :usuario_id AND servico_id = :servico_id");
                $stmt->execute(['usuario_id' => $usuario_id, 'servico_id' => $servico['id']]);
                $usuario_voluntario = $stmt->fetch();
                ?>
                <li>
                    <strong><a href="voluntarios.php?servico_id=<?= $servico['id'] ?>"><?= htmlspecialchars($servico['nome']) ?></a></strong>
                    <?= htmlspecialchars($servico['descricao']) ?>
                    <p>Vagas disponíveis: <?= htmlspecialchars($servico['quantidade']) ?></p>
                    
                    <?php if ($usuario_voluntario): ?>
                        <?php if ($usuario_voluntario['estado'] === 'escalado'): ?>
                            <p class="escalado">Você está escalado neste serviço.</p>
                            <button disabled>Escalado</button>
                        <?php else: ?>
                            <p class="inscrito">Você já está inscrito neste serviço.</p>
                            <button disabled>Inscrito</button>
                        <?php endif; ?>
                    <?php else: ?>
                        <form method="POST" action="inscrever.php">
                            <input type="hidden" name="servico_id" value="<?= $servico['id'] ?>">
                            <button type="submit">Inscrever-se</button>
                        </form>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <?php if ($_SESSION['is_admin']): ?>
            <div class="admin-section">
                <h2>Administração</h2>
                <p><a href="cadastro_servico.php">Cadastrar Novo Serviço</a></p>
                <p><a href="cadastro.php">Cadastrar Novo Usuário</a></p>
            </div>
        <?php else: ?>
            <p>Você não tem permissão para cadastrar usuários ou serviços.</p>
        <?php endif; ?>

        <div class="logout-link">
            <p><a href="logout.php">Sair</a></p>
        </div>
    </div>
</body>
</html>