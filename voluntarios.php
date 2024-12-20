<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['servico_id'])) {
    header("Location: login.php");
    exit();
}

$servico_id = (int)$_GET['servico_id'];

// Busca informações do serviço
$stmt = $pdo->prepare("SELECT * FROM servicos WHERE id = :id");
$stmt->execute(['id' => $servico_id]);
$servico = $stmt->fetch();

if (!$servico) {
    echo "Serviço não encontrado.";
    exit();
}

// Busca voluntários para o serviço (com nome, e-mail e estado)
$stmt = $pdo->prepare("SELECT v.*, u.nome AS usuario_nome, u.email AS usuario_email FROM voluntarios v
                        JOIN usuarios u ON v.usuario_id = u.id
                        WHERE v.servico_id = :servico_id");
$stmt->execute(['servico_id' => $servico_id]);
$voluntarios = $stmt->fetchAll();

// Busca voluntários confirmados para o serviço
$stmt = $pdo->prepare("SELECT c.*, u.nome AS usuario_nome, u.email AS usuario_email FROM confirmados c
                        JOIN usuarios u ON c.usuario_id = u.id
                        WHERE c.servico_id = :servico_id");
$stmt->execute(['servico_id' => $servico_id]);
$confirmados = $stmt->fetchAll();

// Verifica se o número de vagas disponíveis é igual ao número de confirmados
$vagas_disponiveis = $servico['quantidade'];
$num_confirmados = count($confirmados);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voluntários para <?= htmlspecialchars($servico['nome']) ?></title>
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
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            background: #e9ecef;
            margin: 10px 0;
            padding: 15px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .back-link, .pdf-link {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Voluntários para <?= htmlspecialchars($servico['nome']) ?></h1>
        <p><strong>Descrição:</strong> <?= htmlspecialchars($servico['descricao']) ?></p>
        <p><strong>Vagas Disponíveis:</strong> <?= htmlspecialchars($servico['quantidade']) ?></p>

        <h2>Voluntários Inscritos</h2>
        <ul>
            <?php if (empty($voluntarios)): ?>
                <li>Não há voluntários inscritos para este serviço.</li>
            <?php else: ?>
                <?php foreach ($voluntarios as $index => $voluntario): ?>
                    <li>
                        <span><?= htmlspecialchars($voluntario['usuario_nome']) ?> (<?= htmlspecialchars($voluntario['usuario_email']) ?>)</span>
                        <span>Número: <?= $index + 1 ?></span>
                        <?php if ($voluntario['estado'] === 'escalado'): ?>
                            <span>Escalado</span>
                        <?php else: ?>
                            <form method="POST" action="processar_inscricao.php" style="display:inline;">
                                <input type="hidden" name="servico_id" value="<?= $servico['id'] ?>">
                                <button type="submit">Inscrever</button>
                            </form>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>

        <h2>Confirmar Seleção de Voluntários</h2>
        <?php if ($vagas_disponiveis === $num_confirmados): ?>
            <p>Não há vagas disponíveis para confirmar mais voluntários.</p>
        <?php else: ?>
            <form method="POST" action="processar_confirmacao.php">
                <input type="hidden" name="servico_id" value="<?= $servico['id'] ?>">
                <div>
                    <label for="numero_voluntario">Selecione o número do voluntário:</label>
                    <input type="number" id="numero_voluntario" name="numero_voluntario" min="1" max="<?= count($voluntarios) ?>" required>
                </div>
                <button type="submit">Confirmar Seleção</button>
            </form>
        <?php endif; ?>

        <h2>Voluntários Confirmados</h2>
        <ul>
            <?php if (empty($confirmados)): ?>
                <li>Não há voluntários confirmados para este serviço.</li>
            <?php else: ?>
                <?php foreach ($confirmados as $confirmado): ?>
                    <li><?= htmlspecialchars($confirmado['usuario_nome']) ?> (<?= htmlspecialchars($confirmado['usuario_email']) ?>)</li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>

        <?php if ($vagas_disponiveis === $num_confirmados): ?>
            <div class="pdf-link">
                <a href="gerar_pdf.php?servico_id=<?= $servico_id ?>" target="_blank">Gerar PDF com as Informações do Serviço</a>
            </div>
        <?php endif; ?>

        <div class="back-link">
            <p><a href="servicos.php">Voltar</a></p>
        </div>
    </div>
</body>
</html>