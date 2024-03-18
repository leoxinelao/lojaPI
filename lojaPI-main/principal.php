<?php
    session_start();
    //print_r($_SESSION);

    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
    {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: login.php');
    }
    $logado = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleP.css">
    <title>Tela Principal</title>
</head>
<body>
    <div class="total">
    <div class="options">
        <h2><strong>Tela Principal</strong></h2>
    <a href="listarUsuario.php"><strong>Lista de Usuários</strong></a>
    <a href="listarProduto.php"><strong>Lista de Produtos</strong></a>
    <a href=""><strong>Listar de Pedidos</strong></a>
</div>
</div>
</body>
</html>