<?php
// Definir as credenciais de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "o@rf4zvX*Rrv5XP.";
$dbname = "aluno";

// Criar a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar se a conexão foi estabelecida com sucesso
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}
?>
