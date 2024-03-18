<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleLogin.css">
    <title>Document</title>
</head>
<body>
    <div class = "main-login">
    <div class = left-login>

        <h1>Faça login<br>E entre no nosso time</h1>
        <img src="../pantarma.svg" class="left-login-image" alt="">
    </div>
    <form action="testLogin.php" method="POST">
  <div class = "right-login">
<div class = "card-login">
    <h1>LOGIN</h1>

<div class = "textfield">
<label for="usuario"> Usuario</label>
<input type="text" name ="email" placeholder="Email" required>
</div>
<div class="textfield">
<label for="senha">Usuario</label>
<input type = "password" name = "senha" placeholder="Senha" required>
</div>
<input class="inputSubmit" type="submit" name="submit" value="Logar">
<?php
					if(isset($_SESSION['msg'])){
						echo $_SESSION['msg'];
						unset($_SESSION['msg']);
					}					
				?>
</div>

  </div>
    </div>
    </form>
</body>
</html>