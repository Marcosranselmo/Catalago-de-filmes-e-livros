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
            <h3 class="text-center mt-5">Edita Atores - Administração</h3><br>
            <div class="row-auto d-flex">
                <div class="col-md-3 col-sm-3 mx-3">
                    <?php include_once "menuAdm.html" ?>
                </div>
                <div class="col-md-9 col-sm-9">
                    <?php 
                        if (isset($_GET['excluirAtor'])) {
                            $codigoAtor = $_GET['excluirAtor'];
                            // excluir as imagens do ator
                            excluirImagens($codigoAtor, 'atores');

                            $sql = "CALL sp_deleta_atores($codigoAtor, @saida, @saida_rotulo)";
                            executaQuery($sql, "atoresAdm.php");

                        }elseif(isset($_GET['editaAtor'])) {

                            /* CRIAÇÃO DE ARRAYS DE SESSÃO */
                            $_SESSION['caminho_imagem'] = array();
                            $_SESSION['codigo_imagem'] = array();
    
                            /* CARREGAR AS INFORMAÇÕES DO(A) ATOR/ATRI */
                            $codigoAtor = $_GET['editaAtor'];
                            $_SESSION['codigo_ator'] = $codigoAtor;
    
                            $sql = "SELECT * FROM vw_retorna_atores WHERE codigo_ator = $codigoAtor";
                            if ($res = mysqli_query($con, $sql)) {
                                $reg = mysqli_fetch_assoc($res);
                                $nomeAtor = $reg['nome_ator'];
                                $paisAtor = $reg['pais_ator'];
                                $biografiaAtor = $reg['biografia_ator'];
                            }else{
                                echo "Algo deu errado ao executar a query!";
                            }

                            $imagnsAtor = array();
                            $imagensCodigo = array();
                            $i = 0;
                            $sql = "SELECT * FROM imagens WHERE atores_codigo = $codigoAtor";
                            if ($res = mysqli_query($con, $sql)) {
                                while ($reg = mysqli_fetch_assoc($res)) {
                                    $imagensAtor[$i] = $reg['caminho'];
                                    $imagensCodigo[$i] = $reg['codigo'];
                                    $i++;
                                }
                            }else{
                                echo "Algo deu errado ao executar a query!";
                            } ?>

                            <!-- EXIBIR INFORMÇÕES DO ATRO/ATRIZ NO FORMULÁRIO -->
                            <form name="fmAtores" method="post" action="editaAtorAdm.php" enctype="multipart/form-data" onsubmit="return validaCampos()">
                                <label>Nome:</label>
                                <input type="text" name="txtNome" class="form-control mb-2" maxlength="70" value="<?php echo $nomeAtor; ?>">
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
                                            <option value="<?php echo $codigoPais[$i]; ?>" <?php if ($codigoPais[$i] == $paisAtor)
                                            {
                                                echo "selected";
                                            } ?> ><?php echo $nomePais[$i]; ?></option>
                                    <?php
                                            $i++;
                                        }
                                    }
                                    ?>
                                </select>

                                <label>Biografia do Ator:</label>
                                <textarea name="txtBiografia" maxlength="500" placeholder="Digite descrição aqui" cols="87" rows="4" class="form-control mb-2">
                                    <?php echo $biografiaAtor; ?>
                                </textarea>

                                <label>Fotos do Ator</label>
                                <input type="file" name="fileImagemAtor1" class="btn btn-success w-100 mb-2" accept="image/png, image/jpg">
                                <input type="file" name="fileImagemAtor2" class="btn btn-success w-100 mb-2" accept="image/png, image/jpg">
                                <input type="file" name="fileImagemAtor3" class="btn btn-success w-100 mb-2" accept="image/png, image/jpg">

                                <button type="submit" name="btnSubmitAtores" class="btn btn-primary w-100">Cadastrar</button>
                                <br><br>
                            </form>

                            <?php
                        }else{
    
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