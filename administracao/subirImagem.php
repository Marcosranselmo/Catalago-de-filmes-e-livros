<!doctype html>
<html lang="pt-br">
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
    ?>
    <title>Subir Imagens</title>
    <?php
    // FUNÇÃO PARA SUBIR IMAGENS
    function enviaImagem($imagem, $caminho, $imagemTemp) {
        $extensao = pathinfo($imagem, PATHINFO_EXTENSION);
        $extensao = strtolower($extensao);

        if(strstr('.jpg;.jpeg;.png', $extensao)) {
            $imagem = $caminho.mt_rand().".".$extensao;

            $diretorio = "../imagens/".$caminho."/";

            move_uploaded_file($imagemTemp, $diretorio.$imagem);

        }else{ ?>
            <div class="alert alert-danger" role="alert">
                Apenas imagens com extensão: *.jpeg, *.jpg e *.png!
            </div>
        <?php    
        }
        return $imagem;
    }
    ?>
</head>

<body class="administracao">
    <!-- MENU SUPERIOR -->
    <?php include_once "menuSuperior.html" ?>
    <!-- //MENU SUPERIOR -->

    <main class="container">
        <h3 class="text-center">Imagens Atores</h3>
        <div class="row">
            <div class="col-md-3 col-sm-3">
                <?php include_once "menuAdm.html" ?>
            </div>
            <div class="col-md-9 col-sm-9">
                <?php
                    if (isset($_POST['btnSubmitImagem'])){
                        $nomeImagem = $_FILES['fileImagem']['name'];

                        if($nomeImagem != "" && isset($_FILES['fileImagem']['name']) ){
                            $nomeImagem = enviaImagem($_FILES['fileImagem']['name'], "teste", 
                            $_FILES['fileImagem']['tmp_name'] );
                        }else{
                            $nomeImagem = "";
                        } ?>
                            <h3 class="text-center">Tudo certo!</h3>
                            <h3 class="text-center">Imagem cadastrada com sucesso!</h3>
                            <a href="subirImagem.php">Voltar</a>
                        <?php
                    }else{
                ?>
                <form name="fmImagem" method="post" action="subirImagem.php" enctype="multipart/form-data">
                    <label>Insira a Imagem</label>
                    <input type="file" name="fileImagem" class="btn btn-success w-100 mb-3" accept="image/png, image/jpeg">
                    <button type="submit" class="btn btn-primary form-control w-100" name="btnSubmitImagem">Cadastrar Imagem</button>
                </form>
                <?php                 
                }
                ?>
            </div>
        </div>
    </main>
    <?php if (isset($con)) { mysqli_close($con); } ?>
</body>
<?php
    }
?>
</html>