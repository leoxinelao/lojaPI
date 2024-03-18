<?php
    session_start();
if(isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha']))
{
    // Acessa
    include_once('config.php');
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $situacao = "Ativo";
    // print_r('Email: ' . $email);
    // print_r('<br>');
    // print_r('Senha: ' . $senha);

    $sql = "SELECT * FROM usuarios WHERE email = '$email' and senha = '$senha' and situacao = '$situacao'";

    $result = $conexao->query($sql);

    if(mysqli_num_rows($result) < 1)
    {
        
        $_SESSION['msg'] = "<div class='alert alert-danger'>Login ou senha incorreto!</div>";
        header('Location: login.php');
    }
    else
    {
        $_SESSION['email'] = $email;
        $_SESSION['senha'] = $senha;
        header('Location: principal.php');
    }
}
else
{
    // Não acessa
    header('Location: login.php');
}
?>