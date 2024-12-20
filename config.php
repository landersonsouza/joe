<?php
$host = 'localhost';
$db = 'sistema_servicos'; // Substitua pelo nome do seu banco de dados
$user = 'root'; // Substitua pelo seu usuário do banco de dados
$pass = ''; // Substitua pela sua senha do banco de dados

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $db :" . $e->getMessage());
}
?>