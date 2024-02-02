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
        <title>Cadastro Atores</title>
        <script type="text/javascript">
            function validaCampos() {
                if (document.fmAtores.txtNome.value == "") {
                    alert("Preencha o nome!");
                    document.fmAtores.txtNome.focus();
                    return false;
                }
                if (document.fmAtores.txtBiografia.value == "") {
                    alert("Preencha o campo Biografia!");
                    document.fmAtores.txtBiografia.focus();
                    return false;
                }
                if (document.fmAtores.selPais.value == 0) {
                    alert("Escolha um País!");
                    document.fmAtores.selPais.focus();
                    return false;
                }
            }
        </script>
    </head>

    <body class="administracao">
        <!-- MENU SUPERIOR -->
        <?php include_once "menuSuperior.html"; ?>
        <!-- FIM MENU SUPERIOR -->

        <!-- PRINCIPAL -->
        <main class="container">
            <h3 class="text-center mt-5">Atores - Administração</h3><br>
            <div class="row-auto d-flex">
                <div class="col-md-3 col-sm-3 mx-3">
                    <?php include_once "menuAdm.html" ?>            
                </div>
                <div class="col-md-9 col-sm-9">

                    <?php
                        if(isset($_POST['btnSubmitAtores'])) {

                            $nomeImagem1 = $_FILES['fileImagemAtor1']['name'];
                            $nomeImagem2 = $_FILES['fileImagemAtor2']['name'];
                            $nomeImagem3 = $_FILES['fileImagemAtor3']['name'];

                            if ($nomeImagem1 <> "" && isset($_FILES['fileImagemAtor1']['name'])) {
                                $nomeImagem1 = enviaImagem($_FILES['fileImagemAtor1']['name'], "atores", $_FILES['fileImagemAtor1']['tmp_name']);
                            }else{
                                $nomeimagem1 = "";
                            }

                            if ($nomeImagem2 <> "" && isset($_FILES['fileImagemAtor2']['name'])) {
                                $nomeImagem2 = enviaImagem($_FILES['fileImagemAtor2']['name'], "atores", $_FILES['fileImagemAtor2']['tmp_name']);
                            }else{
                                $nomeimagem2 = "";
                            }

                            if ($nomeImagem3 <> "" && isset($_FILES['fileImagemAtor3']['name'])) {
                                $nomeImagem3 = enviaImagem($_FILES['fileImagemAtor3']['name'], "atores", $_FILES['fileImagemAtor3']['tmp_name']);
                            }else{
                                $nomeimagem3 = "";
                            }

                            $nome = $_POST['txtNome'];
                            $pais = $_POST['selPais'];
                            $bio = $_POST['txtBiografia'];

                            $sql = "CALL sp_cadastra_atores('$nome','$pais','$bio','$nomeImagem1','$nomeImagem2','$nomeImagem3','@saida','@saida_rotulo')";
                            if($res=mysqli_query($con,$sql)) {
                                $reg=mysqli_fetch_assoc($res);
                                $saida = $reg['saida'];
                                $rotulo = $reg['saida_rotulo'];
                                switch ($rotulo) {
                                    case 'TUDO CERTO!':
                                        $alert = 'alert-success';
                                        break;
                                    case 'OPS!':
                                        $alert = 'alert-warning';
                                        break;  
                                    case 'ERRO!':
                                        $alert = 'alert-danger';
                                        break;      
                                }
                                ?>
                                <div class="alert <?php echo $alert; ?>" role="alert">
                                    <h3><?php echo $rotulo; ?></h3>
                                    <?php echo $saida; ?>
                                    <a href="atoresAdm.php" class="alert-link" target="_self">Voltar</a>
                                </div>
                                <?php
                            } else {
                                echo "Erro ao executar a query.";
                            }
                        }else{
                    ?>
            
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
                            <form name="fmAtores" method="post" action="atoresAdm.php" enctype="multipart/form-data" onsubmit="return validaCampos()">
                                <label>Nome:</label>
                                <input type="text" name="txtNome" class="form-control mb-2" maxlength="70">
                                <label>Páis:</label>
                                <select name="selPais" class="form-control mb-2">
                                    <option value="0">Selecione o País</option>
                                    <?php 
                                        $sql = "SELECT * FROM vw_retorna_pais";
                                        if($res = mysqli_query($con,$sql)) {
                                            $nomePais = array();
                                            $codigoPais = array();
                                            $i = 0;
                                            while ($reg = mysqli_fetch_assoc($res)) {
                                                $nomePais[$i] = $reg['nome_pais'];
                                                $codigoPais[$i] = $reg['codigo_pais'];
                                                ?>
                                                <option value="<?php echo $codigoPais[$i]; ?>">
                                                <?php echo $nomePais[$i]; ?></option>
                                                <?php
                                                $i++;
                                            }
                                        }
                                    ?>
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
                    <?php
                    } 
                    ?>
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