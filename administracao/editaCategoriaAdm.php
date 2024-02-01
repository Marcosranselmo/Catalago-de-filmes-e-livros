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
    <title>Home</title>
    <script type="text/javascript">
        function validaCampos() {
            if (document.fmCategorias.txtCategoria.value == "") {
                alert("Favor preencher no campo o nome da categoria");
                document.fmCategorias.txtCategoria.focus();
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
        <h3 class="text-center mt-5">Categorias - Administração</h3><br>
        <div class="row-auto d-flex">
            <div class="col-md-3 col-sm-2 mx-3">
                <?php include_once "menuAdm.html" ?>
            </div>
            <div class="col-md-9 col-sm-9">
                <?php
                if (isset($_GET['excluirCategoria'])) {
                    $codigoCategoria = $_GET['excluirCategoria'];
                    $sql = "CALL sp_deleta_categoria('$codigoCategoria', @saida, @rotulo);";
                    if ($res = mysqli_query($con, $sql)) {
                        $reg = mysqli_fetch_assoc($res);
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
                            <a href="categoriasAdm.php" class="alert-link" target="_self">Voltar</a>
                        </div>
                    <?php
                    } else {
                        echo "Erro ao executar a query."; ?>
                        <br><br>
                        <a href="categoriasAdm.php" class="alert-link" target="_self">Voltar</a>
                    <?php
                    }
                } else if (isset($_GET['editaCategoria'])) {
                    $_SESSION['codigoCategoria'] = $_GET['editaCategoria'];
                    $nomeCategoria = $_GET['nomeCategoria'];
                    ?>
                    <h4 class="text-center mb-4">Alteração de Categorias</h4>
                    <form name="fmCategorias" method="get" action="editaCategoriaAdm.php" onsubmit="return validaCampos()">
                        <label>Nome da categoria</label><br>
                        <input type="text" name="txtCategoria" value="<?php echo $nomeCategoria; ?>" class="form-control my-3" maxlength="50">
                        <button type="submit" class="btn btn-primary w-100" name="btnSubmitCategoria">Alterar categoria</button>
                    </form>
                    <br>
                <?php
                } elseif(isset($_GET['btnSubmitCategoria'])) {
                    $nomeCategoria = $_GET['txtCategoria'];
                    $codigoCategoria = $_SESSION['codigoCategoria'];
                    unset($_SESSION['codigoCategoria']);
                    $sql = "CALL sp_edita_categoria($codigoCategoria,'$nomeCategoria',@saida, @rotulo);";
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
                            <a href="categoriasAdm.php" class="alert-link" target="_self">Voltar</a>
                        </div>
                        <?php
                    } else {
                        echo "Erro ao executar a query.";
                    }
                } else {
                }
                ?>
            </div>
        </div>
    </main>
    <?php if (isset($con)) { mysqli_close($con); } ?>
</body>

<?php 
    }else{
        ?>
        <meta http-equiv="refresh" content=0;url="administracao/login.php">
        <?php
    } 
?>

</html>