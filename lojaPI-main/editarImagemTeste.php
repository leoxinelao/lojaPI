<?php
session_start();
include_once ('conexao.php');

// Verifica se o usuário tem permissão para editar produtos
if ($_SESSION['grupo'] !== 'Administrador') {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Você não tem permissão para editar produtos!</div>";
    header("Location: listarProduto.php");
    exit();
}

// Verifica se o ID do produto foi passado através da URL
if (!isset ($_GET['id']) || empty ($_GET['id'])) {
    $_SESSION['msg'] = "<div class='alert alert-danger'>ID de produto inválido!</div>";
    header("Location: listarProduto.php");
    exit();
}

// Recupera o ID do produto da URL
$produto_id = $_GET['id'];

// Consulta o banco de dados para obter detalhes do produto e suas imagens
$query_produto = "SELECT * FROM produto WHERE id = :produto_id";
$stmt_produto = $conexao->prepare($query_produto);
$stmt_produto->bindParam(':produto_id', $produto_id);
$stmt_produto->execute();
$produto = $stmt_produto->fetch();

$query_imagens = "SELECT * FROM imagens WHERE produto_id = :produto_id";
$stmt_imagens = $conexao->prepare($query_imagens);
$stmt_imagens->bindParam(':produto_id', $produto_id);
$stmt_imagens->execute();
$imagens = $stmt_imagens->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="css/stylesCadastro.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
</head>

<body>
<a href="listarProduto.php">Voltar</a>
<div class="box">
<form method="POST" action="processarEdicao.php" enctype="multipart/form-data">
    <fieldset>
    <legend><b>Editar Imagem</b></legend>
        <input type="hidden" name="produto_id" value="<?php echo $produto_id; ?>">
        <label for="imagens">Imagens:</label><br><br>
        <input type="file" name="imagens[]" multiple><br><br>

        <input type="submit" name="editar_produto" id="submit"value="Salvar Alterações">
    </form>
</fieldset>

</body>

</html>

