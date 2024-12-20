<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['servico_id'])) {
    header("Location: login.php");
    exit();
}

$servico_id = (int)$_POST['servico_id'];
$numero_voluntario = (int)$_POST['numero_voluntario'];
$usuario_id = $_SESSION['user_id'];

// Busca informações do serviço
$stmt = $pdo->prepare("SELECT * FROM servicos WHERE id = :id");
$stmt->execute(['id' => $servico_id]);
$servico = $stmt->fetch();

if (!$servico) {
    echo "Serviço não encontrado.";
    exit();
}

// Busca voluntários para o serviço
$stmt = $pdo->prepare("SELECT * FROM voluntarios WHERE servico_id = :servico_id");
$stmt->execute(['servico_id' => $servico_id]);
$voluntarios = $stmt->fetchAll();

if ($numero_voluntario < 1 || $numero_voluntario > count($voluntarios)) {
    echo "Número de voluntário inválido.";
    exit();
}

// Obtém o ID do voluntário selecionado
$voluntario_selecionado = $voluntarios[$numero_voluntario - 1];

// Verifica se o voluntário já está escalado
if ($voluntario_selecionado['estado'] === 'escalado') {
    echo "Este voluntário já está escalado.";
    exit();
}

// Atualiza o estado do voluntário para 'escalado'
$stmt = $pdo->prepare("UPDATE voluntarios SET estado = 'escalado' WHERE id = :voluntario_id");
$stmt->execute(['voluntario_id' => $voluntario_selecionado['id']]);

header("Location: voluntarios.php?servico_id=" . $servico_id);
exit();