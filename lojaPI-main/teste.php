<?php


if(isset($_POST['email'])){
    // Acessa
    include_once('config.php');
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $situacao = "Ativo";
    $texto = "senha certa";
    $texto2 = "senha errada";
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";

    $result = $conexao->query($sql);
    
    $row = $result->fetch_assoc();
    if(password_verify($senha, $row['senha'])){
        print_r($texto);
    } else {
        print_r($texto2);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <form action="" method="POST">
    <input type="text" name="email"><br>
    <input type="password" name="senha"><br>
    <button type ="submit">LOGAL</button>
</form>
</head>
<body>
    
</body>
</html>