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
            <h3 class="text-center mt-5">Edita Diretores - Administração</h3><br>
            <div class="row-auto d-flex">
                <div class="col-md-3 col-sm-3 mx-3">
                    <?php include_once "menuAdm.html" ?>
                </div>
                <div class="col-md-9 col-sm-9">
                    <?php 
                        if (isset($_GET['excluirDiretor'])) {
                            $codigoDiretor = $_GET['excluirDiretor'];
                            // excluir as imagens do diretor
                            excluiTodasImagens($codigoDiretor, 'diretores');

                            $sql = "CALL sp_deleta_diretores($codigoDiretor, @saida, @saida_rotulo)";
                            executaQuery($sql, "diretoresAdm.php");

                        }elseif(isset($_GET['editaDiretor'])) {

                            /* CRIAÇÃO DE ARRAYS DE SESSÃO */
                            $_SESSION['caminho_imagem'] = array();
                            $_SESSION['codigo_imagem'] = array();
   
                            /* CARREGAR AS INFORMAÇÕES DO(A) ATOR/ATRI */
                            $codigoDiretor = $_GET['editaDiretor'];
                            $_SESSION['codigo_diretor'] = $codigoDiretor;
    
                            $sql = "SELECT * FROM vw_retorna_diretores WHERE codigo_diretor = $codigoDiretor";
                            if ($res = mysqli_query($con, $sql)) {
                                $reg = mysqli_fetch_assoc($res);
                                $nomeDiretor = $reg['nome_diretor'];
                                $paisDiretor = $reg['pais_diretor'];
                                $biografiaDiretor = $reg['biografia_diretor'];
                            }else{
                            
                                echo "Algo deu errado ao executar a query!";
                            }
                        

                            $imagnsDiretor = array();
                            $imagensCodigo = array();
                            $i = 0;
                            $sql = "SELECT * FROM imagens WHERE diretores_codigo = $codigoDiretor";
                            if ($res = mysqli_query($con, $sql)) {
                                while ($reg = mysqli_fetch_assoc($res)) {
                                    $imagensDiretor[$i] = $reg['caminho'];
                                    $imagensCodigo[$i] = $reg['codigo'];

                                    $_SESSION['caminho_imagem'][$i] = $reg['caminho'];
                                    $_SESSION['codigo_imagem'][$i] = $reg['codigo'];

                                    $i++;
                                }
                            }else{
                                echo "Algo deu errado ao executar a query!";
                            } ?> 

                            <!-- EXIBIR INFORMÇÕES DO ATRO/ATRIZ NO FORMULÁRIO -->
                            <form name="fmDiretores" method="post" action="editaDiretorAdm.php" enctype="multipart/form-data" onsubmit="return validaCampos()">
                                <label>Nome:</label>
                                <input type="text" name="txtNome" class="form-control mb-2" maxlength="70" value="<?php echo $nomeDiretor; ?>">
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
                                            <option value="<?php echo $codigoPais[$i]; ?>" <?php if ($codigoPais[$i] == $paisDiretor)
                                            {
                                                echo "selected";
                                            } ?> ><?php echo $nomePais[$i]; ?></option>
                                    <?php
                                            $i++;
                                        }
                                    }
                                    ?>
                                </select>

                                <label>Biografia do Diretor:</label>
                                <textarea name="txtBiografia" maxlength="500" placeholder="Digite descrição aqui" cols="87" rows="4" class="form-control mb-2">
                                    <?php echo $biografiaDiretor; ?>
                                </textarea>

                                <label class="text-center">Fotos do Diretor</label>
                                <div class="row text-center align-items-center"> 
                                    <div class="col-md-3 mt-4 mb-4"><h5><strong>Imagem</strong></h5></div>
                                    <div class="col-md-6"><h5><strong>Carregar nova imagem</strong></h5></div>
                                    <div class="col-md-3"><h5><strong>Excluir imagem</strong></h5></div>
                                    <?php
                                    for ($i=0; $i < 3; $i++) { ?>
                                        <div class="col-md-3">
                                        <?php
                                        if (isset($imagensDiretor[$i])) { 
                                            ?>
                                            <img src="../imagens/diretores/<?php echo $imagensDiretor[$i]; ?>" title="<?php echo $imagensDiretor[$i]; ?>" style="max-width: 100px; padding: 5px;">
                                            <?php
                                        }else{
                                            ?>
                                            <img src="../imagens/diretores/sem_imagem.jpg" title="sem_imagem.jpg" style="max-width: 100px; padding: 5px;">
                                        <?php
                                        } ?>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="file" name="<?php echo "fileImagemDiretor".$i ?>" 
                                            class="btn btn-success w-100" accept="image/png, imagem/jpeg">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="checkbox" name="<?php echo "chExcluir".$i ?>">
                                        </div>
                                        <?php
                                    }
                                    ?>

                                </div> 
                                <button type="submit" name="btnSubmitDiretores" class="btn btn-primary w-100 mb-1">Salvar Alteraçoes</button>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="diretoresAdm.php" class="btn btn-success w-100 mb-4" 
                                        >Voltar</a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="editaDiretorAdm.php?excluirDiretor=<?php echo $codigoDiretor; ?>" class="btn btn-danger w-100 mb-4" 
                                        onclick="return confirm('Tem certeza que deseja Editar este(a) Diretor(a)?')">Excluir</a>
                                    </div>
                                </div>
                            </form>

                            <?php
                        
                        }elseif(isset($_POST['btnSubmitDiretores'])) {
                            /*
                            $_SESSION['caminho_imagem'][$i] = $reg['caminho'];
                            $_SESSION['codigo_imagem'][$i] = $reg['codigo'];
                            */
                            $codigoDiretor = $_SESSION['codigo_diretor'];
                            unset($_SESSION['codigo_diretor']);

                            $nomeImagem = array();
                            $codigoImagem = array();

                            for ($i=0; $i < 3; $i++) {

                            $nomeImagem[$i] = $_FILES['fileImagemDiretor'.$i]['name'];
                            $codigoImagem[$i] = "";

                            if ($nomeImagem[$i] <> "" && isset($_FILES['fileImagemDiretor'.$i]['name'])) {
                                $nomeImagem[$i] = enviaImagem($_FILES['fileImagemDiretor'.$i]['name'], "diretores", 
                                $_FILES['fileImagemDiretor'.$i]['tmp_name']);
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
                                    excluiUmaImagem($codigoImagem[$i], 'diretores');
                                }
                            }

                            if (isset($_POST['chExcluir'.$i])) {
                                excluiUmaImagem($codigoImagem[$i], "diretores");
                                $nomeImagem[$i] = "";
                                /* O NOME DA IMAGEM É ENVIADO COMO VAIO, POIS DESSA FORMA, A PROCEDURE ENTENDE
                                QUE É PARA EXCLUIR A IMAGEM DA TABELA DE IAMGENS */
                            }
                        } /* FIM DO FOR */

                        if (isset($_SESSION['caminho_imagem']) || $_SESSION['codigo_imagem']) {
                            unset($_SESSION['caminho_imagem']);
                            unset($_SESSION['codigo_imagem']);
                        }

                        $nomeDiretor = $_POST['txtNome'];
                        $paisDiretor = $_POST['selPais'];
                        $biografiaDiretor = $_POST['txtBiografia'];

                        $sql = "CALL sp_edita_diretor('$codigoDiretor','$nomeDiretor','$paisDiretor','$biografiaDiretor','$nomeImagem[0]',
                        '$codigoImagem[0]','$nomeImagem[1]','$codigoImagem[1]','$nomeImagem[2]','$codigoImagem[2]',@saida,
                        @saida_rotulo)";

                        executaQuery($sql, 'diretoresAdm.php');
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