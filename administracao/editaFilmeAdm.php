<!DOCTYPE html>
<html>
<head>
    <?php
        include_once "header.html";
        include_once "../mais/conexao.php";
        include_once "../mais/funcoes.php";
    ?>
    <title>Editar Filmes</title>
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
        <h3 class="text-center mt-5">Filmes Cadastrados</h3><br>
        <div class="row-auto d-flex">
            <div class="col-md-3 col-sm-2 mx-3">
                <?php include_once "menuAdm.html" ?>            
            </div>
            <div class="col-md-9 col-sm-9">
                <?php
                    if (isset($_GET['excluirFilme'])) {

                        $codigoFilme = $_GET['excluirFilme'];
                        /* EXCLUI TODAS AS IMAGENS FO FILME SELECIONADO */
                        excluiTodasImagens($codigoFilme,"filmes");

                        $sql = "CALL sp_deleta_filme($codigoFilme, @saida, @saida_rotulo)"; 
                        executaQuery($sql, "filmesCadastradosAdm.php");

                    }else{

                    }
                ?>
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
</html>