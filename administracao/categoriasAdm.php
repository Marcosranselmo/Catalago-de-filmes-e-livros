<!DOCTYPE html>
<html>
<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if ($_SESSION['acesso'] == true) {
?>
<head>
    <?php
        include "../header.html";
        include_once "../mais/conexao.php";
        include_once "../mais/funcoes.php";
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
                    if(isset($_GET['btnSubmitCategoria'])) {
                        $nomeCategoria = $_GET['txtCategoria'];
                        $link = $nomeCategoria;
                        $sql = "CALL sp_cadastra_categoria('$nomeCategoria','$link',@saida, @rotulo);";
                        
                        executaQuery($sql, "categoriasAdm.php");
                    
                    }else{
                ?>
                <h4 class="text-center mb-4">Cadastro Categorias</h4>
                <form name="fmCategorias" method="get" action="categoriasAdm.php" onsubmit="return validaCampos()">
                    <label>Nome da categoria</label><br>
                    <input type="text" name="txtCategoria" class="form-control my-3" maxlength="50">
                    <button type="submit" class="btn btn-primary w-100" name="btnSubmitCategoria">Cadastrar</button>
                </form>     
                <br>
                <hr/>
                <h2 class="text-center mb-3">Categorias cadastradas:</h2>
                <div class="row mx-1">
                    <?php  
                        $sql = 'SELECT * FROM vw_retorna_categorias';
                        if ($res=mysqli_query($con, $sql)) {
                            $nomeCategoria = array();
                            $linkCategoria = array();
                            $codigoCategoria = array();
                            $i = 0;
                            while ($reg=mysqli_fetch_assoc($res)) {
                                $nomeCategoria[$i] = $reg['Nome_Categoria'];
                                $linkCategoria[$i] = $reg['Link_Categoria'];
                                $codigoCategoria[$i] = $reg['Codigo_Categoria'];
                                ?>
                                <div class="col-md-3 itensCadastrados text-center">
                                    <label class="col-md-12"><?php echo $nomeCategoria[$i]; ?></label>
                                    <div class="btn-group btn-group-sm" role="group" arial-label="Basic sample">
                                        <a href="editaCategoriaAdm.php?editaCategoria=<?php echo $codigoCategoria[$i];
                                        ?>&nomeCategoria=<?php echo $nomeCategoria[$i]; ?>" class="btn btn-primary">Editar</a>
                                        <a href="editaCategoriaAdm.php?excluirCategoria=<?php echo $codigoCategoria[$i]; 
                                        ?>" class="btn btn-secondary" onclick="return confirm('Tem certeza que deseja excluir esta categoria?')">Excluir</a>
                                    </div>
                                </div>
                            <?php
                            $i++;
                            }
                        }
                    ?>
                    </div>

                    <?php
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
<?php
    } else { 
?>
    <meta http-equiv="refresh" content=0;url="login.php">
<?php
}
?>
</html>