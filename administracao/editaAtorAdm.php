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
                            excluiTodasImagens($codigoAtor, 'atores');

                            $sql = "CALL sp_deleta_atores($codigoAtor, @saida, @saida_rotulo)";
                            executaQuery($sql, "atoresAdm.php");

                        }elseif(isset($_GET['editaAtor'])) {

                            /* CRIAÇÃO DE ARRAYS DE SESSÃO */
                            $_SESSION['caminho_imagem'][$i] = $reg['caminho'];
                            $_SESSION['codigo_imagem'][$i] = $reg['codigo'];
   
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

                                    $_SESSION['caminho_imagem'][$i] = $reg['caminho'];
                                    $_SESSION['codigo_imagem'][$i] = $reg['codigo'];

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
                                <div class="row text-center"> 
                                    <div class="col-md-3"><strong>Imagem</strong></div>
                                    <div class="col-md-6"><strong>Carregar nova imagem</strong></div>
                                    <div class="col-md-3"><strong>Excluir imagem</strong></div>
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
                                            class="btn btn-success w-100" accept="image/png, image/jpg">
                                        </div>
                                        <div class="col-md-3 text-center">
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
                                        onclick="return confirm('Tem certeza que deseja excluir este(a) ator(a)?')">Excluir</a>
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

                            for ($i=0; $i < 3; $i++);

                            $nomeImagem[$i] = $_FILES['fileImagemAtor'.$i]['name'];
                            $codigoImagem[$i] = "";

                            if ($nomeImgem[$i] <> "" && isset($_FILES['fileImagemAtor'.$i]['name'])) {
                                $nomeImgem[$i] = enviaImagem($_FILES['fileImagemAtor'.$i]['name'], "atores", 
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
                                excluiUmaImage($codigoImagem[$i], "atores");
                                $nomeImagem[$i] = "";
                                /* O NOME DA IMAGEM É ENVIADO COMO VAIO, POIS DESSA FORMA, A PROCEDURE ENTENDE
                                QUE É PARA EXCLUIR A IMAGEM DA TABELA DE IAMGENS */
                            }
                        } /* FIM DO FOR */

                        if (isset($_session['caminho_imagem']) || $_SESSION['codigo_imagem']) {
                            unset($_SESSION['caminho_imagem']);
                            unset($_SESSION['codigo_imagem']);
                        }

                        $nomeAtor = $_POST['txtNome'];
                        $paisAtor = $_POST['selPais'];
                        $biografiaAtor = $_POST['txtBiografia'];

                        $sql = "CALL sp_edita_ator('$codigoAtor','$nomeAtor','$paisAtor','$biografiaAtor','$nomeImage[0]',
                        '$codigoImage[0]','$nomeImage[1]','$codigoImage[1]','$nomeImage[2]','$codigoImage[2]',@saida,
                        @saida_rotulo)";

                        executaQuery($sql, 'atoresAdm.php');
                        }else{

                        }
                        ?>
                </div>
            </div>
        </main>

        <?php if (isset($con)) {mysqli_close($con);} ?>
    </body>

<script src="https://kit.fontawesome.com/4bb29d1df9.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
</script>
                    
<?php 
    }else{ ?>
    <meta http-equiv="refresh" content=0;url="login.php">
    <?php
    }
?>
</html>