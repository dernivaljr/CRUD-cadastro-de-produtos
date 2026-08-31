<?php
// Conexão com o banco de dados
include 'conexao.php';

//Setando as variáveis com os valores do formulário
$usuario = $_POST['txt_usuario'];
$email = $_POST['txt_email'];
$senha = $_POST['txt_senha'];

$sql = mysql_query("SELECT * FROM tb_login WHERE (usuario='$usuario' OR email='$email') AND senha='$senha'") or die(mysql_error());

//Verificar se usuario ou email já existe
if (mysql_num_rows($sql) > 0) {
        
    echo "<h2>Bem-vindo, $usuario!</h2>";
    echo "<p>Seu email é: $email</p>";
} else {
    // Ir para a página de cadastro
        header("Location: cadastro_contas.html");
    }
?>