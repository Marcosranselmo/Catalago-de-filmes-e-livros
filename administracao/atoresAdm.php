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
        <title>Cadastro de Atores - Admintração Filmes na Estantes</title>
    </head>

    <body class="administracao">
        <!-- MENU SUPERIOR -->
        <?php include_once "menuSuperior.html"; ?>
        <!-- FIM MENU SUPERIOR -->

        <!-- PRINCIPAL -->
        <main class="container">
            <h3 class="text-center mt-5">Usuário - Administração</h3><br>
            <div class="row-auto d-flex">
                <div class="col-md-3 col-sm-3 mx-3">
                    <?php include_once "menuAdm.html" ?>            
                </div>
                <div class="col-md-9 col-sm-9">
            
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#tabFormulario" class="nav-link active" id="linkFormulario" 
                            data-toggle="tab" role="tab" aria-controls="tabFormulario">Cadastro</a>        
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabExibicao" class="nav-link" id="linkExibicao" 
                            data-toggle="tab" role="tab" aria-controls="tabExibicao">Atores/Atrizes Cadastrados</a>        
                        </li>
                    </ul>

                    <div class="tab-content" id="meusConteudos">
                        <div class="tab-pane fade show-active" id="tabFormulario" role="tabpanel"
                            aria-labelledby="linkFormulario">
                            
                            <h4 class="text-center mt-5 mb-4">Cadastrar Novos Atores</h4>  
                            <form name="fmAtores" method="post" action="atoresAdm.php" enctype="multipart/form-data">
                                <label>Nome:</label>
                                <input type="text" name="txtNome" class="form-control mb-2" maxlength="70">
                                <label>Páis:</label>
                                <select name="selPais" class="form-control mb-2">
                                    <option value="0">---------------</option>
                                </select>

                                <label>Biografia do Ator:</label>
                                <textarea name="txtBiografia" maxlength="500" placeholder="Digite descrição aqui" cols="87" rows="4"
                                class="form-control mb-2"></textarea>

                                <label>Fotos do Ator</label>
                                <input type="file" name="fileImagemAtor1" class="btn btn-success w-100 mb-2" 
                                accept="image/png, image/jpg">
                                <input type="file" name="fileImagemAtor2" class="btn btn-success w-100 mb-2" 
                                accept="image/png, image/jpg">
                                <input type="file" name="fileImagemAtor3" class="btn btn-success w-100 mb-2" 
                                accept="image/png, image/jpg">

                                <button type="submit" name="btnSubmitAtores" class="btn btn-primary w-100">Cadastrar</button>
                                <br><br>
                            </form>
                        
                        </div>
                        <div class="tab-pane fade mt-5" id="tabExibicao" role="tabpanel"
                            aria-labelledby="linkExibicao">
                            <h4 class="text-center">Atores Cadastrados</h4>  
                            <div class="row">

                            </div>   
                        </div>
                    </div>
                </div>
            </div>
        </main>

    <?php if (isset($con)) { mysqli_close($con); } ?>
    </body>
<?php
} else { ?>
    <meta http-equiv="refresh" content=0;url="login.php">
<?php
}
?>
</html>