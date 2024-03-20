<?php
    if(isset($_POST['submit'])){
        include_once('config.php');

        print_r($_POST['nome']);
        print_r($_POST['cpf']);
        print_r($_POST['email']);
        print_r($_POST['grupo']);
        print_r($_POST['senha']);

        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $cpf = $_POST['cpf'];
        $grupo = $_POST['grupo'];
        $senha = $_POST['senha'];

        $result = mysqli_query($conexao, "INSERT INTO usuarios(nome,email,cpf,grupo,senha) VALUES ('$nome','$email','$cpf','$grupo','$senha')");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>
<body>
    <div class="box">
        <form action="formulario.php" method="POST">
            <fieldset>
                <legend><b>Cadastro</b></legend>
                <br>
                <div class="inputBox">
                    <input type="text" name="nome" class="inputUser" required>
                    <label for="nome"class="labelInput">Nome</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="email" class="inputUser" required>
                    <label for="email"class="labelInput">Email</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="cpf" class="inputUser" required>
                    <label for="cpf" class="labelInput">CPF</label>
                </div>
                <br><br>
                <p>Grupo:</p>
                <input type="radio" id="administrador"name="grupo" value="administrador" required>
                <label for="administrador">Administrador</label>
                <br>
                <input type="radio" id="estoquista"name="grupo" value="estoquista" required>
                <label for="estoquista">Estoquista</label>
                <br><br>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="senha" class="inputUser" required>
                    <label for="senha"class="labelInput">Senha</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="senha2" class="inputUser" required>
                    <label for="senha2"class="labelInput">Confirmar Senha</label>
                </div>
                <br><br>
                <input type="submit" name="submit" id="submit">
            </fieldset>
        </form>
    </div>
</body>
</html>