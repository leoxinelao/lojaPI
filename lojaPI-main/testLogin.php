<?php
    session_start();
if(isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha']))
{
    // Acessa
    include_once('banco.php');
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conexao->query($sql);
    $row = $result->fetch_assoc();

    $situacao = $row['situacao'];
    if(mysqli_num_rows($result) < 1){
        $_SESSION['msg'] = "<div class='alert alert-danger'>Login ou senha incorreto!</div>";
        header('Location: login.php');
    } else {

        if($situacao == "Inativo"){
            $_SESSION['msg'] = "<div class='alert alert-danger'>Usuário Inativo!";
            header('Location: login.php');
        } else{
            if(password_verify($senha, $row['senha'])){
                $_SESSION['grupo'] = $row['grupo'];
                $_SESSION['email'] = $email;
                $_SESSION['senha'] = $senha;
                header('Location: principal.php');
            }else{
    
            $_SESSION['msg'] = "<div class='alert alert-danger'>Login ou senha incorreto!</div>";
            header('Location: login.php'); 
            }
        }
    }
    
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Login ou senha incorreto!</div>";
    header('Location: login.php');
}
?>