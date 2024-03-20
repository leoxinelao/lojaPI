<?php
session_start();
include_once('conexao.php');

if (isset($_POST['editar_produto'])) {
    $produto_id = $_POST['produto_id'];

    

    // Excluindo imagem antiga
    $query_excluir_imagens = "DELETE FROM imagens WHERE produto_id = :produto_id";
    $stmt_excluir_imagens = $conexao->prepare($query_excluir_imagens);
    $stmt_excluir_imagens->bindParam(':produto_id', $produto_id);
    $stmt_excluir_imagens->execute();

   
    if (!empty($_FILES['imagens']['name'][0])) {


    
        $diretorio = "imagens/$produto_id/";

        // Verifica se o diretório existe
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0755);
        }

        foreach ($_FILES['imagens']['tmp_name'] as $key => $tmp_name) {
            $nome_arquivo = $_FILES['imagens']['name'][$key];
            $extensao = pathinfo($nome_arquivo, PATHINFO_EXTENSION);
            $novonome_arquivo = uniqid() . '.' . $extensao;
            $caminho_completo = $diretorio . $novonome_arquivo;


            if (move_uploaded_file($tmp_name, $caminho_completo)) {
                // Insere o nome da imagem no banco de dados
                $query_inserir_imagem = "INSERT INTO imagens (nome_imagem, produto_id) VALUES (:nome_imagem, :produto_id)";
                $stmt_inserir_imagem = $conexao->prepare($query_inserir_imagem);
                $stmt_inserir_imagem->bindParam(':nome_imagem', $novonome_arquivo);
                $stmt_inserir_imagem->bindParam(':produto_id', $produto_id);
                $stmt_inserir_imagem->execute();
            }
        }
    }

    $_SESSION['msg'] = "<div class='alert alert-success'>Produto atualizado com sucesso!</div>";
    header("Location: listarProduto.php");
    exit();
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro ao processar a edição do produto!</div>";
    header("Location: editarProduto.php?id=$produto_id");
    exit();
}
?>