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
        include_once "../header.html";
        include_once "../mais/conexao.php";
        include_once "../mais/funcoes.php";
    ?>
    <title>Filme Cadastrados</title>
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
                <div class="row">
                    <?php
                        $sql = "SELECT * FROM vw_retorna_filmes ORDER BY titulo_filme";
                        if ($res = mysqli_query($con, $sql)) {

                            $tituloFilme= array();
                            $codigoFilme = array();
                            $imagemFilme = array();
                            $i = 0;
                            $linhas= 0;

                            while ($reg = mysqli_fetch_assoc($res)) {
                            $linhas = mysqli_affected_rows($con);
                            $tituloFilme[$i] = $reg['titulo_filme'];
                            $codigoFilme[$i] = $reg['codigo_filme'];
                            $imagemFilme[$i] = $reg['caminho_imagem'];

                            if (!isset($imagemFilme[$i])) {
                                $imagemFilme[$i] = "sem_imagem.jpg";
                            }
                            ?>
                            <div class="col-md-4 itensCadastrados text-center">
                                <h6><?php echo $tituloFilme[$i]; ?></h6>
                                <img src="../imagens/filmes/<?php echo $imagemFilme[$i]; ?>" class="img-responsive img-thumbnail mb-3" alt="">
                                <div class="btn-group btn-group-sm" role="group" arial-label="Basic sample">
                                    <a href="editaFilmeAdm.php?editaFilme=<?php echo $codigoFilme[$i]; ?>" class="btn btn-primary">Editar</a>
                                    <a href="editaFilmeAdm.php?excluirFilme=<?php echo $codigoFilme[$i]; ?>" class="btn btn-secondary" 
                                        onclick="return confirm('Tem certeza que deseja excluir este filme?')">Excluir</a>
                                </div>
                            </div>

                            <?php
                            $i++;
                        }
                        if ($linhas == 0) {
                        ?>
                        <div class="alert alert-danger" role="alert">
                            <h4>Nenhum filme cadastrado!</h4>
                        </div>
                        <?php
                        }
                    }else{
                        echo "Erro ao executar a query!";
                    }
                    ?>
                </div>
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