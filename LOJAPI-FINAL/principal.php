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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styleP.css">
    <title>Tela Principal</title>
</head>
<body>
<form action="logout.php" method="POST" style="margin-top: 20px;">
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    <div class="total">
    <div class="options">
        <h2><strong>Tela Principal</strong></h2>
        <?php
					if(isset($_SESSION['msg'])){
						echo $_SESSION['msg'];
						$_SESSION['msg'] = "";
					}					
				?>
    <a href="listarUsuario.php"><strong>Lista de Usuários</strong></a>
    <a href="listarProduto.php"><strong>Lista de Produtos</strong></a>
</div>
</div>
</body>
</html>