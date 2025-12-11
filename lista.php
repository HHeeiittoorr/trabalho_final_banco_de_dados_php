<?php
session_start();
include "conexao.php";



//Verificar se os campos estão preenchidos e preencher o array alunos
if(isset($_POST['name']) && $_POST['name'] != '') {
    $alunos = array();
    
    $alunos['name'] = $_POST['name'];
}

if(isset($_POST['birth_date']) && $_POST['birth_date'] != '') {
    $alunos['birth_date'] = $_POST['birth_date'];
}

if(isset($_POST['street']) && $_POST['street'] != '') {
    $alunos['street'] = $_POST['street'];
}

if(isset($_POST['telefone']) && $_POST['telefone'] != '') {
    $alunos['telefone'] = $_POST['telefone'];
}

if(isset($_POST['bairro']) && $_POST['bairro'] != '') {
    $alunos['bairro'] = $_POST['bairro'];
}

if(isset($_POST['cep']) && $_POST['cep'] != '') {
    $alunos['cep'] = $_POST['cep'];
}

if(isset($_POST['parent_name']) && $_POST['parent_name'] != '') {
    $alunos['parent_name'] = $_POST['parent_name'];
}

if(isset($_POST['curso']) && $_POST['curso'] != '') {
    $alunos['curso'] = $_POST['curso'];
}



$condicao = "";

if (!empty($_GET['busca'])) {
    $campo = $_GET['campo'];
    $valor = $_GET['busca'];
    $valor = "%$valor%";

    if (!empty($_GET['busca'])) {

    $campo = $_GET['campo'];
    $valor = $_GET['busca'];

    // Converter busca textual do curso para número equivalente
    if ($campo === 'curso') {

        $map = [
            'enfermagem' => 1,
            'Enfermagem' => 1,
            'enfe'=> 1,
            'A' => 1,
            'a' => 1,
            'informática' => 2,
            'Informática' => 2,
            'informatica' => 2, // sem acento
            'Informatica' => 2, // sem acento
            'b' => 2, // sem acento
            'B' => 2, // sem acento
            'administração' => 3,
            'administracao' => 3,
            'adm' => 3,
            'd' => 3,
            'D' => 3,
            'comércio' => 4,
            'comercio' => 4,
            'c' => 4,
            'C' => 4,
            'desenvolvimento de sistemas' => 5,
            'ds' => 5,
            'e' => 5,
            'E' => 5
        ];

        $valorLower = strtolower(trim($valor));

        if (isset($map[$valorLower])) {
            // substitui a busca textual pelo ID correspondente
            $valor = $map[$valorLower];
            $condicao = "WHERE $campo = ?";
        } else {
            // busca inválida → vai retornar vazio
            $valor = -1;  
            $condicao = "WHERE $campo = ?";
        }

    } else {
        // Busca normal (LIKE)
        $valor = "%$valor%";
        $condicao = "WHERE $campo LIKE ?";
    }
}
}

$sql = "SELECT * FROM aluno_matriculado $condicao ORDER BY name";
$stmt = $conexao->prepare($sql);

if (!empty($_GET['busca'])) {
    $stmt->bind_param("s", $valor);
}

$stmt->execute();
$result = $stmt->get_result();

$lista_alunos = $result->fetch_all(MYSQLI_ASSOC);

/*$lista_alunos = buscar_alunos($conexao);
function buscar_alunos($conexao) {
    $sql_busca = 'SELECT * FROM aluno_matriculado';
    $resultado = mysqli_query($conexao, $sql_busca);
    $alunos = array();

    while($aluno = mysqli_fetch_assoc($resultado)) {
        $alunos[] = $aluno;
    }
    return $alunos;
}*/

?>