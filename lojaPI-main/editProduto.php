<?php
session_start();
    if(!empty($_GET['id'])){
        include_once('banco.php');
        //Coloca o id em uma variavel
        $id = $_GET['id'];
        //Pega os dados do banco de dados
        $sqlSelect = "SELECT * FROM produto WHERE id=$id";
        //Colocando os dados na variavel
        $result = $conexao->query($sqlSelect);


        //Verificando se foram pegos os dados (validação caso id invalido)
        if($result->num_rows > 0)
        {
            //Insere dados enquanto tem
            while($user_data = mysqli_fetch_assoc($result))
            {
                $nome = $user_data['nome'];           
                $avaliacao = $user_data['avaliacao'];
                $descricao = $user_data['descricao'];
                $preco = $user_data['preco'];
                $quantidade = $user_data['quantidade'];
            }
        }
        else
        {
            header('Location: listarProduto.php');
        }
    }
    else
    {
        header('Location: listarProduto.php');
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
        <form action="saveEditProduto.php" method="POST">
            <fieldset>
                <legend><b>Editar Produto</b></legend>
                <br>
                <div class="inputBox">    
                    <input type="text" name="nome" class="inputUser" value="<?php echo $nome;?>" required>
                    <label for="nome"class="labelInput">Nome</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="number" name="avaliacao" class="inputUser" value="<?php echo $avaliacao;?>" required>
                    <label for="avaliacao" class="labelInput">Avaliação</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="descricao" class="inputUser" value="<?php echo $descricao;?>" required>
                    <label for="descricao"class="labelInput">Descrição</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="number" name="preco" class="inputUser" value="<?php echo $preco;?>" required>
                    <label for="preco"class="labelInput">Preço</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="number" name="quantidade" class="inputUser" value="<?php echo $quantidade;?>" required>
                    <label for="quantidade"class="labelInput">Quantidade</label>
                </div>  
                <br><br>
                <input type="hidden" name="id" value=<?php echo $id;?>>
                <input type="submit" name="update" id="update">
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