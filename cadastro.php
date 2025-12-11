<?php
session_start();
include 'conexao.php';
//verificar se os campos estão vazios
if(empty($_POST['nome'] || empty($_POST['email']) || empty($_POST['senha']))) {
    $_SESSION['mensagem'] = "Preencha todos os campos!";
    header('Location: telacadastro.php');
    exit();
}

//sanitização contra atque sql injection
$nome = mysqli_escape_string($conexao, trim($_POST['nome']));
$email = mysqli_escape_string($conexao, trim($_POST['email']));
$senha = mysqli_escape_string($conexao, trim($_POST['senha']));

//verificar se já não existem campos iguais nos bancos
$sql = "SELECT count(*) AS total FROM users WHERE user_email = '$email'";
$result = mysqli_query($conexao, $sql);
$row = mysqli_fetch_assoc($result);

if($row['total'] > 0) {
    $_SESSION['mensagem'] = "Email já cadastrado!";
    header('Location: telacadastro.php');
    exit();
}

//inserir um novo usuário no banco
$sqlInserir = "INSERT INTO users(user_name, user_email, user_password)
                    VALUES('$nome', '$email', MD5('$senha'))";

if(mysqli_query($conexao, $sqlInserir)) {
    $_SESSION['mensagem'] = "Cadastro realizado com sucesso! Faça Login.";
    header('Location: index.php');
    exit();
}else {
    $_SESSION['mensagem'] = "Erro ao cadastrar!" . mysqli_error($conexao);
    header('Location: telacadastro.php');
    exit();
}
?>