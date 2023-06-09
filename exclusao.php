<?php
require_once 'conexao.php';

// Verificar se o ID do aluno foi fornecido na URL
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Verificar se o formulário de confirmação foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Excluir o aluno do banco de dados
    $sql = "DELETE FROM aluno WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Erro ao excluir o aluno: " . $conn->error;
    }
}

// Função para obter um único aluno com base no ID
function obterAluno($id) {
    global $conn;
    $sql = "SELECT * FROM aluno WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows === 1) {
        $aluno = $result->fetch_assoc();
        return $aluno;
    } else {
        header("Location: index.php");
        exit();
    }
}

$aluno = obterAluno($id);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Excluir Aluno</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #343a40;
            color: #fff;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Excluir Aluno</h1>
        <p>Você tem certeza que deseja excluir o aluno(a) <?php echo $aluno['nome'] . ' ' . $aluno['sobrenome']; ?>?</p>
        <form method="POST">
            <button type="submit" class="btn btn-danger">Excluir</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
