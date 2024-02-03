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

    // FUNÇÃO PAR EXECUTAR AS QUERYS E RETORNAR AS MENSAGENS DE SAIDA
    function executaQuery($sql, $paginaDeRetorno) {
        include "conexao.php";
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
                <a href="<?php echo $paginaDeRetorno; ?>" class="alert-link" target="_self">Voltar</a>
            </div>
            <?php
        } else {
            echo "Erro ao executar a query.";
        }
        if (isset($con)) { mysqli_close($con); }
    }
    ?>