<?php
require_once 'conexao.php';

// Verificar se o ID do aluno foi fornecido na URL
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $email = $_POST['email'];

    // Atualizar os dados do aluno no banco de dados
    $sql = "UPDATE aluno SET nome = '$nome', sobrenome = '$sobrenome', email = '$email' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Erro ao atualizar o aluno: " . $conn->error;
    }
}

$aluno = obterAluno($id);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Aluno</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #343a40;
            color: #fff;
        }
        
        .container {
            margin-top: 30px;
            max-width: 400px;
        }
        
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        
        form {
            margin-top: 20px;
        }
        
        .form-group label {
            font-weight: bold;
        }
        
        .btn-primary {
            width: 100%;
            margin-bottom: 5px;
        }

        .btn-danger {
            width: 100%
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Aluno</h1>
        <form method="POST">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $aluno['nome']; ?>" required>
            </div>
            <div class="form-group">
                <label for="sobrenome">Sobrenome</label>
                <input type="text" class="form-control" id="sobrenome" name="sobrenome" value="<?php echo $aluno['sobrenome']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $aluno['email']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="index.php" class="btn btn-danger">Cancelar</a>
        </form>
    </div>
</body>
</html>
