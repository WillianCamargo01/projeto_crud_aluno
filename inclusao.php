<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $email = $_POST['email'];

    // Inserir o aluno no banco de dados
    $sql = "INSERT INTO aluno (nome, sobrenome, email) VALUES ('$nome', '$sobrenome', '$email')";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Erro ao adicionar o aluno: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Aluno</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #343a40;
            color: #fff;
        }
        
        .container {
            margin-top: 100px;
        }
        
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        
        form {
            max-width: 400px;
            margin: 0 auto;
        }
        
        .form-group label {
            font-weight: bold;
        }
        
        .btn-primary {
            width: 100%;
            margin-bottom: 5px;
        }
        .btn-danger {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Adicionar Aluno</h1>
        <form method="POST">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="sobrenome">Sobrenome</label>
                <input type="text" class="form-control" id="sobrenome" name="sobrenome" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Adicionar</button>
            <a href="index.php" class="btn btn-danger">Cancelar</a>
        </form>
    </div>
</body>
</html>
