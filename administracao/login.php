<!DOCTYPE html>
<html>
<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if (isset($_SESSION['acesso'])) {
        ?>
        <center><h2>Sessão esta aberta</h2>
        <br>
        <h4>Redirecionando Administração</h4>
        </center>
        <meta http-equiv="refresh" content=2;url="../adm.php">
        <?php
    }else{
?>
<head>
    <?php
        include_once "header.html";
        include_once "../mais/conexao.php";
    ?>
    <title>Login</title>
    <script type="text/javascript">
        function ValidaCampos() {
            if (document.fmLogin.txtLogin.value == "") {
                alert("Por favor, preencha o campo Nome!");
                document.fmLogin.txtLogin.focus();
                return false;
            }
            if (document.fmLogin.txtSenha.value == "") {
                alert("Por favor, preencha da senha!");
                document.fmLogin.txtSenha.focus();
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
        <h3 class="text-center mt-5 mb-4">Usuário - Administração</h3><br>
        <div class="row-auto d-flex">
            <div class="col-md-6 col-sm-6 px-3">
                <img src="../imagens/logo-login.jpg" class="w-100" alt="imagens ilustrativa para login">
            </div>
            <div class="col-md-6 col-sm-6 px-3">
                <?php
                    if (isset($_POST['btnSubmitLogin'])) {
                        $usuario = $_POST['txtLogin'];
                        $senha = $_POST['txtSenha'];
                        // $sql = "SELECT login, senha FROM usuarios WHERE login = '$usuario' AND senha = '$senha'";
                        $sql = "CALL sp_verifica_senha('$usuario','$senha',@a)";
                        if ($res = mysqli_query($con, $sql)) {
                            $reg = mysqli_fetch_assoc($res);
                            $saida = $reg['saida'];
                            switch ($saida) {
                                case 'TUDO CERTO!':
                                    $alert = 'alert-success';
                                    ?>
                                    <div class="alert <?php echo $alert; ?>" role="alert">
                                        <h3><?php echo "Login efetuado com sucesso!"; ?></h3>
                                    </div>
                                    <meta http-equiv="refresh" content=1;url="../Adm.php">
                                    <?php
                                    $_SESSION['acesso'] = true;
                                    break;
                                case 'ERRO!':
                                    $alert = 'alert-danger';
                                    ?>
                                    <div class="alert <?php echo $alert; ?>" role="alert">
                                        <h3><?php echo "Login ou senha inválido!"; ?></h3>
                                    </div>
                                    <?php
                                    break;
                            }    
                        }else{
                            echo "Erro ao executar a query";
                        }
                        }else{    
                    ?>
                    <form name="fmLogin" method="post" action="login.php" onsubmit="return ValidaCampos();">
                        <h3 class="text-center mb-4">Login</h3>
                        <input type="text" name="txtLogin" class="form-control mb-4" placeholder="Digite o nome">
                        <input type="password" name="txtSenha" class="form-control mb-4" placeholder="Digite a senha">
                        <button type="submit" name="btnSubmitLogin" class="btn btn-primary w-100">Entrar</button>
                    </form>
                <?php } ?>
            </div>
        </div>
    </main>
    <?php if(isset($con)){ mysqli_close($con); } ?>
</body>

<?php 
} 
?>
</html>