<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['servico_id']) || !isset($_POST['quantidade'])) {
    header("Location: login.php");
    exit();
}

$servico_id = (int)$_POST['servico_id'];
$quantidade = (int)$_POST['quantidade'];

// Aqui você pode adicionar a lógica para processar a seleção dos voluntários.
// Por exemplo, você pode armazenar a seleção em uma tabela ou enviar um e-mail.

// Para este exemplo, vamos apenas redirecionar de volta com uma mensagem de confirmação.
$_SESSION['success'] = "Você selecionou $quantidade voluntários para o serviço com ID $servico_id.";
header("Location: voluntarios.php?servico_id=$servico_id");
exit();