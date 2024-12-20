<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['voluntarios'])) {
        $voluntariosSelecionados = $_POST['voluntarios'];

        foreach ($voluntariosSelecionados as $voluntario_id) {
            // Insere na tabela de selecionados
            $stmt = $pdo->prepare("INSERT INTO selecionados (usuario_id, servico_id) 
                                    SELECT usuario_id, servico_id FROM voluntarios WHERE id = :voluntario_id");
            $stmt->execute(['voluntario_id' => $voluntario_id]);
        }
        
        // Opcional: Remover os voluntários selecionados da tabela de voluntários
        $stmt = $pdo->prepare("DELETE FROM voluntarios WHERE id IN (" . implode(',', array_fill(0, count($voluntariosSelecionados), '?')) . ")");
        $stmt->execute($voluntariosSelecionados);

        $_SESSION['sucesso'] = "Voluntários selecionados com sucesso.";
    } else {
        $_SESSION['erro'] = "Nenhum voluntário selecionado.";
    }
    
    header("Location: servicos.php");
    exit();
}
?>