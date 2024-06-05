<?php
    session_start();

    if ($_SESSION['grupo'] !== 'Administrador') {

        $_SESSION['msg'] = "<div class='alert alert-danger'>Você não tem permissão para inativar ou ativar um produto!!</div>";
        header("Location: listarUsuario.php");
        exit();
    }

    if(!empty($_GET['id'])){

        include_once('banco.php');

        //Coloca o id em uma variavel
        $id = $_GET['id'];
        //Pega os dados do banco de dados
        $sqlSelect = "SELECT situacao FROM usuarios WHERE id=$id";
        //Colocando os dados na variavel
        $result = $conexao->query($sqlSelect);

        if($result->num_rows > 0)
        {
            //Insere dados enquanto tem
            while($user_data = mysqli_fetch_assoc($result))
            {
                $situacao = $user_data['situacao'];           
            }

            if($situacao == 'Ativo'){
                $situacao = 'Inativo';
            }else{
                $situacao = 'Ativo';
            }

            $sqlInsert = "UPDATE usuarios SET situacao='$situacao' WHERE id=$id";

            $result = $conexao->query($sqlInsert);

            print_r($result);
            header('Location: listarUsuario.php');
        }
        else
        {
            header('Location: listarUsuario.php');
        }
    }
    else
    {
        header('Location: listarUsuario.php');
    }



?>