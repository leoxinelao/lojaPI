<?php

    include_once('banco.php');

    if(isset($_POST['update'])){

    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $avaliacao = $_POST['avaliacao'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    
    $sqlInsert = "UPDATE produto SET nome='$nome',avaliacao='$avaliacao',descricao='$descricao',preco='$preco',quantidade='$quantidade' WHERE id=$id";

    $result = $conexao->query($sqlInsert);
    $_SESSION['msg'] = "<div class='alerta'>Cadastro realizado com sucesso!</div>";

    header('Location: editProduto.php');
}

?>