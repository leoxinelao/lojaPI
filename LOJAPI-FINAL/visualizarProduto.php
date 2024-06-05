<?php
session_start();
ob_start();

include_once "conexao.php";

if ($_SESSION['grupo'] !== 'Administrador') {

    $_SESSION['msg3'] = "<div class='alert alert-danger'>Você não tem permissão para visualizar o produto!!</div>";
    header("Location: listarProduto.php");
    exit();
}

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty ($id)) {
    $query_produto = "SELECT id, nome, avaliacao, descricao, preco, quantidade FROM produto WHERE id=:id LIMIT 1";
    $result_produto = $conexao->prepare($query_produto);
    $result_produto->bindParam(':id', $id);
    $result_produto->execute();

    $produto = $result_produto->fetch();

    if ($produto) {
        extract($produto);

        $query_imagens = "SELECT nome_imagem FROM imagens WHERE produto_id=:id";
        $result_imagens = $conexao->prepare($query_imagens);
        $result_imagens->bindParam(':id', $id);
        $result_imagens->execute();

        // Inicializa um array para armazenar os nomes das imagens
        $imagens = array();

        if ($result_imagens->rowCount() > 0) {
            while ($imagem = $result_imagens->fetch()) {
                // Adiciona cada nome de imagem ao array
                $imagens[] = $imagem['nome_imagem'];
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stylesProdFinal.css">
    <title>Visualizar Produto</title>
</head>
<input type="hidden" id="quantidade" value="<?php echo $quantidade; ?>">
<body>
<form action="listarProduto.php">
        <button class="bota" type="submit">Voltar</button>
    </form>
    <main>
        <section>
            <div class="container">
                <div class="left-side">
                    <div class="items">

                        <?php $primeiraImagem = true; ?>
                        <?php foreach($imagens as $imagem): ?>
                        <?php if ($primeiraImagem): ?>
                        <div class="select-image">
                            <img id="mainImage" src="imagens/<?php echo $id.'/'.$imagem; ?>"
                                onclick="changeImage(this)">
                        </div>
                        <?php $primeiraImagem = false; ?>
                        <?php endif; ?>
                        <?php endforeach; ?>

                        <div class="thumbnails">
                            <?php foreach($imagens as $imagem): ?>
                            <div class="thumbnail">
                                <img src="imagens/<?php echo $id.'/'.$imagem; ?>" onclick="changeImage(this)">
                            </div>
                            <?php endforeach; ?>
                        </div>

                    </div>
                </div>
                <div class="right-side">
                <h3 class="texto"><?php echo $nome ?> <br></h3>
                    <div class="content">
        
                        <h4>Avaliação: <?php echo $avaliacao ?><br></h4>
                        <p>Descrição: <?php echo $descricao ?> <br></p>
                        <span class='price'>Preço: R$<?php echo $preco ?>,00</span>
                        <span> Quantidade: <?php echo $quantidade ?></span> <br>
                       
                        <div class="options">
                            <div class="amount">
                                <div class="minus">
                                    <img src="">
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-plus" viewBox="0 0 16 16" onclick="increaseQuantity()">
                                    <path
                                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                </svg>
                                <span id="quantity">0</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-dash" viewBox="0 0 16 16" onclick="decreaseQuantity()">
                                    <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8" />
                                </svg>
                                <div class="plus">
                                </div>
                            </div>
                            <a href="" class="button"><img src="">Adicionar ao carrinho</a>
                        </div>
                    </div>

                </div>
            </div>


        </section>
    </main>
    <script>
    function changeImage(thumbnail) {
        var mainImage = document.getElementById("mainImage");
        mainImage.src = thumbnail.src;
    }

    function increaseQuantity() {
        var quantitySpan = document.getElementById("quantity");
        var currentQuantity = parseInt(quantitySpan.innerText);
        var maxQuantity = parseInt(document.getElementById("quantidade").value);

        if (currentQuantity < maxQuantity) {
            quantitySpan.innerText = currentQuantity + 1;
        } else {
            alert("Quantidade máxima atingida!");
        }
    }

    function decreaseQuantity() {
        var quantitySpan = document.getElementById("quantity");
        var currentQuantity = parseInt(quantitySpan.innerText);

        if (currentQuantity > 0) {
            quantitySpan.innerText = currentQuantity - 1;
        }
    }
    </script>
</body>

</html>
