<?php
session_start();
    if(!empty($_GET['id'])){
        include_once('config.php');
        //Coloca o id em uma variavel
        $id = $_GET['id'];
        //Pega os dados do banco de dados
        $sqlSelect = "SELECT * FROM usuarios WHERE id=$id";
        //Colocando os dados na variavel
        $result = $conexao->query($sqlSelect);


        //Verificando se foram pegos os dados (validação caso id invalido)
        if($result->num_rows > 0)
        {
            //Insere dados enquanto tem
            while($user_data = mysqli_fetch_assoc($result))
            {
                $nome = $user_data['nome'];
                $email = $user_data['email'];
                $cpf = $user_data['cpf'];
                $grupo = $user_data['grupo'];
                $senha = $user_data['senha'];
            }
        }
        else
        {
            header('Location: principal.php');
        }
    }
    else
    {
        header('Location: principal.php');
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
    <a href="principal.php">Voltar</a>
    <div class="box">
        <form action="formulario.php" method="POST">
            <fieldset>
                <legend><b>Cadastro</b></legend>
                <br>
                <div class="inputBox">
                    <input type="text" name="nome" class="inputUser" value="<?php echo $nome?>" required>
                    <label for="nome"class="labelInput">Nome</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <label for="email"class="labelInput"><?php echo $email?></label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="cpf" class="inputUser" value="<?php echo $cpf?>" required>
                    <label for="cpf" class="labelInput">CPF</label>
                </div>
                <br><br>
                <p>Grupo:</p>
                <input type="radio" id="administrador"name="grupo" value="Administrador" <?php echo ($grupo == 'Administrador') ? 'checked' : '';?> required>
                <label for="administrador">Administrador</label>
                <br>
                <input type="radio" id="estoquista"name="grupo" value="Estoquista" <?php echo ($grupo == 'Estoquista') ? 'checked' : '';?> required>
                <label for="estoquista">Estoquista</label>
                <br><br>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="senha" class="inputUser" value="<?php echo $senha?>" required>
                    <label for="senha"class="labelInput">Senha</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="senha2" class="inputUser" required>
                    <label for="senha2"class="labelInput">Confirmar Senha</label>
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