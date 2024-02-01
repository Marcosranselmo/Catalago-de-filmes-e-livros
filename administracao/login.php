<!DOCTYPE html>
<html>
<head>
    <?php
        include_once "header.html";
        include_once "../mais/conexao.php";
    ?>
    <title>Login</title>
    <script type="text/javascript">
        function validaCampos() {
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
        <h3 class="text-center mt-5">Usuário - Administração</h3><br>
        <div class="row-auto d-flex">
            <div class="col-md-7 col-sm-7">
                <img src="../imagens/logo-login.jpg" class="w-100" alt="imagens ilustrativa para login">
            </div>
            <div class="col-md-5 col-sm-5">
                <?php
                    if (isset($_POST['btnSubmitLogin'])) {
                        $usuario = $_POST['txtLogin'];
                        $senha = $_POST['txtSenha'];
                        $sql = "SELECT login, senha FROM usuarios WHERE login = '$usuario' AND senha = '$senha'";
                        if ($res=mysqli_query($con,$sql)) {
                            $linhas = mysqli_affected_rows($con);
                            if ($linhas > 0) {
                                ?>
                                <div class="alert alert-success" role="alert">
                                    <h3 class="text-center">Login efetuado com sucesso!</h3>
                                </div>
                            <?php
                            }else{ ?>
                                 <div class="alert alert-danger" role="alert">
                                    <h3 class="text-center">Usuário ou senha inválida!</h3>
                                    <a href="login.php" class="alert-link" target="_self">Voltar</a>
                                </div>
                            <?php
                            }
                            }else{
                                echo '<h3>Erro ao executar a Query!</h3>';
                            }
                        }else{
                    ?>
                    <form name="fmLogin" method="post" action="login.php" onsubmit="return validaCampos()"></form>
                        <h3 class="text-center">Login</h3>
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
</html>