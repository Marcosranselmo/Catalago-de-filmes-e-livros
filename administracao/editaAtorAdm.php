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