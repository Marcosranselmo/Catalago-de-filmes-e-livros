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
    <title>Banner Adm</title>
</head>
<body class="administracao">

    <!-- MENU SUPERIOR -->

    <?php include_once "menuSuperior.html"; ?>

    <!-- FIM MENU SUPERIOR -->

    <!-- PRINCIPAL -->

    <main class="container">
        <h3 class="text-center mt-5">Banner Principal - Administração</h3><br>
        <div class="row">
            <div class="col-md-3 col-sm-3">
                <?php include_once "menuAdm.html" ?>            
            </div>
            <div class="col-md-9 col-sm-9">

                <?php
                    $sql = 'SELECT * FROM vw_retorna_banner ORDER BY codigo_imagem';
                    if($res = mysqli_query($con,$sql)) {
                        $i=0;
                        $linhas = mysqli_affected_rows($con);
                        $codigoImagem    = array();
                        $linhasImagem    = array();
                        $linksImagem     = array();
                        $descricaoImagem = array();
                        $codigoBanner    = array();

                        if($linhas > 0) {
                            while( $reg = mysqli_fetch_assoc($res) ) {
                            $codigoImagem[$i]    = $reg['codigo_imagem'];
                            $linhasImagem[$i]    = $reg['link_imagem'];
                            $caminhoImagem[$i]   = $reg['caminho_imagem'];
                            $descricaoImagem[$i] = $reg['descricao_imagem'];
                            $codigoBanner[$i]    = $reg['codigo_banner'];
                            $i++;
                        }
                    }else{
                        for($i = 0; $i < 3; $i++) {
                            $codigoImagem[$i]    = "";
                            $linhasImagem[$i]    = "";
                            $caminhoImagem[$i]   = "sem_imagem.jpg";
                            $descricaoImagem[$i] = "";
                            $codigoBanner[$i]    = "";
                        }
                    }
                }else{
                    echo "Não conseguiu executar a query!<hr>";
                }
                
                ?>

                <div class="alert alert-danger">
                   <h4 class="text-center">ATENÇÃO</h4>
                   <h5 style="margin-bottom: -15px">Sempre utilize imagens com as mesmas dimensões.</h5>
                   <br><strong>Recomendado: </strong>Largura: <strong>1200px </strong> x Altura <strong>250px</strong>
                </div>
                <form name="fmBanner" method="post" action="bannerAdm.php" enctype="multipart/form-data">
                    <div class="row">

                        <?php
                            for ($i = 0; $i < 3; $i++) {
                            ?>
                        <div class="col-md-4">
                            <label><strong>Alterar Imagem:</strong></label>
                            <img src="../imagens/banner/<?php echo $caminhoImagem[$i]; ?>" class="img-responsive img-thumbnail">
                            <input type="file" name="<?php echo "fileImagem".$i ?>" class="btn btn-success w-100">
                        </div>
                        <div class="col-md-8">
                            <h5 class="text-center">Banner <?php echo $i+1; ?></h5>
                            <label><strong>Link do Banner:</strong></label>
                            <input type="text" name="<?php echo "txtLinkBanner".$i ?>" value="<?php echo $linksImagem[$i]; ?>" class="form-control" placeholder="Link utilizado no banner"><br>

                            <label><strong>Descrição do Banner:</strong></label>
                            <input type="text" name="<?php echo "txtDescricaoBanner".$i ?>" value="<?php echo $descricaoImagem[$i]; ?>" class="form-control" placeholder="
                            Pequena descrição do banner"><br>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                <button type="submit" name="btnSubmitBanner" class="btn btn-primary w-100 btn-lg mt-5">Salvar Alterações</button>
                </form>

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

<?php 
    }else{ ?>
        <meta http-equiv="refresh" content=0;url="administracao/login.php">
        <?php
    } 
?>

</html>