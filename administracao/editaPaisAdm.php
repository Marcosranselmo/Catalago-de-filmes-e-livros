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
            if (document.fmPaises.txtPais.value == "") {
                alert("Favor preencher no campo o nome do Pais");
                document.fmPaises.txtPais.focus();
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
        <h3 class="text-center mt-5">Paises - Administração</h3><br>
        <div class="row-auto d-flex">
            <div class="col-md-3 col-sm-2 mx-3">
                <?php include_once "menuAdm.html" ?>
            </div>
            <div class="col-md-9 col-sm-9">
                <?php
                if (isset($_GET['excluirPais'])) {
                    $codigoPais = $_GET['excluirPais'];
                    $sql = "CALL sp_deleta_pais('$codigoPais', @saida, @rotulo);";
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
                            <a href="paisAdm.php" class="alert-link" target="_self">Voltar</a>
                        </div>
                    <?php
                    } else {
                        echo "Erro ao executar a query."; ?>
                        <br><br>
                        <a href="paisAdm.php" class="alert-link" target="_self">Voltar</a>
                    <?php
                    }
                } else if (isset($_GET['editaPais'])) {
                    $_SESSION['codigoPais'] = $_GET['editaPais'];
                    $nomePais = $_GET['nomePais'];
                    ?>
                    <h4 class="text-center mb-4">Editar Países</h4>
                    <form name="fmPaises" method="get" action="editaPaisAdm.php" onsubmit="return validaCampos()">
                        <label>Nome do Pais</label><br>
                        <input type="text" name="txtPais" value="<?php echo $nomePais; ?>" class="form-control my-3" maxlength="50">
                        <button type="submit" class="btn btn-primary w-100" name="btnSubmitPais">Alterar Pais</button>
                    </form>
                    <br>
                <?php
                } elseif(isset($_GET['btnSubmitPais'])) {
                    $nomePais = $_GET['txtPais'];
                    $codigoPais = $_SESSION['codigoPais'];
                    unset($_SESSION['codigoPais']);
                    $sql = "CALL sp_edita_pais($codigoPais,'$nomePais',@saida, @rotulo);";
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
                            <a href="PaisAdm.php" class="alert-link" target="_self">Voltar</a>
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