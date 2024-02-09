<!DOCTYPE html>
<html>
<head>
    <?php
        include_once "header.html";
        include_once "../mais/conexao.php";
        include_once "../mais/funcoes.php";
    ?>
    <title>Editar Filmes</title>
<!--     <script type="text/javascript">
        function validaCampos() {
            if (document.fmFilmes.txtNome.value == "") {
                alert("Preencha o nome!");
                document.fmFilmes.txtNome.focus();
                return false;
            }
            if (document.fmFilmes.txtBiografia.value == "") {
                alert("Preencha o campo Biografia!");
                document.fmFilmes.txtBiografia.focus();
                return false;
            }
            if (document.fmFilmes.selPais.value == 0) {
                alert("Escolha um País!");
                document.fmFilmes.selPais.focus();
                return false;
            }
        }
    </script> -->
</head>
<body class="administracao">

    <!-- MENU SUPERIOR -->

    <?php include_once "menuSuperior.html"; ?>
    <!-- FIM MENU SUPERIOR -->

    <!-- PRINCIPAL -->

    <main class="container">
        <h3 class="text-center mt-5">Filmes Cadastrados</h3><br>
        <div class="row-auto d-flex">
            <div class="col-md-3 col-sm-2 mx-3">
                <?php include_once "menuAdm.html" ?>            
            </div>
            <div class="col-md-9 col-sm-9">
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

                        /* CARREGAR AS INFORMAÇÕES DO(A) ATOR/ATRI */
                        $codigoFilme = $_GET['editaFilme'];
                        $_SESSION['codigo_filme'] = $codigoFilme;

                        $sql = "SELECT * FROM vw_retorna_filmes WHERE codigo_filme = $codigoFilme";
                        if ($res = mysqli_query($con, $sql)) {
                            $reg = mysqli_fetch_assoc($res);
                            $nomeTitulo = $reg['titulo_filme'];
                            $subTitulo = $reg['subtitulo_filme'];
                            $anoLancamento = $reg['ano_lancamento_filme'];
                            $trailerFilme = $reg['trailer_filme'];
                            $sinopseFilme = $reg['sinopse_filme'];
                        }else{
                        
                            echo "Algo deu errado ao executar a query!";
                        }
                    
                        $imagnsAtor = array();
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

                        <!-- EXIBIR INFORMÇÕES DO ATRO/ATRIZ NO FORMULÁRIO -->
                        <form name="fmFilmes" method="post" action="editaFilmeAdm.php" enctype="multipart/form-data" onsubmit="return validaCampos()">
                            <label>Nome:</label>
                            <input type="text" name="txtTitulo" class="form-control mb-2" maxlength="70" value="<?php echo $nomeTitulo; ?>">
                            
                            <label>Subtítulo do Filme</label>
                            <input type="text" name="txtSubtitulo" class="form-control" value="<?php echo $subTitulo; ?>">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Ano lançamento do filme</label>
                                    <select name="selAnoLancamento" class="form-control" value="<?php echo $anoLancamento; ?>">
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
                            <textarea name="txtSinopse" class="form-control" id="" cols="30" rows="5" value="<?php echo $sinopseFilme; ?>">
                            </textarea>

                            <label class="text-center">Fotos do Ator</label>
                            <div class="row text-center align-items-center"> 
                                <div class="col-md-3 mt-4 mb-4"><h5><strong>Imagem</strong></h5></div>
                                <div class="col-md-6"><h5><strong>Carregar nova imagem</strong></h5></div>
                                <div class="col-md-3"><h5><strong>Excluir imagem</strong></h5></div>
                                <?php
                                for ($i=0; $i < 3; $i++) { ?>
                                    <div class="col-md-3">
                                    <?php
                                    if (isset($imagensAtor[$i])) { 
                                        ?>
                                        <img src="../imagens/atores/<?php echo $imagensAtor[$i]; ?>" title="<?php echo $imagensAtor[$i]; ?>" style="max-width: 100px; padding: 5px;">
                                        <?php
                                    }else{
                                        ?>
                                        <img src="../imagens/atores/sem_imagem.jpg" title="sem_imagem.jpg" style="max-width: 100px; padding: 5px;">
                                    <?php
                                    } ?>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="file" name="<?php echo "fileImagemAtor".$i ?>" 
                                        class="btn btn-success w-100" accept="image/png, imagem/jpeg">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="checkbox" name="<?php echo "chExcluir".$i ?>">
                                    </div>
                                    <?php
                                }
                                ?>

                            </div> 
                            <button type="submit" name="btnSubmitAtores" class="btn btn-primary w-100 mb-1">Salvar Alteraçoes</button>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="atoresAdm.php" class="btn btn-success w-100 mb-4" 
                                    >Voltar</a>
                                </div>
                                <div class="col-md-6">
                                    <a href="editaAtorAdm.php?excluirAtor=<?php echo $codigoAtor; ?>" class="btn btn-danger w-100 mb-4" 
                                    onclick="return confirm('Tem certeza que deseja Editar este(a) ator(a)?')">Excluir</a>
                                </div>
                            </div>
                        </form>

                        <?php
                    
                    }elseif(isset($_POST['btnSubmitAtores'])) {
                        /*
                        $_SESSION['caminho_imagem'][$i] = $reg['caminho'];
                        $_SESSION['codigo_imagem'][$i] = $reg['codigo'];
                        */
                        $codigoAtor = $_SESSION['codigo_ator'];
                        unset($_SESSION['codigo_ator']);

                        $nomeImagem = array();
                        $codigoImagem = array();

                        for ($i=0; $i < 3; $i++) {

                        $nomeImagem[$i] = $_FILES['fileImagemAtor'.$i]['name'];
                        $codigoImagem[$i] = "";

                        if ($nomeImagem[$i] <> "" && isset($_FILES['fileImagemAtor'.$i]['name'])) {
                            $nomeImagem[$i] = enviaImagem($_FILES['fileImagemAtor'.$i]['name'], "atores", 
                            $_FILES['fileImagemAtor'.$i]['tmp_name']);
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
                                excluiUmaImagem($codigoImagem[$i], 'atores');
                            }
                        }

                        if (isset($_POST['chExcluir'.$i])) {
                            excluiUmaImagem($codigoImagem[$i], "atores");
                            $nomeImagem[$i] = "";
                            /* O NOME DA IMAGEM É ENVIADO COMO VAIO, POIS DESSA FORMA, A PROCEDURE ENTENDE
                            QUE É PARA EXCLUIR A IMAGEM DA TABELA DE IAMGENS */
                        }
                    } /* FIM DO FOR */

                    if (isset($_SESSION['caminho_imagem']) || $_SESSION['codigo_imagem']) {
                        unset($_SESSION['caminho_imagem']);
                        unset($_SESSION['codigo_imagem']);
                    }

                    $nomeAtor = $_POST['txtNome'];
                    $paisAtor = $_POST['selPais'];
                    $biografiaAtor = $_POST['txtBiografia'];

                    $sql = "CALL sp_edita_ator('$codigoAtor','$nomeAtor','$paisAtor','$biografiaAtor','$nomeImagem[0]',
                    '$codigoImagem[0]','$nomeImagem[1]','$codigoImagem[1]','$nomeImagem[2]','$codigoImagem[2]',@saida,
                    @saida_rotulo)";

                    executaQuery($sql, 'atoresAdm.php');
                    }else{

                    }
                    ?>
            </div>
        </div>
    </main>
    <?php if(isset($con)){ mysqli_close($con); } ?>

<script src="https://kit.fontawesome.com/4bb29d1df9.js" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous">
</script>
</body>
</html>