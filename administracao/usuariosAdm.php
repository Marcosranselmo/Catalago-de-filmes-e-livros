<!DOCTYPE html>
<html>
<head>
    <?php
        include_once "header.html";
        include_once "../mais/conexao.php";
    ?>
    <title>Home</title>
    
    <script type="text/javascript">
        function ValidaCampos() {
            if (document.fmUsuarios.txtNome.value == "") {
                alert("Por favor, preencha o campo Nome!");
                document.fmUsuarios.txtNome.focus();
                return false;
            }
            if (document.fmUsuarios.txtEmail.value == "") {
                alert("Por favor, preencha o campo Email!");
                document.fmUsuarios.txtEmail.focus();
                return false;
            }
            if (document.fmUsuarios.txtLogin.value == "") {
                alert("Por favor, preencha o campo Login!");
                document.fmUsuarios.txtLogin.focus();
                return false;
            }
            if (document.fmUsuarios.txtSenha1.value == "") {
                alert("Por favor, preencha o campo Senha1!");
                document.fmUsuarios.txtSenha1.focus();
                return false;
            }
            if (document.fmUsuarios.txtSenha2.value == "") {
                alert("Por favor, preencha o campo Senha2!");
                document.fmUsuarios.txtSenha2.focus();
                return false;
            }
            if (document.fmUsuarios.txtSenha1.value != document.fmUsuarios.txtSenha2.value) {
                alert("As senhas devem ser iguais!");
                document.fmUsuarios.txtSenha2.focus();
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
            <div class="col-md-3 col-sm-3 mx-3">
                <?php include_once "menuAdm.html" ?>            
            </div>
            <div class="col-md-9 col-sm-9">
                <?php
                    if (isset($_POST['btnSubmitUsuario'])) {
                        $nome = $_POST['txtNome'];
                        $email = $_POST['txtEmail'];
                        $login = $_POST['txtLogin'];
                        $senha = $_POST['txtSenha1'];
                        $nivel = $_POST['selNivel'];
                        $salt = '123';

                        $sql = "CALL sp_cadastra_usuario('$nome','$login','$email','$senha','$salt','$nivel',@saida,@rotulo)";
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
                                    <a href="usuariosAdm.php" class="alert-link" target="_self">Voltar</a>
                                </div>
                                <?php
                            } else {
                                echo "Erro ao executar a query.";
                            }
                    }else{
                ?>
      
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a href="#tabFormulario" class="nav-link active" id="linkFormulario" 
                        data-toggle="tab" role="tab" aria-controls="tabFormulario">Cadastro</a>        
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#tabExibicao" class="nav-link" id="linkExibicao" 
                        data-toggle="tab" role="tab" aria-controls="tabExibicao">Usuários</a>        
                    </li>
                </ul>

                <div class="tab-content" id="meusConteudos">
                    <div class="tab-pane fade show-active" id="tabFormulario" role="tabpanel"
                        aria-labelledby="linkFormulario">
                        
                        <h4 class="text-center mt-5">Cadastrar novo usuário</h4>  
                        <form name="fmUsuarios" method="post" action="usuariosAdm.php" onsubmit="return ValidaCampos()">
                    
                            <label>Nome:</label>
                            <input type="text" name="txtNome" class="form-control mb-2" maxlength="70">

                            <label>E-mail:</label>
                            <input type="email" name="txtEmail" class="form-control mb-2" maxlength="50" aria-describedby="emailHelp">

                            <label>Login:</label>
                            <input type="text" name="txtLogin" class="form-control mb-2" maxlength="30">

                            <label>Senha:</label>
                            <input type="password" name="txtSenha1" class="form-control mb-2" maxlength="16">

                            <label>Repita a senha:</label>
                            <input type="password" name="txtSenha2" class="form-control mb-2" maxlength="16">

                            <label>Nível de Usuário:</label>
                            <select name="selNivel" class="form-control mb-4">
                                <option value="1">1 - Administrador</option>
                                <option value="2">2 - Moderador</option>
                            </select>

                            <button type="submit" name="btnSubmitUsuario" class="btn btn-primary w-100">Cadastrar usuário</button>
                        </form> 
                    </div>
                    <div class="tab-pane fade mt-5" id="tabExibicao" role="tabpanel"
                        aria-labelledby="linkExibicao">
                        <h4 class="text-center">Usuários Cadastrados</h4>     
                    </div>
                </div>

                <?php
                }
                ?>       
            </div>
        </div>
    </main>
    <?php if(isset($con)){ mysqli_close($con); } ?>
</body>
</html>