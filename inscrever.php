<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['servico_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['user_id'];
$servico_id = (int)$_POST['servico_id'];

// Verifica se o usuário já está inscrito no serviço
$stmt = $pdo->prepare("SELECT COUNT(*) FROM voluntarios WHERE usuario_id = :usuario_id AND servico_id = :servico_id");
$stmt->execute(['usuario_id' => $usuario_id, 'servico_id' => $servico_id]);
$ja_inscrito = $stmt->fetchColumn();

if ($ja_inscrito) {
    // Se já estiver inscrito, redireciona com uma mensagem de erro
    $_SESSION['erro'] = "Você já está inscrito neste serviço.";
    header("Location: servicos.php");
    exit();
}

// Caso não esteja inscrito, inscreve o usuário
$stmt = $pdo->prepare("INSERT INTO voluntarios (usuario_id, servico_id) VALUES (:usuario_id, :servico_id)");
$stmt->execute(['usuario_id' => $usuario_id, 'servico_id' => $servico_id]);

// Mensagem de sucesso
$_SESSION['success'] = "Inscrição concluída com sucesso!";
header("Location: servicos.php");
exit();