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