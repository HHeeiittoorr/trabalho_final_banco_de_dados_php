<?php
session_start();
include 'conexao.php';

$id = $_GET['id_aluno'];

//Ajuda do gepeto
# RECEBE CAMPOS
$name = $_POST['name'];
$birth = $_POST['birth_date'];
$street = $_POST['street'];
$telefone = $_POST['telefone'];
$bairro = $_POST['bairro'];
$cep = $_POST['cep'];
$parent = $_POST['parent_name'];
$type = $_POST['type_parent'];
$curso = $_POST['curso'];

# VALIDAÇÕES
if (!ctype_alpha(str_replace(' ', '', $name))) {
    $_SESSION['erro'] = "O nome não pode conter números.";
    header("Location: editar.php?id_aluno=$id");
    exit();
}
if (!preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ ]+$/", $name)) {
    $_SESSION['erro'] = "O nome deve conter apenas letras.";
    header("Location: editar.php?id_aluno=$id");
    exit();
}

# VALIDAR NOME DO RESPONSÁVEL (só letras e espaços)
if (!preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ ]+$/", $parent)) {
    $_SESSION['erro'] = "O nome do responsável deve conter apenas letras.";
    header("Location: editar.php?id_aluno=$id");
    exit();
}


if (!ctype_digit($telefone) || strlen($telefone) != 8) {
    $_SESSION['erro'] = "O telefone deve conter exatamente 8 números.";
    header("Location: editar.php?id_aluno=$id");
    exit();
}

if (!ctype_digit($cep) || strlen($cep) != 8) {
    $_SESSION['erro'] = "O CEP deve conter exatamente 8 números.";
    header("Location: editar.php?id_aluno=$id");
    exit();
}

# ATUALIZA NO BANCO
$sql = "UPDATE aluno_matriculado SET 
    name = '$name',
    birth_date = '$birth',
    street = '$street',
    telefone = '$telefone',
    bairro = '$bairro',
    cep = '$cep',
    parent_name = '$parent',
    type_parent = '$type',
    curso = '$curso'
    WHERE id_aluno = $id";

mysqli_query($conexao, $sql);

header("Location: listar.php");
exit();