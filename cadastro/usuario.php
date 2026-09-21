<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    $usuario = $_POST['txt_usuario'];
    $email = $_POST['txt_email'];
    
    ?>
    <title><?php echo $usuario; ?></title>
</head>
<body>
    <h2>Bem-vindo, <?php echo $usuario; ?>!</h2>
    <p>Seu email é: <?php echo $email; ?></p>
</body>
</html>