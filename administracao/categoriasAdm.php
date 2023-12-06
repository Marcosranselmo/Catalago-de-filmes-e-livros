<!DOCTYPE html>
<html>
<head>
    <?php
        include_once "header.html";
        include_once "../mais/conexao.php";
    ?>
    <title>Home</title>
    <script type="text/javascript">
        function validaCampos() {
            if (document.fmCategorias.txtCategoria.value == "" ) {
                alert("Favor preencher no campo o nome da categoria");
                document.fmCategorias.txtCategoria.focus();
                return false;
            }
        }
    </script>
</head>
<body class="adminitracao">

    <!-- MENU SUPERIOR -->

    <?php include_once "menuSuperior.html"; ?>
    <!-- FIM MENU SUPERIOR -->

    <!-- PRINCIPAL -->

    <main class="container">
        <h3 class="text-center mt-5">CATEGORIAS - Administração</h3><br>
        <div class="row-auto d-flex">
            <div class="col-md-3 col-sm-3">
                <?php include_once "menuAdm.html" ?>            
            </div>
            <div class="col-md-9 col-sm-9">
                <?php 
                    if(isset($_GET['btnSubmitCategoria'])) {
                        $nomeCategoria = $_GET['txtCategoria'];
                        $link = $nomeCategoria;
                        $sql = "CALL sp_cadastra_categoria('$nomeCategoria','$link',@saida);";
                        if($res=mysqli_query($con,$sql)) {
                            $reg=mysqli_fetch_assoc($res);
                            $saida = $reg['saida'];
                            echo $saida;
                        } else {
                            echo "Erro ao executar a query.";
                        }
                    }
                ?>
                <h2 class="text-center">Cadastro Categorias</h2>
                <form name="fmCategorias" method="get" action="categoriasAdm.php" onsubmit="return validaCampos()">
                    </label>Nome da categoria</label><br>
                    <input type="text" name="txtCategoria" class="form-control" maxlength="30">
                    <button type="submit" class="btn btn-primary w-100 mt-2" name="btnSubmitCategoria">Cadastrar</button>
                </form>     
                <br>
                <hr>
                <h2 class="text-center">Caterogias cadastradas:</h2>
            </div>
        </div>
    </main>
    <?php if(isset($con)){ mysqli_close($con); } ?>
</body>
</html>