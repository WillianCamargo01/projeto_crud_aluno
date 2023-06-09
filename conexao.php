<?php
// Credenciais de conexão com o banco de dados
$servername = "db-ads.c8bqy6anulng.sa-east-1.rds.amazonaws.com";
$username = "admin";
$password = "Unimar-ads-2023";
$dbname = "minha_base";

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi estabelecida com sucesso
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}
