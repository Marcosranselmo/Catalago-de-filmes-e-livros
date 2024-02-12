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
    <title>Filmes</title>
</head>

<body class="adm">
    <!-- MENU SUPERIOR -->
    <?php include_once "menuSuperior.html" ?>
    <!-- //MENU SUPERIOR -->

    <!-- PRINCIPAL -->
    <main class="container mt-5">
        <h3 class="text-center">Filmes - Administração</h3>
        <div class="row gy-4 mt-4">
            <!-- MENU LATERAL -->
            <div class="col-md-3 col-sm-3">
                <?php include_once "menuAdm.html"; ?>
            </div>
            <!-- //MENU LATERAL -->

            <div class="col-md-9 col-sm-9">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a href="#tabFilme" class="nav-link active" id="linkFilme" data-toggle="tab" role="tab" 
                        aria-controls="tabFilme">Informações Básicas</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#tabDiretores" class="nav-link" id="linkDiretores" data-toggle="tab" role="tab" 
                        aria-controls="tabDiretores">Diretores</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#tabAtores" class="nav-link" id="linkAtores" data-toggle="tab" role="tab" 
                        aria-controls="tabAtores">Atores</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#tabCategorias" class="nav-link" id="linkCategorias" data-toggle="tab" role="tab" 
                        aria-controls="tabCategorias">Categorias</a>
                    </li>
                </ul>
  
                <h3>Editando dados filme</h3>
                <form name="fmFilmes" method="post" action="editaFilmeAdm.php" enctype="multipart/form-data" onsubmit="return validaCampos()">

                <?php
                    if (isset($_GET['excluirFilme'])) {

                        $codigoFilme = $_GET['excluirFilme'];
                        /* EXCLUI TODAS AS IMAGENS DO FILME SELECIONADO */
                        excluiTodasImagens($codigoFilme,"filmes");

                        $sql = "CALL sp_deleta_filme($codigoFilme, @saida, @saida_rotulo)"; 
                        executaQuery($sql, "filmesCadastradosAdm.php");

                        }elseif(isset($_GET['editaFilme'])) {

                        /* CRIAÇÃO DE ARRAYS DE SESSÃO */
                        $_SESSION['caminho_imagem'] = array();
                        $_SESSION['codigo_imagem'] = array();

                        /* CARREGAR AS INFORMAÇÕES DO FILME */
                        $codigoFilme = $_GET['editaFilme'];
                        $_SESSION['codigo_filme'] = $codigoFilme;

                        $sql = "SELECT * FROM vw_retorna_filmes WHERE codigo_filme = $codigoFilme";
                        if ($res = mysqli_query($con, $sql)) {
                            $reg = mysqli_fetch_assoc($res);
                            $nometituloFilme = $reg['titulo_filme'];
                            $subtituloFilme = $reg['subtitulo_filme'];
                            $anolancamentoFilme = $reg['ano_lancamento_filme'];
                            $trailerFilme = $reg['trailer_filme'];
                            $sinopseFilme = $reg['sinopse_filme'];
                        }else{
                        
                            echo "Algo deu errado ao executar a query!";
                        }
                    
                        $imagensFilme = array();
                        $imagensCodigo = array();
                        $i = 0;
                        $sql = "SELECT * FROM imagens WHERE filmes_codigo = $codigoFilme";
                        if ($res = mysqli_query($con, $sql)) {
                            while ($reg = mysqli_fetch_assoc($res)) {
                                $imagensFilme[$i] = $reg['caminho'];
                                $imagensCodigo[$i] = $reg['codigo'];

                                $_SESSION['caminho_imagem'][$i] = $reg['caminho'];
                                $_SESSION['codigo_imagem'][$i] = $reg['codigo'];

                                $i++;
                            }
                        }else{
                            echo "Algo deu errado ao executar a query!";
                        } ?> 

                        <!-- EXIBIR INFORMÇÕES DO FILME NO FORMULÁRIO -->
<!--                         <form name="fmFilmes" method="post" action="editaFilmeAdm.php" enctype="multipart/form-data" onsubmit="return validaCampos()">
 -->                            <label>Nome:</label>
                            <input type="text" name="txtTitulo" class="form-control mb-2" maxlength="70" value="<?php echo $nometituloFilme; ?>">
                            
                            <label>Subtítulo do Filme</label>
                            <input type="text" name="txtSubtitulo" class="form-control" value="<?php echo $subtituloFilme; ?>">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Ano lançamento do filme</label>
                                    <select type="text" name="selAnoLancamento" class="form-control" value="<?php echo $anolancamentoFilme; ?>">
                                        <?php 
                                            $anoAtual = date('Y');
                                            for ($i=$anoAtual; $i >= 1888; $i--) {
                                                ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Trailer do Filme</label>
                                    <input type="text" name="txtTrailer" class="form-control" value="<?php echo $trailerFilme; ?>">
                                </div>
                            </div>

                            <label>Sinópse</label>
                            <textarea type="text" name="txtSinopse" class="form-control" cols="30" rows="5" value="<?php echo $sinopseFilme; ?>">
                            </textarea>

                            <label class="text-center">Imagem do Filme</label>
                            <div class="row text-center align-items-center"> 
                                <div class="col-md-3 mt-4 mb-4"><h5><strong>Imagem</strong></h5></div>
                                <div class="col-md-6"><h5><strong>Carregar nova imagem</strong></h5></div>
                                <div class="col-md-3"><h5><strong>Excluir imagem</strong></h5></div>
                                <?php
                                for ($i=0; $i < 3; $i++) { ?>
                                    <div class="col-md-3">
                                    <?php
                                    if (isset($imagensFilme[$i])) { 
                                        ?>
                                        <img src="../imagens/filmes/<?php echo $imagensFilme[$i]; ?>" title="<?php echo $imagensFilme[$i]; ?>" style="max-width: 100px; padding: 5px;">
                                        <?php
                                    }else{
                                        ?>
                                        <img src="../imagens/filmes/sem_imagem.jpg" title="sem_imagem.jpg" style="max-width: 100px; padding: 5px;">
                                    <?php
                                    } ?>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="file" name="<?php echo "fileImagemFilme".$i ?>" 
                                        class="btn btn-success w-100" accept="image/png, imagem/jpeg">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="checkbox" name="<?php echo "chExcluir".$i ?>">
                                    </div>
                                    <?php
                                }
                                ?>
                            </div> 
                            <br>
                            <?php
                        
                            }elseif(isset($_POST['btnSubmitFilmes'])) {
                        
                            /* $_SESSION['caminho_imagem'][$i] = $reg['caminho'];
                            $_SESSION['codigo_imagem'][$i] = $reg['codigo']; */
                        
                            $codigoFilme = $_SESSION['codigo_filme'];
                            unset($_SESSION['codigo_filme']);

                            $nomeImagem = array();
                            $codigoImagem = array();

                            for ($i=0; $i < 3; $i++) {

                            $nomeImagem[$i] = $_FILES['fileImagemFilme'.$i]['name'];
                            $codigoImagem[$i] = "";

                            if ($nomeImagem[$i] <> "" && isset($_FILES['fileImagemFilme'.$i]['name'])) {
                                $nomeImagem[$i] = enviaImagem($_FILES['fileImagemFilme'.$i]['name'], "filmes", 
                                $_FILES['fileImagemFilme'.$i]['tmp_name']);
                            }elseif( isset($_SESSION['caminho_imagem'][$i])){
                                $nomeImagem[$i] = $_SESSION['caminho_imagem'][$i];
                            }

                            if( isset($_SESSION['codigo_imagem'][$i])){
                                $codigoImagem[$i] = $_SESSION['codigo_imagem'][$i];
                            }
                            /* essa verificção é para o caso do usuário substituir a imagem que já está salva */
                            if (isset($_SESSION['caminho_imagem'][$i]) && isset($nomeImagem[$i])) {
                                /* verifica se a imagem atual ediferente da iamgem que foi enviada no input */
                                if ($_SESSION['caminho_imagem'][$i] <> $nomeImagem[$i]) {
                                    excluiUmaImagem($codigoImagem[$i], 'filmes');
                                }
                            }

                            if (isset($_POST['chExcluir'.$i])) {
                                excluiUmaImagem($codigoImagem[$i], "filmes");
                                $nomeImagem[$i] = "";
                                /* O NOME DA IMAGEM É ENVIADO COMO VAIO, POIS DESSA FORMA, A PROCEDURE ENTENDE
                                QUE É PARA EXCLUIR A IMAGEM DA TABELA DE IAMGENS */
                                }
                            } /* FIM DO FOR */

                            if (isset($_SESSION['caminho_imagem']) || $_SESSION['codigo_imagem']) {
                                unset($_SESSION['caminho_imagem']);
                                unset($_SESSION['codigo_imagem']);
                            }

                            $nometituloFilme = $_POST['txtTitulo'];
                            $nomesubtituloFilme = $_POST['txtSubtitulo'];
                            $anolancamentoFilme = $_POST['selAnoLancamento'];
                            $trailerFilme = $_POST['txtTrailer'];
                            $sinopseFilme = $_POST['txtSinopse'];

                            $sql = "CALL sp_edita_filme(
                            '$codigoFilme',
                            '$nometituloFilme',
                            '$nomesubtituloFilme',
                            '$anolancamentoFilme',
                            '$trailerFilme',
                            '$sinopseFilme',
                            '$nomeImagem[0]',
                            '$codigoImagem[0]',
                            '$nomeImagem[1]',
                            '$codigoImagem[1]',
                            '$nomeImagem[2]',
                            '$codigoImagem[2]',
                            @saida,
                            @saida_rotulo)";

                            executaQuery($sql, 'filmesAdm.php');
                            }else{

                            }
                            ?>
                  
                            <!-- </div> -->
                            <!--------- FIM DA ABA INFORMAÇÕES DO FILME --------->

                            <!--------- EXIBIÇÃO DOS DIRETORES ------------------>
                            <div class="tab-pane fade" id="tabDiretores" role="tabpanel" aria-labelledby="linkDiretores">
                            <h4>Selecione Diretor do Filme</h4>
                                <div class="row">    
                                <h4>Diretores</h4>
                                </div>
                            </div>
                            <!----------- FIM DA EXIBIÇÃO DOS DIRETORES --------------->

                            <!----------- EXIBIÇÃO DOS ATORES/ATRIZES ------------------>
                            <div class="tab-pane fade" id="tabAtores" role="tabpanel" aria-labelledby="linkAtores">
                            <h4>Selecione os Atores(a) do Filme</h4>
                                <div class="row">    
                                <h3>Atores</h3>
                                </div>
                            </div>
                            <!----------- FIM DA EXIBIÇÃO DOS ATORES/ATRIZES --------------->

                            <!----------- EXIBIÇÃO DOS CATEGORIAS ------------------>
                            <div class="tab-pane fade" id="tabCategorias" role="tabpanel" aria-labelledby="linkCategorias">
                            <h4>Selecione a categoria do filme</h4>
                                <div class="row">    
                                <h3>Categorias</h3>
                                </div>
                            </div>
                            <!------------------ FIM DA EXIBIÇÃO DAS CATEGORIAS ------------------>
                            <!-- </div>
                            </div> -->
                            <button type="submit" name="btnSubmitFilmes" class="btn btn-primary w-100 mb-1">Salvar Alteraçoes</button>                </form>
                
                        </form>        
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

<!-- //PRINCIPAL -->
    <?php if (isset($con)) {mysqli_close($con); } ?>
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