<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Verifica se o ID do usuário está definido
if (!isset($_GET['id'])) {
    header("Location: efetivo.php");
    exit();
}

$id = $_GET['id'];

// Primeiro, delete os registros relacionados na tabela confirmados
$stmt = $pdo->prepare("DELETE FROM confirmados WHERE usuario_id = :id");
$stmt->execute(['id' => $id]);

// Agora, delete o usuário da tabela usuarios
$stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
$stmt->execute(['id' => $id]);

header("Location: efetivo.php");
exit();