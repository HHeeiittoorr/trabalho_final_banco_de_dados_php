<!-- Meu código, Tudo que estiver assinalado com (gpt) foi do chat gpt, e tudo com # para indicar anotações tbm é.

<?php
/*session_start();
include('verifica_login.php');
include('menu.php'); */
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
        <h2>Olá, <?php /*echo $_SESSION['email']; */?></h2>


    <div class="container mt-4">
        <div class="row justify-content-sm-center h-100 g-3">

            <div class="col-3">

                <div class="col-3">
                    <div class="card border-dark mb-3">
                        <div class="card-header">Alunos por Curso</div>
                        <div class="card-body">
                            <canvas id="graficoCursos"></canvas>
                        </div>
                    </div>
                </div>
            
            </div>
            
            <div class="col-3">
                
                <div class="card border-dark mb-3" >
                    <div class="card-header">Header</div>
                    <div class="card-body">
                        <h5 class="card-title">Dark card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                    </div>
                </div>
            
            </div>
            
            <div class="col-3">

                <div class="card border-dark mb-3" >
                    <div class="card-header">Header</div>
                    <div class="card-body">
                        <h5 class="card-title">Dark card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                    </div>
                </div>
                
            </div>
            
            <div class="row justify-content-sm-center h-100 g-1">
                <div class="col-9">
                    <div class="card border-dark mb-3">
                        <div class="card-header">Idade dos Alunos</div>
                        <div class="card-body" style="height:300px;">
                            <canvas id="graficoIdade"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
    </div>



</body>
</html>
-->

<!-- Esse tem algumas alterações do GPT -->
<?php
session_start();
include('verifica_login.php');
include('menu.php');
include('conexao.php');

// -----------------------------
// BUSCAR DADOS DO BANCO
// -----------------------------

// 1) Alunos por curso (agrupar por número do curso)
$sql = "SELECT curso, COUNT(*) AS total FROM aluno_matriculado GROUP BY curso";
$rCursos = mysqli_query($conexao, $sql);
$dadosCursos = []; // [curso_num => total]
while ($row = mysqli_fetch_assoc($rCursos)) {
    // garantir que curso venha como inteiro (caso esteja salvo como string)
    $k = (int)$row['curso'];
    $dadosCursos[$k] = (int)$row['total'];
}

// 2) Idades dos alunos — vamos pegar todas as datas e transformar em idade, depois contar
$sql2 = "SELECT birth_date FROM aluno_matriculado WHERE birth_date IS NOT NULL AND birth_date <> '0000-00-00'";
$rIdade = mysqli_query($conexao, $sql2);
$idades = [];
$hoje = new DateTime();
while ($row = mysqli_fetch_assoc($rIdade)) {
    // proteger caso data mal formatada
    $bd = $row['birth_date'];
    if (!$bd) continue;
    try {
        $nasc = new DateTime($bd);
        $idade = $nasc->diff($hoje)->y;
        $idades[] = $idade;
    } catch (Exception $e) {
        // ignora datas inválidas
        continue;
    }
}
// Contar quantas pessoas de cada idade
$contagemIdades = array_count_values($idades);
ksort($contagemIdades); // ordenar por idade

// 3) Alunos por CEP
$sql3 = "SELECT cep, COUNT(*) AS total FROM aluno_matriculado GROUP BY cep ORDER BY total DESC LIMIT 20";
$rCep = mysqli_query($conexao, $sql3);
$dadosCep = []; // [cep => total]
while ($row = mysqli_fetch_assoc($rCep)) {
    $cep = $row['cep'];
    $dadosCep[$cep] = (int)$row['total'];
}

// 4) Alunos por bairro
$sql4 = "SELECT bairro, COUNT(*) AS total FROM aluno_matriculado GROUP BY bairro ORDER BY total DESC LIMIT 20";
$rBairro = mysqli_query($conexao, $sql4);
$dadosBairro = []; // [bairro => total]
while ($row = mysqli_fetch_assoc($rBairro)) {
    $bairro = $row['bairro'] ?: 'Não informado';
    $dadosBairro[$bairro] = (int)$row['total'];
}

// Mapeamento dos cursos (para transformar id -> nome)
$cursosMap = [
    1 => "Enfermagem",
    2 => "Informática",
    3 => "Administração",
    4 => "Comércio",
    5 => "Desenvolvimento de Sistemas"
];

// Garantir que todas as chaves de curso apareçam (mesmo com 0)
foreach ($cursosMap as $k => $v) {
    if (!isset($dadosCursos[$k])) $dadosCursos[$k] = 0;
}

// Ordenar arrays por chave/valor onde faz sentido
ksort($dadosCursos);
arsort($dadosCep);
arsort($dadosBairro);

// Converter arrays PHP -> JSON para o JS usar
$jsonCursosLabels = json_encode(array_map(function($k) use ($cursosMap) {
    return isset($cursosMap[$k]) ? $cursosMap[$k] : "Curso $k";
}, array_keys($dadosCursos)));
$jsonCursosData   = json_encode(array_values($dadosCursos));

$jsonCepLabels = json_encode(array_keys($dadosCep));
$jsonCepData   = json_encode(array_values($dadosCep));

$jsonBairroLabels = json_encode(array_keys($dadosBairro));
$jsonBairroData   = json_encode(array_values($dadosBairro));

$jsonIdadeLabels = json_encode(array_keys($contagemIdades));
$jsonIdadeData   = json_encode(array_values($contagemIdades));

# 5) Total de alunos
$sqlTotal = "SELECT COUNT(*) AS total FROM aluno_matriculado";
$rTotal = mysqli_query($conexao, $sqlTotal);
$totalAlunos = mysqli_fetch_assoc($rTotal)['total'] ?? 0;

# 6) Média de alunos por curso
$sqlMedia = "SELECT COUNT(*) AS total, curso FROM aluno_matriculado GROUP BY curso";
$rMedia = mysqli_query($conexao, $sqlMedia);
$totais = [];
while ($row = mysqli_fetch_assoc($rMedia)) {
    $totais[] = (int)$row['total'];
}
$mediaAlunos = count($totais) > 0 ? array_sum($totais) / count($totais) : 0;
$mediaAlunos = number_format($mediaAlunos, 1, ',', '.'); // ex: 12,3 alunos

// 6.1) Média de alunos por BAIRRO
$sqlMediana = "SELECT COUNT(*) AS total, curso FROM aluno_matriculado GROUP BY bairro";
$rMediana = mysqli_query($conexao, $sqlMediana);
$totalidades = [];
while ($row = mysqli_fetch_assoc($rMediana)) {
    $totalidades[] = (int)$row['total'];
}
$mediaBairro = count($totalidades) > 0 ? array_sum($totalidades) / count($totalidades) : 0;
$mediaBairro = number_format($mediaBairro, 1, ',', '.'); // ex: 12,3 alunos

// 6.2) Média de alunos por CEP
$sqlModa = "SELECT COUNT(*) AS total, curso FROM aluno_matriculado GROUP BY cep";
$rModa = mysqli_query($conexao, $sqlModa);
$totalitarias = [];
while ($row = mysqli_fetch_assoc($rModa)) {
    $totalitarias[] = (int)$row['total'];
}
$mediaCep = count($totalitarias) > 0 ? array_sum($totalitarias) / count($totalitarias) : 0;
$mediaCep = number_format($mediaCep, 1, ',', '.'); // ex: 12,3 alunos

# 7) Curso com mais alunos
$sqlTopCurso = "SELECT curso, COUNT(*) AS total FROM aluno_matriculado GROUP BY curso ORDER BY total DESC LIMIT 1";
$rTopCurso = mysqli_query($conexao, $sqlTopCurso);

$topCursoRow = mysqli_fetch_assoc($rTopCurso);
$cursoTopID = $topCursoRow['curso'] ?? null;
$cursoTopNome = $cursoTopID ? ($cursosMap[$cursoTopID] ?? "Curso $cursoTopID") : "Nenhum";
$cursoTopQtd = $topCursoRow['total'] ?? 0;

// 8) Bairro com mais alunos (alterado a mão)
$sqlTopBairro = "SELECT bairro, COUNT(*) AS total FROM aluno_matriculado GROUP BY bairro ORDER BY total DESC LIMIT 1";
$rTopBairro = mysqli_query($conexao, $sqlTopBairro);

$topBairroRow = mysqli_fetch_assoc($rTopBairro);
$bairroTopID = $topBairroRow['bairro'] ?? null;
$bairroTopNome = $bairroTopID ? ($cbairroMap[$bairroTopID] ?? "Bairro $bairroTopID") : "Nenhum";
$bairroTopQtd = $topBairroRow['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Painel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* altura padrão para cards pequenos */
        .card-body {
            position: relative;
            min-height: 260px; /* deixa expandir se precisar */
        }

        /* Card grande do gráfico de idade */
        .card-body.grafico-grande {
            min-height: 360px; /* espaço suficiente */
        }

        /* O canvas ocupa 100% do card sem distorcer o hover */
        .card-body canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100% !important;
            height: 100% !important;
        }

        /* Gráfico de idade maior */
        #graficoIdade {
            height: 320px !important;
        }
    </style>
</head>
<body>

<div class="container container-dashboard">
    <h2 class="mb-3">Olá, <?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?></h2>

    <div class="row g-4 mb-4">

    <!-- Card: Total de alunos -->
    <div class="col-md-4">
        <div class="card h-100 border-dark text-center p-3">
            <h5 class="card-header">Total de Alunos</h5>
            <div class="card-body">
                <h1 class="display-5 fw-bold"><?php echo $totalAlunos; ?></h1>
            </div>
        </div>
    </div>

    <!-- Card: Média de alunos por curso -->
    <div class="col-md-4">
        <div class="card h-100 border-dark text-center p-3">
            <h5 class="card-header">Média por Curso</h5>
            <div class="card-body">
                <h1 class="display-6 fw-bold"><?php echo $mediaAlunos; ?></h1>
            </div>
        </div>
    </div>

    <!-- Card: Curso com mais alunos -->
    <div class="col-md-4">
        <div class="card h-100 border-dark text-center p-3">
            <h5 class="card-header">Curso com Mais Alunos</h5>
            <div class="card-body">
                <h5 class="fw-bold"><?php echo $cursoTopNome; ?></h5>
                <p class="fs-4"><?php echo $cursoTopQtd; ?> alunos</p>
            </div>
        </div>
    </div>

</div>
        <div class="row g-4 mb-4">

        <!-- Card: Total de alunos POR BAIRRO -->
        <div class="col-md-4">
            <div class="card h-100 border-dark text-center p-3">
                <h5 class="card-header">Bairro com mais alunos:</h5>
                <div class="card-body">
                    <h1 class="display-5 fw-bold"><?php echo $bairroTopNome; ?></h1>
                </div>
            </div>
        </div>

        <!-- Card: Média de alunos por BAIRRO -->
        <div class="col-md-4">
            <div class="card h-100 border-dark text-center p-3">
                <h5 class="card-header">Média de alunos por bairro</h5>
                <div class="card-body">
                    <h1 class="display-6 fw-bold"><?php echo $mediaBairro; ?></h1>
                </div>
            </div>
        </div>

        <!-- Card: CEP MÉDIA -->
        <div class="col-md-4">
            <div class="card h-100 border-dark text-center p-3">
                <h5 class="card-header">Média de alunos por CEP</h5>
                <div class="card-body">
                    <h1 class="display-6 fw-bold"><?php echo $mediaCep; ?></h1>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-4">
        <!-- Card: Alunos por Curso (pizza) -->
        <div class="col-md-4 col-lg-4">
            <div class="card h-100 border-dark">
                <div class="card-header">Alunos por Curso</div>
                <div class="card-body">
                    <canvas id="graficoCursos"></canvas>
                </div>
            </div>
        </div>

        <!-- Card: Alunos por CEP (barra) -->
        <div class="col-md-4 col-lg-4">
            <div class="card h-100 border-dark">
                <div class="card-header">Alunos por CEP (top 10)</div>
                <div class="card-body">
                    <canvas id="graficoCep"></canvas>
                </div>
            </div>
        </div>

        <!-- Card: Alunos por Bairro (pizza) -->
        <div class="col-md-4 col-lg-4">
            <div class="card h-100 border-dark">
                <div class="card-header">Alunos por Bairro (top 20)</div>
                <div class="card-body">
                    <canvas id="graficoBairro"></canvas>
                </div>
            </div>
        </div>
        
    </div>

    <!-- Linha abaixo: gráfico maior de idade -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-dark">
                <div class="card-header">Idade dos Alunos</div>
                <div class="card-body grafico-grande">
                    <canvas id="graficoIdade"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPTS: construir gráficos com os dados do PHP -->
<script>
    // Dados vindos do PHP
    const cursosLabels = <?php echo $jsonCursosLabels; ?>;
    const cursosData   = <?php echo $jsonCursosData; ?>;

    const cepLabels = <?php echo $jsonCepLabels; ?>;
    const cepData   = <?php echo $jsonCepData; ?>;

    const bairroLabels = <?php echo $jsonBairroLabels; ?>;
    const bairroData   = <?php echo $jsonBairroData; ?>;

    const idadeLabels = <?php echo $jsonIdadeLabels; ?>;
    const idadeData   = <?php echo $jsonIdadeData; ?>;

    // cores simples e agradáveis
    const palette = [
        '#4e73df','#1cc88a','#36b9cc','#f6c23e','#e74a3b',
        '#858796','#5a5c69','#2e59d9','#17a673','#2c9faf'
    ];

    // -------------------------
    // Gráfico: Alunos por Curso (pie)
    // -------------------------
    const ctxCursos = document.getElementById('graficoCursos').getContext('2d');
    new Chart(ctxCursos, {
        type: 'pie',
        data: {
            labels: cursosLabels,
            datasets: [{
                data: cursosData,
                backgroundColor: palette
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // -------------------------
    // Gráfico: CEP (bar)
    // -------------------------
    const ctxCep = document.getElementById('graficoCep').getContext('2d');
    new Chart(ctxCep, {
        type: 'bar',
        data: {
            labels: cepLabels,
            datasets: [{
                label: 'Quantidade',
                data: cepData,
                backgroundColor: palette[1]
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: { ticks: { autoSkip: false } },
                y: { beginAtZero: true }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });

    // -------------------------
    // Gráfico: Bairro (pie)
    // -------------------------
    const ctxBairro = document.getElementById('graficoBairro').getContext('2d');
    new Chart(ctxBairro, {
        type: 'pie',
        data: {
            labels: bairroLabels,
            datasets: [{
                data: bairroData,
                backgroundColor: palette
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // -------------------------
    // Gráfico: Idade (bar)
    // -------------------------
    const ctxIdade = document.getElementById('graficoIdade').getContext('2d');
    new Chart(ctxIdade, {
        type: 'bar',
        data: {
            labels: idadeLabels,
            datasets: [{
                label: 'Quantidade por idade',
                data: idadeData,
                backgroundColor: palette[2]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: { title: { display: true, text: 'Idade (anos)' } },
                y: { beginAtZero: true, title: { display: true, text: 'Quantidade' } }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });

</script>

</body>
</html>