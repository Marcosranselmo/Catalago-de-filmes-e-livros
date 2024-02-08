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
        <title>Cadastro Diretores</title>
        <script type="text/javascript">
            function validaCampos() {
                if (document.fmDiretores.txtNome.value == "") {
                    alert("Preencha o nome!");
                    document.fmDiretores.txtNome.focus();
                    return false;
                }
                if (document.fmDiretores.txtBiografia.value == "") {
                    alert("Preencha o campo Biografia!");
                    document.fmDiretores.txtBiografia.focus();
                    return false;
                }
                if (document.fmDiretores.selPais.value == 0) {
                    alert("Escolha um País!");
                    document.fmDiretores.selPais.focus();
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
            <h3 class="text-center mt-5">Diretores - Administração</h3><br>
            <div class="row-auto d-flex">
                <div class="col-md-3 col-sm-3 mx-3">
                    <?php include_once "menuAdm.html" ?>
                </div>
                <div class="col-md-9 col-sm-9">

                    <?php
                    if (isset($_POST['btnSubmitDiretores'])) {
                        $nomeImagem = array();

                        for ($i=0; $i < 3; $i++) {
                            $nomeImagem[$i] = $_FILES['fileImagem'.$i]['name'];

                            if ($nomeImagem[$i] <> "" && isset($_FILES['fileImagem'.$i]['name'])) {
                                $nomeImagem[$i] = enviaImagem($_FILES['fileImagem'.$i]['name'], "diretores", $_FILES['
                                fileImagem'.$i]['tmp_name']);
                            }else{
                                $nomeImagem[$i] = "";
                            }
                        }
                        
                        $nome = $_POST['txtNome'];
                        $pais = $_POST['selPais'];
                        $bio = $_POST['txtBiografia'];

                        $sql = "CALL sp_cadastra_diretores('$nome','$pais','$bio','$nomeImagem1','$nomeImagem2','$nomeImagem3','@saida','@saida_rotulo')";

                        executaQuery($sql, "diretoresAdm.php");

                    } else {
                    ?>

                        <ul class="nav nav-tabs" role="tablist">

                            <li class="nav-item" role="presentation">
                                <a href="#tabExibicao" class="nav-link active" id="linkExibicao" data-toggle="tab" role="tab" aria-controls="tabExibicao">Diretores/Diretoras Cadastrados</a>
                            </li>

                            <li class="nav-item" role="presentation">
                                <a href="#tabFormulario" class="nav-link" id="linkFormulario" data-toggle="tab" role="tab" aria-controls="tabFormulario">Cadastro</a>
                            </li>

                        </ul>

                        <div class="tab-content" id="meusConteudos">

                            <div class="tab-pane fade show-active mt-5 p-3" id="tabExibicao" role="tabpanel" aria-labelledby="linkExibicao">
                                <h4 class="text-center mb-4">Diretores Cadastrados</h4>
                                <div class="row">
                                    <?php
                                    $sql = "SELECT * FROM vw_retorna_diretores ORDER BY nome_diretor";
                                    if ($res = mysqli_query($con, $sql)) {

                                        $nomeDiretor = array();
                                        $codigoDiretor = array();
                                        $imagemDiretor = array();
                                        $i = 0;
                                        $linhas= 0;

                                        while ($reg = mysqli_fetch_assoc($res)) {
                                        $linhas = mysqli_affected_rows($con);
                                        $nomeDiretor[$i] = $reg['nome_diretor'];
                                        $codigoDiretor[$i] = $reg['codigo_diretor'];
                                        $imagemDiretor[$i] = $reg['caminho_imagem'];

                                        if (!isset($imagemDiretor[$i])) {
                                            $imagemDiretor[$i] = "sem_imagem.jpg";
                                        }
                                        ?>
                                        <div class="col-md-4 itensCadastrados text-center">
                                            <h6><?php echo $nomeDiretor[$i]; ?></h6>
                                            <img src="../imagens/diretores/<?php echo $imagemDiretor[$i]; ?>" class="img-responsive img-thumbnail mb-3" alt="">
                                            <!-- LINHA INATIVA <h6><?php echo $nomeDiretor[$i] . " codigo: " . $codigoDiretor[$i]; ?></h6> -->
                                            <div class="btn-group btn-group-sm" role="group" arial-label="Basic sample">
                                                <a href="editaDiretorAdm.php?editaDiretor=<?php echo $codigoDiretor[$i]; ?>" class="btn btn-primary">Editar</a>
                                                <a href="editaDiretorAdm.php?excluirDiretor=<?php echo $codigoDiretor[$i]; ?>" class="btn btn-secondary" 
                                                    onclick="return confirm('Tem certeza que deseja excluir este(a) Diretor(a)?')">Excluir</a>
                                            </div>
                                        </div>

                                        <?php
                                        $i++;
                                        }
                                    }

                                    ?>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="tabFormulario" role="tabpanel" aria-labelledby="linkFormulario">

                                <h4 class="text-center mt-5 mb-4">Cadastrar Novos Diretores</h4>
                                <form name="fmDiretores" method="post" action="diretoresAdm.php" enctype="multipart/form-data" onsubmit="return validaCampos()">
                                    <label>Nome:</label>
                                    <input type="text" name="txtNome" class="form-control mb-2" maxlength="70">
                                    <label>Páis:</label>
                                    <select name="selPais" class="form-control mb-2">
                                        <option value="0">Selecione o País</option>
                                        <?php
                                        $sql = "SELECT * FROM vw_retorna_pais";
                                        if ($res = mysqli_query($con, $sql)) {
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

                                    <label>Biografia do Diretor:</label>
                                    <textarea name="txtBiografia" maxlength="500" placeholder="Digite descrição aqui" cols="87" rows="4" class="form-control mb-2"></textarea>

                                    <label>Fotos do Ator</label>
                                    <input type="file" name="fileImagemDiretor1" class="btn btn-success w-100 mb-2" accept="image/png, image/jpg">
                                    <input type="file" name="fileImagemDiretor2" class="btn btn-success w-100 mb-2" accept="image/png, image/jpg">
                                    <input type="file" name="fileImagemDiretor3" class="btn btn-success w-100 mb-2" accept="image/png, image/jpg">

                                    <button type="submit" name="btnSubmitDiretores" class="btn btn-primary w-100">Cadastrar</button>
                                    <br><br>
                                </form>

                            </div>

                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </main>

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