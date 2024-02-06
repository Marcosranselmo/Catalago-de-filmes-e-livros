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
                        <a href="#tabCadastro" class="nav-link active" id="linkCadastro" data-toggle="tab" role="tab" 
                        aria-controls="tabCadastro">Cadastrados Diretores(a) </a>
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

                <h3>Cadastrar novo filme</h3>
                <form name="fmFilmes" method="post" action="cadastraFilmeAdm.php" enctype="multipart/form-data"
                    onsubmit="return validaCampos()">
                    <div class="tab-content" id="meusConteudos">

                        <!--------- INFORMAÇÕES DO FILME --------->
                        <div class="tab-pane fade show-active" id="tabCadastro" role="tabpanel" aria-labelledby="linkCadastro">
                            <label>Título do Filme</label>
                            <input type="text" name="txtTitulo" class="form-control">

                            <label>Subtítulo do Filme</label>
                            <input type="text" name="txtSubtitulo" class="form-control">

                            <div class="row">
                                <div class="col-md-6">
                                    <label>Ano lançamento do filme</label>
                                    <select name="selAnoLancamento" class="form-control">
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
                                    <input type="text" name="txtTrailer" class="form-control">
                                </div>
                            </div>
                            <label>Imagens do Filme</label>
                            <textarea class="form-control" name="txtSinopse" cols="30" rows="3"></textarea>

                            <label>Fotos do Ator</label>
                            <input type="file" name="fileImagemDiretor1" class="btn btn-success w-100 mb-2" accept="image/png, image/jpg">
                            <input type="file" name="fileImagemDiretor2" class="btn btn-success w-100 mb-2" accept="image/png, image/jpg">
                            <input type="file" name="fileImagemDiretor3" class="btn btn-success w-100 mb-2" accept="image/png, image/jpg">

                        </div>
                        <!--------- FIM DA ABA INFORMAÇÕES DO FILME --------->

                        <!--------- EXIBIÇÃO DOS DIRETORES ------------------>
                        <div class="tab-pane fade" id="tabDiretores" role="tabpanel" aria-labelledby="linkDiretores">
                        <h3>Selecione Diretor do Filme</h3>
                            <div class="row">    
                                <?php 
                                    $sql = "SELECT * FROM vw_retorna_diretores ORDER BY nome_diretor";
                                    if ($res = mysqli_query($con, $sql)) {

                                        $nomeDiretor = array();
                                        $codigoDiretor = array();
                                        $imagemDiretor = array();
                                        $i = 0;
                                        $linhas = 0;
                                     
                                        while($reg = mysqli_fetch_assoc($res)) {
                                            $linhas = mysqli_affected_rows($con);
                                            $nomeDiretor[$i] = $reg['nome_diretor'];
                                            $codigoDiretor[$i] = $reg['codigo_diretor'];
                                            $imagemDiretor[$i] = $reg['caminho_imagem'];

                                            if (!isset($imagemDiretor[$i])) {
                                                $imagemDiretor[$i] = "sem_imagem.jpg";
                                            }
                                            ?>
                                            <div class="col-md-3 itensCadastrados text-center">
                                                <img src="../imagens/diretores/<?php echo $imagemDiretor[$i]; ?>" class="
                                                img-responsive img-thumbnail">
                                                <h4><?php echo $nomeDiretor[$i]; ?></h4>
                                                <input type="checkbox" name="<?php 'chDiretor_'.$i; ?>" value="<?php echo
                                                $codigoDiretor[$i]; ?>" class="form-control">
                                            </div>

                                            <?php
                                            $i++;
                                        }
                                        $_SESSION['maxDiretores'] = $i;
                                    if ($linhas == 0) {
                                        ?>
                              
                                        <div class="alert alert-danger" role="alert">
                                            <h4>Nenhum diretor cadastrado!</h4>
                                        </div>
                                        <?php
                                    }
                                }else{
                                    echo 'Erro ao executar a query!';
                                }
                                ?>
                            </div>
                        </div>
                        <!----------- FIM DA EXIBIÇÃO DOS DIRETORES --------------->

                        <!----------- EXIBIÇÃO DOS ATORES/ATRIZES ------------------>
                        <div class="tab-pane fade" id="tabAtores" role="tabpanel" aria-labelledby="linkAtores">
                        <h3>Selecione os Atores(a) do Filme</h3>
                            <div class="row">    
                                <?php 
                                    $sql = "SELECT * FROM vw_retorna_atores";
                                    if ($res = mysqli_query($con, $sql)) {

                                        $nomeAtor = array();
                                        $codigoAtor = array();
                                        $imagemAtor = array();
                                        $i = 0;
                                     
                                        while($reg = mysqli_fetch_assoc($res)) {
                                            $linhas = mysqli_affected_rows($con);
                                            $nomeAtor[$i] = $reg['nome_ator'];
                                            $codigoAtor[$i] = $reg['codigo_ator'];
                                            $imagemAtor[$i] = $reg['caminho_imagem'];

                                            if (!isset($imagemAtor[$i])) {
                                                $imagemAtor[$i] = "sem_imagem.jpg";
                                            }
                                            ?>
                                            <div class="col-md-3 itensCadastrados text-center">
                                                <img src="../imagens/atores/<?php echo $imagemAtor[$i]; ?>" class="
                                                img-responsive img-thumbnail">
                                                <h4><?php echo $nomeAtor[$i]; ?></h4>
                                                <input type="checkbox" name="<?php 'chAtor_'.$i; ?>" value="<?php echo
                                                $codigoAtor[$i]; ?>" class="form-control">
                                            </div>

                                            <?php
                                            $i++;
                                        }
                                        $_SESSION['maxAtores'] = $i;
                                    if ($linhas == 0) {
                                        ?>
                              
                                        <div class="alert alert-danger" role="alert">
                                            <h4>Nenhum diretor cadastrado!</h4>
                                        </div>
                                        <?php
                                    }
                                }else{
                                    echo 'Erro ao executar a query!';
                                }
                                ?>
                            </div>
                        </div>





                        <div class="tab-pane fade" id="tabCategorias" role="tabpanel" aria-labelledby="linkCategorias">
                            <div class="row">    
                                <?php 
                                /* $sql = "SELECT codigo_diretor, nome_diretor, caminho_imagem, FROM vw_retorna_diretores"); */
                                    $sql = "SELECT Codigo_Categoria, Nome_Categoria FROM vw_retorna_categorias";
                                    if ($res = mysqli_query($con, $sql)){
                                        $i = 0;
                                        while($reg = mysqli_fetch_assoc($res)) {
                                            ?>
                                            <div class="col-md-3 itensCadastrados text-center">
                                                <h6><?php echo $reg['Nome_Categoria']; ?></h6>
                                                <input type="checkbox" name="chCategoria_<?php echo $i?>" value="
                                                <?php echo $reg['Codigo_Categoria']; ?>"> 
                                            </div>
                                            <?php
                                            $i++;
                                        }
                                        $_SESSION['maxCategorias'] = $i;
                                    }else{
                                      
                                           echo "Algo deu errado ao executar a query!";
                                      
                                      
                                    }
                                ?>
                            </div>
                        </div>
                    <!------------------ FIM DA EXIBIÇÃO DAS CATEGORIAS ------------------>
                    </div>
                    <button type="submit" name="btnSubmitFilme" class="btn btn-primary w-100 mt-3 mb-5">Cadastrar Filme</button>
                </form>
            </div>
        </div>
    </main>
    <!-- //PRINCIPAL -->
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