<?php

session_start();


include_once "conexao.php";

if ($_SESSION['grupo'] !== 'Administrador') {

    $_SESSION['msg3'] = "<div class='alert alert-danger'>Você não tem permissão para editar imagens!!</div>";
    header("Location: listarProduto.php");
    exit();
}


$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);


if (empty($id)) {
    $_SESSION['msg3'] = "<div class='alerta'>Usuario não encontrado!</div>";
    header("Location: listarProduto.php");
} else {
    // QUERY para recuperar os dados do registro
    $query_usuario = "SELECT id, nome_imagem FROM imagens WHERE id=:id LIMIT 1";
    $result_usuario = $conexao->prepare($query_usuario);
    $result_usuario->bindParam(':id', $id, PDO::PARAM_INT);
    $result_usuario->execute();


    if (($result_usuario) and ($result_usuario->rowCount() != 0)) {
        $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);

    } else {
        $_SESSION['msg3'] = "<div class='alerta'>Usuario não encontrado!</div>";
        header("Location: listarProduto.php");
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar foto</title>
</head>

<body>    
    <h2>Editar Foto</h2>

    <?php
    // Receber os dados do formulario
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);    

    // Verificar se o usuario clicou no botao
    if(!empty($dados['EditarFoto'])){
        // Receber a foto
        $arquivo = $_FILES['nome_imagem'];
        //var_dump($arquivo);
        // Verificar se o usuario esta enviando a foto
        if((isset($arquivo['name'])) and (!empty($arquivo['name']))){
            // Criar a QUERY editar no banco de dados
            $query_edit_usuario = "UPDATE imagens SET nome_imagem=:nome_imagem WHERE id=:id";
            $edit_usuario = $conexao->prepare($query_edit_usuario);
            $edit_usuario->bindParam(':nome_imagem', $arquivo['name'], PDO::PARAM_STR);
            $edit_usuario->bindParam(':id', $id, PDO::PARAM_INT);

            // Verificar se editou com sucesso
            if($edit_usuario->execute()){
                // Diretorio onde o arquivo sera salvo
                $diretorio = "imagens/$id/";

                // Verificar se o diretorio existe
                if((!file_exists($diretorio)) and (!is_dir($diretorio))){
                    // Criar o diretorio
                    mkdir($diretorio, 0755);
                }

                // Upload do arquivo
                $nome_arquivo = $arquivo['name'];
                if(move_uploaded_file($arquivo['tmp_name'], $diretorio . $nome_arquivo)){
                    // Verificar se existe o nome da imagem salva no banco de dados e o nome da imagem salva no banco de dados he diferente do nome da imagem que o usuario esta enviando
                    if(((!empty($row_usuario['nome_imagem'])) or ($row_usuario['nome_imagem'] != null)) and ($row_usuario['nome_imagem'] != $arquivo['name'])){
                        $endereco_imagem = "imagens/$id/". $row_usuario['nome_imagem'];
                        if(file_exists($endereco_imagem)){
                            unlink($endereco_imagem);
                        }
                    }

                    $_SESSION['msg3'] = "<p style='color: green;'>Foto editada com sucesso!</p>";
                    header("Location: listarProduto.php");
                }else{
                    echo "<p style='color: #f00;'>Erro: Usuário não editado com sucesso!</p>";
                }
            }else{
                echo "<p style='color: #f00;'>Erro: Usuário não editado com sucesso!</p>";
            }
        }else{
            echo "<p style='color: #f00;'>Erro: Necessário selecionar uma imagem!</p>";
        }
    }
    ?>

    <form name="edit_foto" method="POST" action="" enctype="multipart/form-data">
        <label>Foto: </label>
        <input type="file" name="nome_imagem" id="nome_imagem"><br><br>

        <input type="submit" value="Salvar" name="EditarFoto">

    </form>


</body>

</html>