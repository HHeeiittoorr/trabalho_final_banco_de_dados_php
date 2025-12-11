<?php
include "menu.php";
include "lista.php";
include "helper.php";

$cursos = [
    1 => "Enfermagem",
    2 => "Informática",
    3 => "Administração",
    4 => "Comércio",
    5 => "Desenvolvimento de Sistemas"
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alunos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
     <div class="container mt-4">

        <!-- FORMULÁRIO DE BUSCA -->
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="busca" class="form-control"
                       placeholder="Pesquisar..."
                       value="<?php echo $_GET['busca'] ?? ''; ?>">
            </div>

            <div class="col-md-4">
                <select name="campo" class="form-select">
                    <option value="name">Nome</option>
                    <option value="parent_name">Nome do pai</option>
                    <option value="curso">Curso</option>
                    <option value="bairro">Bairro</option>
                    <option value="telefone">Telefone</option>
                    <option value="street">Rua</option>
                    <option value="cep">CEP</option>
                    <option value="birth_date">Nascimento</option>
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary w-100">Filtrar</button>
            </div>

            <div class="col-md-2">
                <a href="listar.php" class="btn btn-secondary w-100">Limpar</a>
            </div>
        </form>

        <h2 class="mt-4">Alunos Matriculados:</h2>

        <!-- TABELA RESPONSIVA -->
        <div class="table-responsive mt-3">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Nascimento</th>
                        <th>Rua</th>
                        <th>Telefone</th>
                        <th>Bairro</th>
                        <th>CEP</th>
                        <th>Responsável</th>
                        <th>Curso</th>
                        <th>Opções</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (count($lista_alunos) == 0): ?>
                        <tr>
                            <td colspan="9" class="text-center text-warning">
                                Nenhum aluno encontrado para essa pesquisa.
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($lista_alunos as $alunos): ?>
                    <tr>
                        <td><?= $alunos['name']; ?></td>
                        <td><?= traduz_data_para_exibir($alunos['birth_date']); ?></td>
                        <td><?= $alunos['street']; ?></td>
                        <td><?= $alunos['telefone']; ?></td>
                        <td><?= $alunos['bairro']; ?></td>
                        <td><?= $alunos['cep']; ?></td>
                        <td><?= $alunos['parent_name']; ?></td>
                        <td><?= $cursos[$alunos['curso']]; ?></td>
                        <td>
                            <a class="btn btn-primary btn-sm"
                               href="editar.php?id_aluno=<?= $alunos['id_aluno']; ?>">
                                Editar
                            </a>

                            <a class="btn btn-danger btn-sm"
                               href="deletar.php?id_aluno=<?= $alunos['id_aluno']; ?>">
                                Deletar
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>

    </div>

    </body>
    </html>