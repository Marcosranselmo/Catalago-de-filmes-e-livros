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
        ?>
        <title>Filmes</title>

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

                    <form name="fmFilmes" method="post" action="cadastroFilmesadm.php" enctype="multipart/form-data"
                    onsubmit="return validaCampos()">
                        <div class="tab-content" id="meusConteudos">

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
                            <div class="tab-pane fade" id="tabDiretores" role="tabpanel" aria-labelledby="linkDiretores">
                                diretores
                            </div>
                            <div class="tab-pane fade" id="tabAtores" role="tabpanel" aria-labelledby="linkAtores">
                                atores
                            </div>
                            <div class="tab-pane fade" id="tabCategorias" role="tabpanel" aria-labelledby="linkCategorias">
                                categorias
                            </div>
                        </div>
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