<!DOCTYPE html>
<?php
if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION['acesso'] == true) {
?>
<html>

<head>
    <?php
    include_once "header.html";
    include_once "../mais/conexao.php";
    include_once "../mais/funcoes.php";
    ?>
    <title>Cadastra filme ADM</title>
</head>

<body class="adm">
    <!-- MENU SUPERIOR -->
    <?php include_once "menuSuperior.html" ?>
    <!-- //MENU SUPERIOR -->

    <!-- PRINCIPAL -->
    <main class="container mt-5">
        <h3 class="text-center">Cadastro de Filmes - Administração</h3>
        <div class="row gy-4 mt-4">
            <!-- MENU LATERAL -->
            <div class="col-md-3 col-sm-3">
                <?php include_once "menuAdm.html"; ?>
            </div>
            <!-- //MENU LATERAL -->

            <div class="col-md-9 col-sm-9">

                <?php
                    if (isset($_POST['btnSubmitFilme'])) {

                        /* PEGANDO AS IMAGENS DO FILME */

                        $titulo = $_POST['txtTitulo'];
                        $subTitulo = $_POST['txtSubtitulo'];
                        $anoLancamento = $_POST['selAnoLancamento'];
                        $trailer = $_POST['txtTrailer'];
                        $sinopse = $_POST['txtSinopse'];

                        $nomeImagem = array();

                        for ($i=0; $i < 3; $i++) {
                            $nomeImagem[$i] = $_FILES['fileImagem'.$i]['name'];

                            if ($nomeImagem[$i] <> "" && isset($_FILES['fileImagem'.$i]['name'])) {
                                $nomeImagem[$i] = enviaImagem($_FILES['fileImagem'.$i]['name'], "filmes", $_FILES['fileImagem'.$i]['tmp_name']);
                            }else{
                                $nomeImagem[$i] = "";
                            }
                        }

                        $sql = "CALL sp_cadastra_filme('$titulo', '$subTitulo', '$anoLancamento', '$trailer', '$sinopse', 
                        '$nomeImagem[0]', '$nomeImagem[1]', '$nomeImagem[2]', @saida, @rotulo)";
                        
                        if($res = mysqli_query($con, $sql)){
                            $reg = mysqli_fetch_assoc($res);
                            $saida = $reg['saida'];
                            $rotulo = $reg['saida_rotulo'];
                            $codigoFilme = $reg['codigo_filme'];
                            switch ($rotulo) {
                                case 'TUDO CERTO!':

                                    /* VERIFICA OS DIRETORES QUE FORAM SELECIONADOS */
                                    $maxDiretores= $_SESSION['maxDiretores'];
                                    unset($_SESSION['maxDiretores']);
 
                                    for ($i=0; $i < $maxDiretores; $i++) {
                                        if (isset($_POST['chDiretor_'.$i])) {
                                            $codigoDiretor = $_POST['chDiretor_'.$i];
                                            $querySimples = "CALL sp_cadastra_filme_diretor($codigoFilme, $codigoDiretor, @saida)";
                                            executaQuerySimples($querySimples);
                                        }
                                    }

                                    /* VERIFICA OS ATORES QUE FORAM SELECIONADOS */
                                    $maxAtores = $_SESSION['maxAtores'];
                                    unset($_SESSION['maxAtores']);

                                    for ($i=0; $i < $maxAtores; $i++) {
                                        if (isset($_POST['chAtor_'.$i])) {
                                            $codigoAtor = $_POST['chAtor_'.$i];
                                            $querySimples = "CALL sp_cadastra_filme_Ator($codigoFilme, $codigoAtor, @saida)";
                                            executaQuerySimples($querySimples);
                                        }
                                    }

                                    /* VERIFICA AS CATEGORIAS QUE FORAM SELECIONADOS */
                                    $maxCategorias = $_SESSION['maxCategorias'];
                                    unset($_SESSION['maxCategorias']);

                                    for ($i=0; $i < $maxCategorias; $i++) {
                                        if (isset($_POST['chCategoria_'.$i])) {
                                            $codigoCategoria = $_POST['chCategoria_'.$i];
                                            $querySimples = "CALL sp_cadastra_filme_Categoria($codigoFilme, $codigoCategoria, @saida)";
                                            executaQuerySimples($querySimples);
                                        }
                                    }

                                case 'OPS!':
                                    echo "Já tem filme cadastrado!";
                                    break;
                                case 'ERRO!':
                                    echo "Algo deu errado!";
                                    break;
                            }
                        }
                    }
                ?>

            </div>
   
        </div>
    </main>
    <script type="text/javascript">
        $("img.checkable").click(function () {
            $(this).toggleClass("checked");
        });
        $(".checked");

        $( '.captcha_imagens' ).click( function() {
            $(this * '.checked').css( 'display', 'block' );
            $(this).animate( { width: '70%', height: '70%' } );
        });
    </script>
    <!-- // FIM DO PRINCIPAL -->
    <?php if (isset($con)) {
        mysqli_close($con);
    } ?>
</body>

    <script src="https://kit.fontawesome.com/4bb29d1df9.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>

<?php
} else { ?>
    <meta http-equiv="refresh" content=0;url="login.php">
<?php
}
?>
</html>