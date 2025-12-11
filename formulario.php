<?php
session_start();
include 'conexao.php';
include 'helper.php';
//verificar se os campos estão vazios
if(empty($_POST['name']) || empty($_POST['birth_date']) || empty($_POST['street'])
    || empty($_POST['telefone']) || empty($_POST['bairro']) || empty($_POST['cep']) || empty($_POST['curso'])
    || empty($_POST['parent_name']) || empty($_POST['type_parent'])) {
    $_SESSION['erro'] = "Preencha todos os campos!";
    header('Location: telaformulario.php');
    exit();
}

//Chat gpt correcting

# validar tamanho do telefone
if (strlen($_POST['telefone']) != 8) {
    $_SESSION['erro'] = "O telefone deve ter exatamente 8 dígitos!";
    header('Location: telaformulario.php');
    exit();
}

# validar tamanho do CEP
if (strlen($_POST['cep']) != 8) {
    $_SESSION['erro'] = "O CEP deve ter exatamente 8 dígitos!";
    header('Location: telaformulario.php');
    exit();
}

# VALIDAR NOME (só letras e espaços)
if (!preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ ]+$/", $_POST['name'])) {
    $_SESSION['erro'] = "O nome deve conter apenas letras.";
    header('Location: telaformulario.php');
    exit();
}

# VALIDAR NOME DO RESPONSÁVEL (só letras e espaços)
if (!preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ ]+$/", $_POST['parent_name'])) {
    $_SESSION['erro'] = "O nome do responsável deve conter apenas letras.";
    header('Location: telaformulario.php');
    exit();
}

# VALIDAR TELEFONE (somente números)
if (!ctype_digit($_POST['telefone'])) {
    $_SESSION['erro'] = "O telefone deve conter apenas números.";
    header('Location: telaformulario.php');
    exit();
}

# VALIDAR CEP (somente números e com 8 dígitos)
if (!ctype_digit($_POST['cep']) || strlen($_POST['cep']) != 8) {
    $_SESSION['erro'] = "O CEP deve conter apenas números e ter 8 dígitos.";
    header('Location: telaformulario.php');
    exit();
}

//sanitização contra atque sql injection
$nome = mysqli_escape_string($conexao, trim($_POST['name']));
$birth_date = mysqli_escape_string($conexao, trim($_POST['birth_date']));
$street = mysqli_escape_string($conexao, trim($_POST['street']));
$telefone = mysqli_escape_string($conexao, trim($_POST['telefone']));
$bairro = mysqli_escape_string($conexao, trim($_POST['bairro']));
$cep = mysqli_escape_string($conexao, trim($_POST['cep']));
$curso = mysqli_escape_string($conexao, trim($_POST['curso']));
$parent_name = mysqli_escape_string($conexao, trim($_POST['parent_name']));
$type_parent = mysqli_escape_string($conexao, trim($_POST['type_parent']));



//inserir um novo usuário no banco
$sqlInserir = "INSERT INTO aluno_matriculado(name, birth_date, street, telefone, bairro, cep, curso, parent_name, type_parent)
                    VALUES('$nome', '$birth_date', '$street', '$telefone', '$bairro', '$cep', '$curso',
                    '$parent_name', '$type_parent')";

if(mysqli_query($conexao, $sqlInserir)) {
    $_SESSION['sucesso'] = "Dados salvos com sucesso.";
    header('Location: telaformulario.php');
    exit();
}else {
    $_SESSION['erro'] = "Erro ao salvar os arquivos!" . mysqli_error($conexao);
    header('Location: telaformulario.php');
    exit();
}

///sla
/*if (!is_numeric($cep)) {
    $_SESSION['mensagem'] = "Não é permitido letras no campo CEP";
    header('Location: telaformulario.php');
    exit();
} 

if (strlen($cep) !=8) {
    $_SESSION['messagem'] = "Informou caracteres demais ou insuficentes no campo CEP.";
    header('Location: telaformulario.php');
    exit();
}

if(!is_numeric($telefone)) {
    $_SESSION['mensagem'] = "Não é permitido letras no campo TELEFONE. (Ou talvez colocou caracteres insuficientes/demais)";
    header('Location: telaformulario.php');
    exit();
}

if (strlen($telefone) != 8) {
    $_SESSION['mensagem'] = "Faltou informações suficientes no campo de telefone.";
    header('Location: telaformulario.php');
    exit();
}

if (is_numeric($nome) || is_numeric($parent_name) || is_numeric($bairro)) {
    $_SESSION['mensagem'] = "Não é permitido números nos campos NOME, NOME DO RESPONSÁVEL ou BAIRRO.";
    header('Location: telaformulario.php');
    exit();
} */
/////
?>