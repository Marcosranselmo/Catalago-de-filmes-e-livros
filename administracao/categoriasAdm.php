<!DOCTYPE html>
<html>
<head>
    <?php
        include_once "header.html";
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
                <h2 class="text-center">Cadastro Categorias</h2>
                <form name="fmCategorias" method="get" action="categoriasAdm.php" 
                onsubmit="return validaCampos()">
                    </label>Nome da categoria</label><br>
                    <input type="text" name="txtCategoria" class="form-control" maxlength="30">
                    <button type="submit" class="btn btn-primary w-100 mt-2">Cadastrar</button>
                </form>     
                <br>
                <hr>
                <h2 class="text-center">Caterogias cadastradas:</h2>
            </div>
        </div>
    </main>

</body>
</html>