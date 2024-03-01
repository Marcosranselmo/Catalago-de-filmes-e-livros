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
        include_once "header.html";
        include_once "../mais/conexao.php";
        include_once "../mais/funcoes.php";
    ?>
    <title>Administrar Países</title>
    <script type="text/javascript">
        function validaCampos() {
            if (document.fmPais.txtPais.value == "" ) {
                alert("Favor preencher no campo do Pais");
                document.fmPais.txtPais.focus();
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
                    if(isset($_GET['btnSubmitPais'])) {
                        $nomePais = $_GET['txtPais'];
                        $link = $nomePais;
                        $sql = "CALL sp_cadastra_pais('$nomePais','$link',@saida, @rotulo);";

                        executaQuery($sql, "paisAdm.php");

                    }else{
                ?>
                <h4 class="text-center mb-4">Cadastrar Paises</h4>
                <form name="fmPais" method="get" action="paisAdm.php" onsubmit="return validaCampos()">
                    <label>Nome do Pais</label><br>
                    <input type="text" name="txtPais" class="form-control my-3" maxlength="50">
                    <button type="submit" class="btn btn-primary w-100" name="btnSubmitPais">Cadastrar</button>
                </form>     
                <br>
                <hr/>
                <h4 class="text-center mb-5">Paises Cadastrados:</h4>
                <div class="row mx-1">
                    <?php  
                        $sql = 'SELECT * FROM vw_retorna_pais';
                        if ($res=mysqli_query($con, $sql)) {
                            $nomePais = array();
                            $linkPais= array();
                            $codigoPais = array();
                            $i = 0;
                            while ($reg=mysqli_fetch_assoc($res)) {
                                $nomePais[$i] = $reg['nome_pais'];
                                $linkPais[$i] = $reg['link_pais'];
                                $codigoPais[$i] = $reg['codigo_pais'];
                                ?>
                                <div class="col-md-3 itensPais text-center mt-4">
                                    <label class="col-md-12"><?php echo $nomePais[$i]; ?></label>
                                    <div class="btn-group btn-group-sm" role="group" arial-label="Basic sample">
                                        <a href="editaPaisAdm.php?editaPais=<?php echo $codigoPais[$i];
                                        ?>&nomePais=<?php echo $nomePais[$i]; ?>" class="btn btn-primary">Editar</a>
                                        <a href="editaPaisAdm.php?excluirPais=<?php echo $codigoPais[$i]; 
                                        ?>" class="btn btn-secondary" onclick="return confirm('Tem certeza que deseja excluir este Pais?')">Excluir</a>
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
}
?>
</html>