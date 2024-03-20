<?php

session_start(); 
include_once('conexao.php');

if ($_SESSION['grupo'] !== 'Administrador') {

    $_SESSION['msg3'] = "<div class='alert alert-danger'>Você não tem permissão para cadastrar um produto!!</div>";
    header("Location: listarProduto.php");
    exit();
}

?>       

<!DOCTYPE html>
<html lang="en">
<head>
    
    <link rel="stylesheet" type="text/css" href="css/stylesCadastro.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>
<body>
<?php
        
        
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($dados['SendCadUser'])) {

        // QUERY cadastrar usuário no banco de dados
        $query_produto = "INSERT INTO produto (nome, avaliacao, descricao, preco, quantidade,situacao) VALUES (:nome, :avaliacao, :descricao, :preco, :quantidade, :situacao)";

        // Preparar a QUERY
        $cad_produto = $conexao->prepare($query_produto);

        // Substituir os links pelos valores do formulário
        $cad_produto->bindParam(':nome', $dados['nome']);
        $cad_produto->bindParam(':avaliacao', $dados['avaliacao']);
        $cad_produto->bindParam(':descricao', $dados['descricao']);
        $cad_produto->bindParam(':preco', $dados['preco']);
        $cad_produto->bindParam(':quantidade', $dados['quantidade']);
        $situacao = 'Ativo';
        $cad_produto->bindParam(':situacao', $situacao);

        // Executar a QUERY
        $cad_produto->execute();

        // Acessa o IF quando cadastrar o usuário no BD
        if ($cad_produto->rowCount()) {

            // Receber o id do registro cadastrado
            $produto_id = $conexao->lastInsertId();

            // Endereço do diretório
            $diretorio = "imagens/$produto_id/";

            // Criar o diretório
            mkdir($diretorio, 0755);

            // Receber os arquivos do formulário
            $arquivo = $_FILES['imagens'];
            //var_dump($arquivo);

            // Ler o array de arquivos
            for ($cont = 0; $cont < count($arquivo['name']); $cont++) {

                // Receber nome da imagem
                $nome_arquivo = $arquivo['name'][$cont];

                // Criar o endereço de destino das imagens
                $destino = $diretorio . $arquivo['name'][$cont];

                // Acessa o IF quando realizar o upload corretamente
                if (move_uploaded_file($arquivo['tmp_name'][$cont], $destino)) {
                    $query_imagem = "INSERT INTO imagens (nome_imagem, produto_id) VALUES (:nome_imagem, :produto_id)";
                    $cad_imagem = $conexao->prepare($query_imagem);
                    $cad_imagem->bindParam(':nome_imagem', $nome_arquivo);
                    $cad_imagem->bindParam(':produto_id', $produto_id);

                    if ($cad_imagem->execute()) {
                        $_SESSION['msg5'] = "<div class='alerta'>Cadastro realizado com sucesso!</div>";
                        header('Location: cadastroProduto.php');
                    } else {
                        $_SESSION['msg5'] = "<p style='color: #f00;'>Erro: Imagem não cadastrada com sucesso!</p>";
                    }
                } else {
                    $_SESSION['msg5'] = "<p style='color: #f00;'>Erro: Imagem não cadastrada com sucesso!</p>";
                }
            }
        } else {
            $_SESSION['msg5'] = "<p style='color: #f00;'>Erro: Usuário não cadastrado com sucesso!</p>";
        }
    }
    ?>
    <a href="listarProduto.php">Voltar</a>
    <div class="box">
    <form method="POST" action="" enctype="multipart/form-data">
            <fieldset>
                <legend><b>Cadastro de Produtos</b></legend>
                <br>
                <div class="inputBox">
                    <input type="text" name="nome" class="inputUser" required>
                    <label for="nome"class="labelInput">Nome</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="number" name="avaliacao" class="inputUser" min="1.0" max="5.0" step="0.5" required>
                    <label for="avaliacao"class="labelInput">Avaliação</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="descricao" class="inputUser" required>
                    <label for="descricao" class="labelInput">Descrição</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="number" name="preco" class="inputUser" required>
                    <label for="preco"class="labelInput">Preço</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="number" name="quantidade" class="inputUser" required>
                    <label for="quantidade"class="labelInput">Quantidade</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <label for="imagens"class="labelInput">Imagens</label>
                    <br>
                    <input type="file" name="imagens[]" class="inputUser"  multiple="multiple" required>
                </div>
                <br><br>
                <input type="submit" name="SendCadUser" id="submit">
                <br><br>
                <?php
					if(isset($_SESSION['msg5'])){
						echo $_SESSION['msg5'];
                        unset($_SESSION['msg5']);
					}					
				?>
            </fieldset>
        </form>
    </div>
</body>
</html>