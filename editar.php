<?php
session_start();
include 'conexao.php';

//chatgptis

$cursos = [
    1 => "Enfermagem",
    2 => "Informática",
    3 => "Administração",
    4 => "Comércio",
    5 => "Desenvolvimento de Sistemas"
];


// Busca dados do aluno
$alunos = busca_aluno($conexao, $_GET['id_aluno']);

function busca_aluno($conexao, $id) {
    $sql = "SELECT * FROM aluno_matriculado WHERE id_aluno = $id";
    $result = mysqli_query($conexao, $sql);
    return mysqli_fetch_assoc($result);
}

include('menu.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Aluno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-sm-center h-100">

                <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-9">
                    <div class="card">
                        <div class="card-body p-5">

                            <h1 class="fs-4 card-title fw-bold mb-4 text-center">Editar Aluno</h1>

                            <?php if (isset($_SESSION['erro'])): ?>
                                <div class="alert alert-danger text-center">
                                    <?= $_SESSION['erro']; ?>
                                </div>
                                <?php unset($_SESSION['erro']); ?>
                            <?php endif; ?>

                            <?php if (isset($_SESSION['sucesso'])): ?>
                                <div class="alert alert-success text-center">
                                    <?= $_SESSION['sucesso']; ?>
                                </div>
                                <?php unset($_SESSION['sucesso']); ?>
                            <?php endif; ?>

                            <form action="editarback.php?id_aluno=<?= $alunos['id_aluno'] ?>" method="POST">

                                <h2 class="fs-3 mb-3 text-center">Informações Primárias</h2>

                                <div class="row">

                                    <div class="col-6 mb-3">
                                        <label class="text-muted">Nome:</label>
                                        <input type="text" name="name" class="form-control" value="<?= $alunos['name'] ?>" required>
                                    </div>

                                    <div class="col-6 mb-3">
                                        <label class="text-muted">Data de Nascimento:</label>
                                        <input type="date" name="birth_date" class="form-control" value="<?= $alunos['birth_date'] ?>" required>
                                    </div>

                                </div>

                                <h2 class="fs-3 mb-3 text-center">Endereço</h2>

                                <div class="row">

                                    <div class="col-6 mb-3">
                                        <label class="text-muted">Rua:</label>
                                        <input type="text" name="street" class="form-control" value="<?= $alunos['street'] ?>" required>
                                    </div>

                                    <div class="col-6 mb-3">
                                        <label class="text-muted">Telefone:</label>
                                        <input type="text" name="telefone" class="form-control" maxlength="8" value="<?= $alunos['telefone'] ?>" required>
                                    </div>

                                    <div class="col-6 mb-3">
                                        <label class="text-muted">Bairro:</label>
                                        <input type="text" name="bairro" class="form-control" value="<?= $alunos['bairro'] ?>" required>
                                    </div>

                                    <div class="col-6 mb-3">
                                        <label class="text-muted">CEP:</label>
                                        <input type="text" name="cep" class="form-control" maxlength="8" value="<?= $alunos['cep'] ?>" required>
                                    </div>

                                </div>

                                <h2 class="fs-3 mb-3 text-center">Responsável</h2>

                                <div class="row">

                                    <div class="col-8 mb-3">
                                        <label class="text-muted">Nome do Responsável:</label>
                                        <input type="text" name="parent_name" class="form-control" value="<?= $alunos['parent_name'] ?>" required>
                                    </div>

                                    <div class="col-4 mb-3">
                                        <label class="text-muted">Tipo:</label>
                                        <select class="form-select" name="type_parent">
                                            <option value="1" <?= $alunos['type_parent'] == 1 ? "selected" : "" ?>>Pai</option>
                                            <option value="2" <?= $alunos['type_parent'] == 2 ? "selected" : "" ?>>Mãe</option>
                                            <option value="3" <?= $alunos['type_parent'] == 3 ? "selected" : "" ?>>Avó</option>
                                            <option value="4" <?= $alunos['type_parent'] == 4 ? "selected" : "" ?>>Avô</option>
                                            <option value="5" <?= $alunos['type_parent'] == 5 ? "selected" : "" ?>>Tia</option>
                                            <option value="6" <?= $alunos['type_parent'] == 6 ? "selected" : "" ?>>Tio</option>
                                        </select>
                                    </div>

                                </div>

                                <h2 class="fs-3 mb-3 text-center">Curso:</h2>

                                <div class="row">

                                    <div class="col-6 mb-3">
                                        <label class="text-muted">Tipo:</label>
                                        <select class="form-select" name="curso">
                                            <option value="1" <?= $alunos['curso'] == 1 ? "selected" : "" ?>>Enfermagem</option>
                                            <option value="2" <?= $alunos['curso'] == 2 ? "selected" : "" ?>>Informática</option>
                                            <option value="3" <?= $alunos['curso'] == 3 ? "selected" : "" ?>>Administração</option>
                                            <option value="4" <?= $alunos['curso'] == 4 ? "selected" : "" ?>>Cómercio</option>
                                            <option value="5" <?= $alunos['curso'] == 5 ? "selected" : "" ?>>Desenvolvimento de Sistemas</option>
                                        </select>
                                    </div>

                                </div>

                                <button class="btn btn-primary w-30">Atualizar</button>

                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</body>
</html>