<?php
// Conexão com o banco de dados
include 'conexao.php';

//Setando as variáveis com os valores do formulário
$usuario = $_POST['txt_usuario'];
$email = $_POST['txt_email'];
$senha = $_POST['txt_senha'];

$sql = mysql_query("SELECT * FROM tb_login WHERE usuario='$usuario' OR email='$email'");

//Verificar se usuario ou email já existe
if (mysql_num_rows($sql) > 0) {
    echo "Usuário ou email já cadastrado!";
} else {
    // Inserir novo usuário
    $sql = mysql_query("INSERT INTO tb_login (usuario, email, senha) VALUES ('$usuario', '$email', '$senha')");
    if ($sql) {
        echo "<html lang='pt-br'>";
        echo "<h2>";
        echo "Usuário cadastrado com sucesso!";
        echo "</h2>";
        echo "</html>";
    } else {
        echo "<html lang='pt-br'>";
        echo "<h2>";
        echo "Erro ao cadastrar usuário!";
        echo "</h2>";
        echo "</html>";
    }
}
?>