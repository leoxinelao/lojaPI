<?php
session_start();
    if(isset($_POST['submit'])){
        include_once('banco.php');



        if(!empty($_POST['senha']) && !empty($_POST['senha2'])) {
            // Obtém os valores dos campos
            $senha = $_POST['senha'];
            $senha2 = $_POST['senha2'];
            
            // Verifica se as senhas são diferentes
            if($senha !== $senha2) {
                // Define uma mensagem de erro
                $_SESSION['msg'] = "<div class='alert alert-danger'>As senhas não coincidem!</div>";
    
                // Redireciona de volta para o formulário
                header('Location: cadastroUsuario.php');
                exit(); // Certifique-se de sair após redirecionar
            } else {
                $_SESSION['msg'] = "<div class='alerta'>Cadastro realizado com sucesso!</div>";
                $nome = $_POST['nome'];
                $email = $_POST['email'];
                $cpf = $_POST['cpf'];
                $grupo = $_POST['grupo'];
                $situacao = 'Ativo';

                $senha_cripto = password_hash($senha, PASSWORD_DEFAULT);


                $result = mysqli_query($conexao, "INSERT INTO usuarios(nome,email,cpf,grupo,senha,situacao) VALUES ('$nome','$email','$cpf','$grupo','$senha_cripto','$situacao')");
                header('Location: cadastroUsuario.php');
                exit(); // Certifique-se de sair após redirecionar
            }
        }
       
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
<form action="listarUsuario.php">
        <button class="btn btn-dark" type="submit">Voltar</button>
    </form>
    <div class="box">
        <form action="cadastroUsuario.php" method="POST">
            <fieldset>
                <legend><b>Cadastro</b></legend>
                <br>
                <div class="inputBox">
                    <input type="text" name="nome" class="inputUser" required>
                    <label for="nome"class="labelInput">Nome</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="email" name="email" class="inputUser" required>
                    <label for="email"class="labelInput">Email</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="cpf" class="inputUser" pattern="\d{11}" maxlength="11" title="CPF deve conter 11 dígitos">
                    <label for="cpf" class="labelInput">CPF</label>
                </div>
                <br><br>
                <p>Grupo:</p>
                <input type="radio" id="administrador"name="grupo" value="Administrador" required>
                <label for="administrador">Administrador</label>
                <br>
                <input type="radio" id="estoquista"name="grupo" value="Estoquista" required>
                <label for="estoquista">Estoquista</label>
                <br><br>
                <br><br>
                <div class="inputBox">
                    <input type="password" name="senha" class="inputUser" required>
                    <label for="senha"class="labelInput">Senha</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="password" name="senha2" class="inputUser" required>
                    <label for="senha2"class="labelInput">Confirmar Senha</label>
                </div>
                <br><br>
                <input type="submit" name="submit" id="submit">
                <br><br>
                <?php
					if(isset($_SESSION['msg'])){
						echo $_SESSION['msg'];
						$_SESSION['msg'] = "";
					}					
				?>
            </fieldset>
        </form>
    </div>
</body>
</html>