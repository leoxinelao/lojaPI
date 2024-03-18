<?php
    session_start();

    if(!empty($_GET['id'])){

        include_once('config.php');

        //Coloca o id em uma variavel
        $id = $_GET['id'];
        //Pega os dados do banco de dados
        $sqlSelect = "SELECT situacao FROM usuarios WHERE id=$id";
        //Colocando os dados na variavel
        $result = $conexao->query($sqlSelect);




    }

?>