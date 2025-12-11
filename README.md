# Trabalho Final Banco De Dados PHP
Esse é um trabalho realizado através das aulas de PHP e SQL do curso de informática da EEEP MANOEL MANO.

📌 Sobre o Projeto

Este sistema é uma aplicação web desenvolvida em PHP, integrada ao banco de dados MySQL, com o objetivo de realizar a gestão completa de alunos matriculados.
Ele permite:

 - Cadastro de alunos via interface web

 - Listagem completa dos registros

 - Visualização detalhada por meio de um painel interativo

 - Edição de informações

 - Exclusão de alunos

 - Exibição de métricas, gráficos e cards informativos

O projeto segue o padrão CRUD (Create, Read, Update, Delete) e foi estruturado para fins acadêmicos.

🗄️ Banco de Dados

O sistema utiliza um banco chamado login, contendo a tabela:

📌 Tabela aluno_matriculado
Campos seus	Tipos e	Descrição:
 - id_aluno	/ INT (PK, AUTO_INCREMENT)	/ Identificador único do aluno
 - name	/ VARCHAR(100)	/ Nome do aluno
 - birth_date	/ DATE	/ Data de nascimento
 - street	/ VARCHAR(100)	/ Endereço
 - telefone	/ CHAR(8)	/ Telefone sem DDD
 - bairro	/ VARCHAR(100)	/ Bairro onde mora
 - cep	/ VARCHAR(8)	/ CEP sem formatação
 - curso	/ VARCHAR(50)	/ Curso matriculado
 - parent_name	/ VARCHAR(100)	/ Nome do responsável
 - type_parent	/ VARCHAR(20)	/ Tipo de responsável (pai, mãe, etc.)

📌 Tabela users
Campos seus	Tipos e	Descrição:
 - user_name / varchar(100) / Nome do usuário
 - user_email / 	varchar(100) / Email do Usuário
 - user_password / varchar(100) / Senha do usuário
 - user_id / int (PK, AUTO_INCREMENT) / id para identificar no banco o usuário

📁 Estrutura do Projeto
/projeto-crud-php
│
├── conexao.php
├── index.php               → Tela de login
├── verifica_login.php
├── cadastro.php            → Cadastro de usuário/aluno
├── formulario.php          → Formulário de criação
├── telaformulario.php
├── listar.php              → Lista de alunos
├── lista.php
├── editar.php
├── editarback.php
├── deletar.php
├── painel.php              → Painel principal com métricas
├── menu.php                → Navegação do sistema
├── logout.php
└── assets/                 → CSS/JS

🚀 Funcionalidades do Sistema
 - Tela de login
O sistema possui uma tela de login completo com validação, permitindo o usuário de entrar dentro do site.
<img width="1920" height="1080" alt="Captura de tela 2025-12-11 141711" src="https://github.com/user-attachments/assets/c8c0ad2f-6e3e-4d38-b7d5-95502c870e84" />

 - Tela de Cadastro
O sistema possui uma tela de Cadastro, permitindo o usuário de criar uma conta e entrar dentro do site.
<img width="1920" height="1080" alt="Captura de tela 2025-12-11 141758" src="https://github.com/user-attachments/assets/d9edb878-61ca-4aba-80e6-6c743f643dcf" />
 
 - Cadastro de Alunos
O sistema possui um formulário completo com validação, permitindo inserir todos os dados do aluno no banco.
<img width="1919" height="806" alt="Captura de tela 2025-12-11 141929" src="https://github.com/user-attachments/assets/9f0c963c-9030-41dd-a4ae-8739cc1d7e9e" />
<img width="1917" height="578" alt="Captura de tela 2025-12-11 142006" src="https://github.com/user-attachments/assets/afbc3511-8c2d-4922-ba15-4935f8c6bc30" />

 - Listagem de Alunos
Página que exibe uma tabela com todos os registros cadastrados.
Nome, Curso, Bairro, Telefone, CEP, Responsável, Botões de Editar e Excluir
Essa página também contém um filtro de pesquisa para procurar alunos pelos registros cadastrados.
<img width="1920" height="1080" alt="Captura de tela 2025-12-11 142039" src="https://github.com/user-attachments/assets/fa67cedc-7671-4606-beb3-7d929241ba33" />


 - Edição de Dados
Permite modificar qualquer campo referente ao aluno.
<img width="1919" height="872" alt="Captura de tela 2025-12-11 142158" src="https://github.com/user-attachments/assets/272b07fa-95fd-4ba6-a2d8-15c675f5a622" />
<img width="1919" height="347" alt="Captura de tela 2025-12-11 142241" src="https://github.com/user-attachments/assets/1afa323f-f0aa-4c7e-a712-c10a362d2ec7" />

 - Exclusão de Alunos
A exclusão é feita por ID e é imediata. (Presente no print de Listagem de Alunos)

 - Painel Principal (Dashboard)
A tela inicial apresenta:

📊 Cards
Total de alunos cadastrados
Alunos por curso
Alunos de bairros fora da cidade
Alunos da sede
Alunos residentes na zona urbana / rural (caso aplicável)

📈 Gráficos
Top 10 CEPs
Quantidade de alunos por curso
Distribuição geográfica

<img width="1919" height="684" alt="Captura de tela 2025-12-11 142349" src="https://github.com/user-attachments/assets/45fe65a5-238e-44ca-8a78-68f8b975483f" />
<img width="1919" height="977" alt="Captura de tela 2025-12-11 142451" src="https://github.com/user-attachments/assets/d6763a62-96f5-4aec-af44-4db0aafa650e" />
<img width="1919" height="582" alt="Captura de tela 2025-12-11 142518" src="https://github.com/user-attachments/assets/fee4bb05-14fd-441f-8a7a-1ffc718b215b" />

 - Opção de Logout
Há uma opção de Logout onde você pode sair da conta presente na NAVBAR do site.


🔍 Consultas SQL utilizadas

Abaixo estão algumas das principais consultas usadas no sistema:

1️⃣ Listar todos os alunos
SELECT * FROM aluno_matriculado;

2️⃣ Contar total de alunos
SELECT COUNT(*) AS total FROM aluno_matriculado;

3️⃣ Alunos por curso
SELECT curso, COUNT(*) FROM aluno_matriculado GROUP BY curso;

5️⃣ Buscar aluno por ID
SELECT * FROM aluno_matriculado WHERE id_aluno = ?;

6️⃣ Atualizar aluno
UPDATE aluno_matriculado SET name=?, parent_name=?, bairro=?, curso=?, telefone=?, cep=?, birth_date=?, street=? 
WHERE id_aluno=?;

7️⃣ Excluir aluno
DELETE FROM aluno_matriculado WHERE id_aluno = ?;

8️⃣ Inserir aluno
INSERT INTO aluno_matriculado 
(name, parent_name, type_parent, bairro, cep, telefone, birth_date, street, curso)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);

9️⃣ Top 10 CEPs, Média de aluno por Bairro/Cep, Bairro/Curso com mais alunos, Média por curso, Total de alunos, alunos por curso/bairro, Idade dos alunos (Gráficos)

SELECT cep, COUNT(*) AS quantidade 
FROM aluno_matriculado
GROUP BY cep
ORDER BY quantidade DESC
LIMIT 10;

SELECT COUNT(*) AS total, curso FROM aluno_matriculado GROUP BY bairro; "Troca por CEP onde tiver bairro."

SELECT curso, COUNT(*) AS total FROM aluno_matriculado GROUP BY curso ORDER BY total DESC LIMIT 1; "Troca por Bairro onde tiver Curso"

SELECT COUNT(*) AS total, curso FROM aluno_matriculado GROUP BY curso;

SELECT COUNT(*) AS total FROM aluno_matriculado;

SELECT curso, COUNT(*) AS total FROM aluno_matriculado GROUP BY curso;

SELECT birth_date FROM aluno_matriculado WHERE birth_date IS NOT NULL AND birth_date <> '0000-00-00';

🔟 Buscar alunos de um curso específico
SELECT * FROM aluno_matriculado WHERE curso = 'Informática';

🛠️ Tecnologias Utilizadas

PHP 7+

MySQL

HTML5 / CSS3

Bootstrap (opcional)

Chart.js (para gráficos)

XAMPP / MariaDB

📦 Como executar o projeto

Clone o repositório:

git clone https://github.com/SEU-USUARIO/nome-do-repositorio.git


Importe o arquivo SQL no phpMyAdmin

Configure o arquivo conexao.php:

define('HOST', 'localhost');
define('USUARIO', 'root');
define('SENHA', '');
define('DB', 'login');


Inicie o servidor Apache/MySQL

Acesse pelo navegador:

http://localhost/seu-projeto/

👨‍🎓 Autor:
 - Heitor de Oliveira Almeida  
 - Desenvolvimento Web com Banco de Dados
