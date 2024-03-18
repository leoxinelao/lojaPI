<?php
session_start();
    if(isset($_POST['submit'])){
        include_once('config.php');
          
        $nome = $_POST['nome'];
        $avaliacao = $_POST['avaliacao'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];
        $quantidade = $_POST['quantidade'];
        $situacao = 'Ativo';

        $result = mysqli_query($conexao, "INSERT INTO produto(nome_prod,avaliacao,descricao,preco,quantidade,situacao) VALUES ('$nome','$avaliacao','$descricao','$preco','$quantidade','$situacao')");
        $_SESSION['msg'] = "<div class='alert alert-success'>Cadastro realizado com sucesso!</div>";
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
    <a href="listarProduto.php">Voltar</a>
    <div class="box">
        <form action="cadastroProduto.php" method="POST">
            <fieldset>
                <legend><b>Cadastro de Produtos</b></legend>
                <br>
                <div class="inputBox">
                    <input type="text" name="nome" class="inputUser" required>
                    <label for="nome"class="labelInput">Nome</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="avaliacao" class="inputUser" required>
                    <label for="avaliacao"class="labelInput">Avaliação</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="descricao" class="inputUser" required>
                    <label for="descricao" class="labelInput">Descrição</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="preco" class="inputUser" required>
                    <label for="preco"class="labelInput">Preço</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="quantidade" class="inputUser" required>
                    <label for="quantidade"class="labelInput">Quantidade</label>
                </div>
                <br><br>
                <input type="submit" name="submit" id="submit">
                <br><br>
                <?php
					if(isset($_SESSION['msg'])){
						echo $_SESSION['msg'];
						unset($_SESSION['msg']);
					}					
				?>
            </fieldset>
        </form>
    </div>
</body>
</html>