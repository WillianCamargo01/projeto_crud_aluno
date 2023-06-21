<?php
require_once 'conexao.php';

// Função para obter todos os alunos do banco de dados
function obterAlunos()
{
    global $conn;
    $sql = "SELECT * FROM aluno";
    $result = $conn->query($sql);
    $alunos = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $alunos[] = $row;
        }
    }
    return $alunos;
}

$alunos = obterAlunos();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Alunos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <h1>Listagem de Alunos</h1>
        <table id="tabela-alunos" class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Sobrenome</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alunos as $aluno) : ?>
                    <tr>
                        <td><?php echo $aluno['id']; ?></td>
                        <td><?php echo $aluno['nome']; ?></td>
                        <td><?php echo $aluno['sobrenome']; ?></td>
                        <td><?php echo $aluno['email']; ?></td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm visualizar-aluno" data-id="<?php echo $aluno['id']; ?>">Visualizar</button>
                            <a href="edicao.php?id=<?php echo $aluno['id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                            <a href="exclusao.php?id=<?php echo $aluno['id']; ?>" class="btn btn-danger btn-sm">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="inclusao.php" class="btn btn-primary mb-1">Adicionar Aluno</a>

        <!-- Modal do Aluno -->
        <div class="modal fade" id="modal-aluno" tabindex="-1" role="dialog" aria-labelledby="modal-aluno-label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-aluno-label">Detalhes do Aluno</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal-aluno-body">
                        <!-- Conteúdo do modal será preenchido dinamicamente -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function () {
    var tabelaAlunos = $('#tabela-alunos').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/Portuguese-Brasil.json"
        },
        "pagingType": "full_numbers",
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        "pageLength": 10,
        "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        "oLanguage": {
            "sLengthMenu": "_MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros totais)",
            "sSearch": "Pesquisar:",
            "oPaginate": {
                "sFirst": "Primeiro",
                "sLast": "Último",
                "sNext": "Próximo",
                "sPrevious": "Anterior"
            }
        }
    });

        // Ao clicar no botão "Visualizar", preenche o modal com as informações do aluno
            $('body').on('click', '.visualizar-aluno', function () {
            var alunoId = $(this).data('id');
            obterDetalhesAluno(alunoId);
        });
    });

            // Função para obter os detalhes do aluno a partir do banco de dados
        function obterDetalhesAluno(alunoId) {
            $.ajax({
                url: 'obter_detalhes_aluno.php', // Caminho para o arquivo PHP que fará a consulta no banco de dados
                method: 'POST',
                data: { id: alunoId }, // Passa o ID do aluno como parâmetro
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        preencherModal(response.aluno); // Preenche o modal com os dados retornados pelo PHP
                        $('#modal-aluno').modal('show'); // Abre o modal
                    } else {
                        console.error(response.message); // Exibe uma mensagem de erro no console, se necessário
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText); // Exibe uma mensagem de erro no console
                }
            });
        }
      

        // Função para preencher o modal com as informações do aluno
        function preencherModal(aluno) {
            var modalBody = $('#modal-aluno-body');
            modalBody.empty();
            modalBody.append('<p><strong>ID:</strong> ' + (aluno.id || '') + '</p>');
            modalBody.append('<p><strong>Nome:</strong> ' + (aluno.nome || '') + '</p>');
            modalBody.append('<p><strong>Sobrenome:</strong> ' + (aluno.sobrenome || '') + '</p>');
            modalBody.append('<p><strong>Email:</strong> ' + (aluno.email || '') + '</p>');
        }
    </script>
</body>
</html>
