<?php

require_once 'fachada.php';

if (isset($_GET['acao']) && isset($_GET['id'])) {
    $acao = $_GET['acao'];
    $idProduto = $_GET['id'];

    switch ($acao) {
        case 'deletarProduto':
                header("Location: deletarProduto.php?id=" . urlencode($idProduto));
            break;
        case 'editarProduto':
                header("Location: editProduto.php?id=" . urlencode($idProduto));
            break;
        case 'editarImagem':
                header("Location: editarImagemTeste.php?id=" . urlencode($idProduto));
            break;
        case 'visualizarProduto':
                header("Location: visualizarProduto.php?id=" . urlencode($idProduto));
            break;    
    }
} else {
    echo "Ação ou ID do produto não fornecidos.";
}
?>