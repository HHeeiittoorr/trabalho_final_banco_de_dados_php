<?php
include 'conexao.php';

remover_aluno($conexao, $_GET['id_aluno']);

function remover_aluno($conexao, $id) {
    $sql_deleta = "DELETE FROM aluno_matriculado where id_aluno = {$id}";
    mysqli_query($conexao, $sql_deleta);
}
header('Location: listar.php');
?>