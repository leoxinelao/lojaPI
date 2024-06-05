<?php
    session_start();
    include_once('banco.php');
    // print_r($_SESSION);
    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
    {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: login.php');
    }
    $logado = $_SESSION['email'];

    $quantidade = 10;
    $pagina = ( isset($_GET['pagina']) ) ?(int)$_GET['pagina']:1;
    $inicio = ($quantidade * $pagina) - $quantidade;

    if(!empty($_GET['search']))
    {
        $data = $_GET['search'];
        $sql = "SELECT * FROM produto WHERE id LIKE '%$data%' or nome LIKE '%$data%' or quantidade LIKE '%$data%' ORDER BY id DESC LIMIT $inicio, $quantidade";
    }
    else
    {
        $sql = "SELECT * FROM produto ORDER BY id DESC LIMIT $inicio, $quantidade";
    }
    $result = $conexao->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/stylesLista.css">
    <title>Listar</title>
</head>

<body>
    <br><br>
    <?php
					if(isset($_SESSION['msg3'])){
						echo $_SESSION['msg3'];
						unset($_SESSION['msg3']);
					}					
				?>
    <div class="box-search">
        <form action="principal.php">
            <button class="btn btn-dark" type="submit">Voltar</button>
        </form>
        <input type="search" class="form-control w-25" placeholder="Pesquisar" id="pesquisar">
        <button onclick="searchData()" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search"
                viewBox="0 0 16 16">
                <path
                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
            </svg>
        </button>
    </div>
    <div class="m-5">
        <table class="table text-white table-bg">
            <thead>
                <tr>
                    <th scope="col">Codigo</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Quantidade</th>
                    <th scope="col">Preço</th>
                    <th scope="col">Status</th>
                    <th scope="col">Hab/des</th>
                    <th scope="col"><a class='btn btn-sm btn-success' href='cadastroProduto.php' title='Cadastro'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                                class='bi bi-plus' viewBox='0 0 16 16'>
                                <path
                                    d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4' />
                            </svg>
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                

                    while($user_data = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>".$user_data['id']."</td>";
                        echo "<td>".$user_data['nome']."</td>";
                        echo "<td>".$user_data['quantidade']."</td>";
                        echo "<td>".$user_data['preco'].",00"."</td>";
                        echo "<td>".$user_data['situacao']."</td>";
                        echo "<td>                   
                        <button onclick='modal(".$user_data['id'].")' class='btn custom-btn'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-repeat' viewBox=0 0 16 16'>
                        <path d='M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41m-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9'/>
                        <path fill-rule='evenodd' d='M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5 5 0 0 0 8 3M3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9z'/>
                      </svg></button>
                            </td>";
                        echo "<td>
                        <a class='btn btn-sm btn-primary' href='fachada.php?acao=editarProduto&id=$user_data[id]' title='Editar'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                            </svg>
                            </a>                            
                            <a class='btn btn-sm btn-warning' href='fachada.php?acao=editarImagem&id=$user_data[id]' title='EditarImagem'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-camera' viewBox='0 0 16 16'>
                            <path d='M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.827 3h2.344a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4z'/>
                            <path d='M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5m0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7M3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0'/>
                          </svg>
                            </a>                     
                            <a class='btn btn-sm btn-info' href='fachada.php?acao=visualizarProduto&id=$user_data[id]' title='Visualizar'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 0 16 16'>
                                <path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z'/>
                                <path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0'/>
                            </svg>
                                    </a>
                            <a class='btn btn-sm btn-danger' href='fachada.php?acao=deletarProduto&id=$user_data[id]' title='Deletar'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
  <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z'/>
  <path d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z'/>
</svg>
                                    </a>                                
                                </td>";
                        echo "</tr>";
                    }
                    ?>
            </tbody>
        </table>
    </div>
    <ul class="pagination justify-content-center">
        <?php

        $sqlTotal = "SELECT id FROM produto";
        $qrTotal = mysqli_query($conexao,$sqlTotal) or die(mysqli_error($conexao));
        $numTotal = mysqli_num_rows($qrTotal);

        $totalPagina = ceil($numTotal / $quantidade);



        echo '<li class="page-item"><a class="page-link bg-primary text-white" href="?menuop=contatos&pagina=1">Primeira Pagina</a></li>';

        if($pagina>6){
            ?>
        <li class="page-item"><a class="page-link bg-primary text-white"
                href="?menuop=contatos&pagina=<?php echo $pagina-1?>">
                <<< /a>
        </li>
        <?php
        }


        for($i=1;$i<=$totalPagina;$i++){
            
           if($i>=($pagina-5) && $i <= ($pagina+5)){
            if($i==$pagina){
                echo "<li class='page-item active'><span class='page-link bg-primary text-white'>$i</span></li>";
            }else{
                echo "<li class='page-item'><a class='page-link bg-primary text-white' href=\"?menuop=contatos&pagina={$i}\"> {$i} </a></li>";

            }
           }
        }

        if($pagina<$totalPagina-5){
            ?>
        <li class="page-item"><a class="page-link bg-primary text-white"
                href="?menuop=contatos&pagina=<?php echo $pagina+1?>">>></a></li>
        <?php
        }
        echo "<li class='page-item'> <a class='page-link bg-primary text-white' href=\"?menuop=contatos&pagina=$totalPagina\">Ultima Pagina</a></li>";


?>
    </ul>
</body>
<script>
var search = document.getElementById('pesquisar');

search.addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        searchData();
    }
});

function searchData() {
    window.location = 'listarProduto.php?search=' + search.value;
}

function modal(userId) {
    var r = confirm("Tem certeza que deseja mudar o status do usuário?");
    if (r == true) {
        window.location.href = "inverteStatusProduto.php?id=" + encodeURIComponent(userId);
    } else {

    }
}
</script>

</html>