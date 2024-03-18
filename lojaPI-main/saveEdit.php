<?php

    include_once('config.php');

    if(isset($_POST['update'])){

    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $grupo = $_POST['grupo'];
    $senha = $_POST['senha'];
    
    $sqlInsert = "UPDATE usuarios SET nome='$nome',senha='$senha',cpf='$cpf',grupo='$grupo',senha='$senha' WHERE id=$id";

    $result = $conexao->query($sqlInsert);

    print_r($result);
}
header('Location: principal.php');

?>