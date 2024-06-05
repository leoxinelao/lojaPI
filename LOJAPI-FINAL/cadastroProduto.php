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
        
        if (count($_FILES['imagens']['name']) < 5) {
            $_SESSION['msg5'] = "<p style='color: #f00;'>Erro: É necessário enviar no mínimo 5 imagens!</p>";
            header('Location: cadastroProduto.php');
            exit(); 
        }

        
        //  cadastrar usuário no banco de dados
        $query_produto = "INSERT INTO produto (nome, avaliacao, descricao, preco, quantidade,situacao) VALUES (:nome, :avaliacao, :descricao, :preco, :quantidade, :situacao)";

    
        $cad_produto = $conexao->prepare($query_produto);

        
        $cad_produto->bindParam(':nome', $dados['nome']);
        $cad_produto->bindParam(':avaliacao', $dados['avaliacao']);
        $cad_produto->bindParam(':descricao', $dados['descricao']);
        $cad_produto->bindParam(':preco', $dados['preco']);
        $cad_produto->bindParam(':quantidade', $dados['quantidade']);
        $situacao = 'Ativo';
        $cad_produto->bindParam(':situacao', $situacao);

       
        $cad_produto->execute();

        
        if ($cad_produto->rowCount()) {

         
            $produto_id = $conexao->lastInsertId();


            $diretorio = "imagens/$produto_id/";

            mkdir($diretorio, 0755);

 
            $arquivo = $_FILES['imagens'];

            for ($cont = 0; $cont < count($arquivo['name']); $cont++) {


                $nome_arquivo = $arquivo['name'][$cont];
                

                $extensao = strtolower(pathinfo($nome_arquivo, PATHINFO_EXTENSION));
                $extensao2 = ".".$extensao;
                $novonome_arquivo = uniqid() . $extensao2;

                if (move_uploaded_file($arquivo['tmp_name'][$cont], $diretorio . $novonome_arquivo)) {
                    $query_imagem = "INSERT INTO imagens (nome_imagem, produto_id) VALUES (:nome_imagem, :produto_id)";
                    $cad_imagem = $conexao->prepare($query_imagem);
                    $cad_imagem->bindParam(':nome_imagem', $novonome_arquivo);
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
        exit();
    }
    ?>
    <form action="listarProduto.php">
        <button class="btn btn-dark" type="submit">Voltar</button>
    </form>
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
                    <input type="file" name="imagens[]" class="inputUser"  multiple="multiple"required>
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
    <script>
        document.getElementById('imageForm').addEventListener('submit', function(event) {
            var input = document.getElementById('imagens');
            var errorDiv = document.getElementById('error');
            errorDiv.textContent = '';

            if (input.files.length < 5) {
                event.preventDefault();
                errorDiv.textContent = 'Por favor, selecione pelo menos 5 imagens.';
            }
        });
    </script>
</body>
</html>