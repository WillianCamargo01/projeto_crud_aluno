<?php
require_once 'conexao.php';

// Verifica se o ID do aluno foi recebido na requisição POST
if (isset($_POST['id'])) {
    $alunoId = $_POST['id'];

    // Consulta o banco de dados para obter os detalhes do aluno com base no ID
    $sql = "SELECT * FROM aluno WHERE id = $alunoId";
    $result = $conn->query($sql);

    // Verifica se a consulta foi bem-sucedida
    if ($result && $result->num_rows > 0) {
        $aluno = $result->fetch_assoc();
        $response = array(
            'success' => true,
            'aluno' => $aluno
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Não foi possível obter os detalhes do aluno.'
        );
    }
} else {
    $response = array(
        'success' => false,
        'message' => 'ID do aluno não fornecido.'
    );
}

// Retorna a resposta como JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
