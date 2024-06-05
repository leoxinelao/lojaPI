<?php

    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'cadastro';


    try {
    
        //Conexão sem a porta
        $conexao = new PDO("mysql:host=$dbHost;dbname=" . $dbName, $dbUsername, $dbPassword);

    } catch (PDOException $err) {
        echo "Erro: Conexão com banco de dados não realizado com sucesso. Erro gerado " . $err->getMessage();
    }   

?>