<?php
include_once "header.html";
include_once "../mais/conexao.php";
?>
<title>Subir Imagens</title>
<?php
// FUNÇÃO PARA SUBIR IMAGENS
function enviaImagem($imagem, $caminho, $imagemTemp)
{
    $extensao = pathinfo($imagem, PATHINFO_EXTENSION);
    $extensao = strtolower($extensao);

    if (strstr('.jpg;.jpeg;.png', $extensao)) {
        $imagem = $caminho . mt_rand() . "." . $extensao;

        $diretorio = "../imagens/" . $caminho . "/";

        move_uploaded_file($imagemTemp, $diretorio . $imagem);
    } else { ?>
        <div class="alert alert-danger" role="alert">
            Apenas imagens com extensão: *.jpeg, *.jpg e *.png!
        </div>
    <?php
    }
    return $imagem;
}

// FUNÇÃO PAR EXECUTAR AS QUERYS E RETORNAR AS MENSAGENS DE SAIDA
function executaQuery($sql, $paginaDeRetorno){
    include "conexao.php";
    if ($res = mysqli_query($con, $sql)) {
        $reg = mysqli_fetch_assoc($res);
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
    if (isset($con)) { mysqli_close($con);
    }
}

// FUNÇÃO PARA EXECUTR AS QUERYS E RETORNAR AS MANSAGENS DE SAÍDA
function executaQuerySimples($sql){
    include "conexao.php";
    if ($res = mysqli_query($con, $sql)) {
        $reg = mysqli_fetch_assoc($res);
        $saida = $reg['saida'];
        switch ($saida) {
            case 'TUDO CERTO!':
                $alert = 'alert-success';
                break;
            case 'ERRO! Algo deu errado ao vincular o filme com ofiretor.':
                $alert = 'alert-danger';
                break;
        }
        ?>
        <div class="alert <?php echo $alert; ?>" role="alert">
            <?php echo $saida; ?>
        </div>
        <?php
    } else {
        echo "Erro ao executar a query.";
    }
    if (isset($con)) {mysqli_close($con);
    }
}

// FUNÇÃO PARA EXCLUIR TODAS AS IMAGENS DE UM ATOR/DIRETOR/FILME/BANNER
function excluirImagens($codigo, $alvo)
{
    include "conexao.php";

    $imagens = array();
    $linhas = 0;
    $where = $alvo . "_codigo";

    //SELECT * FROM imagens WHERE atores_codigo = 3 ex.
    $sql = "SELECT * FROM imagens WHERE ".$where." = $codigo";
    if ($res = mysqli_query($con, $sql)) {
        $linhas = mysqli_affected_rows($con);
        if ($linhas > 0) {
            while ($reg = mysqli_fetch_assoc($res)) {

                $delete = unlink("../imagens/".$alvo."/".$reg["caminho"]);
                if (!$delete) {
                    ?>
                    <div class="alert danger" role="alert">
                        <h3>Erro!</h3>
                        <p>Algo deu errado ao excluir a imagem: <?php echo $reg['caminho']; ?></p>
                    </div>
                <?php
                }
            }
        }
    }else{ ?>

        <div class="alert danger" role="alert">
            <h3>Erro!</h3>
            <p>Algo deu errado ao executar a query!</p>
        </div>
        <?php
    }
    if (isset($con)) { mysqli_close($con); }
}

function excluiTodasImagens($codigo, $alvo){
    include "conexao.php";

    $linhas = 0;
    $where = $alvo . "_codigo";

    //SELECT * FROM imagens WHERE atores_codigo = 3 ex.
    $sql = "SELECT * FROM imagens WHERE ".$where." = $codigo";
    if ($res = mysqli_query($con, $sql)) {
        $linhas = mysqli_affected_rows($con);
        if ($linhas > 0) {
            while ($reg = mysqli_fetch_assoc($res)) {

                $delete = unlink("../imagens/".$alvo."/".$reg["caminho"]);
                if (!$delete) {
                    ?>
                    <div class="alert danger" role="alert">
                        <h3>Erro!</h3>
                        <p>Algo deu errado ao excluir a imagem: <?php echo $reg['caminho']; ?></p>
                    </div>
                <?php
                }
            }
        }
    }else{ ?>

        <div class="alert danger" role="alert">
            <h3>Erro!</h3>
            <p>Algo deu errado ao executar a query!</p>
        </div>
        <?php
    }
    if (isset($con)) { mysqli_close($con); }
}

function excluiUmaImagem($codigo, $alvo){
    include "conexao.php";

    //SELECT * FROM imagens WHERE atores_codigo = 3 ex.
    $sql = "SELECT * FROM imagens WHERE codigo = ".$codigo;
    if ($res = mysqli_query($con, $sql)) {
            while ($reg = mysqli_fetch_assoc($res)) {
            $delete = unlink("../imagens/".$alvo."/".$reg['caminho']);
            if (!$delete) {
                ?>
                <div class="alert danger" role="alert">
                    <h3>Erro!</h3>
                    <p>Algo deu errado ao excluir a imagem: <?php echo $reg['caminho']; ?></p>
                </div>
            <?php
            }
        }
    }else{ ?>

        <div class="alert danger" role="alert">
            <h3>Erro!</h3>
            <p>Algo deu errado ao executar a query!</p>
        </div>
        <?php
    }
    if (isset($con)) { mysqli_close($con); }
}

?>