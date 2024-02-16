<!DOCTYPE html>
<html>
<head>
    <?php
        include_once "header.html";
        include_once "../mais/conexao.php";
        include_once "../mais/funcoes.php";
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
                        $salt = geraSalt();

                        $sql = "CALL sp_cadastra_usuario('$nome','$login','$email','$senha','$salt','$nivel',@saida,@rotulo)";

                        executaQuery($sql, "usuariosAdm.php");

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
                        <div class="row">
                            <?php
                                $sql = "SELECT * FROM vw_usuarios";
                                if ($res=mysqli_query($con,$sql)) {

                                    $nomeUsuario = array();
                                    $codigousuario = array();
                                    $i = 0;

                                    while($reg=mysqli_fetch_assoc($res)) {
                                        $nomeUsuario[$i] = $reg['nome_usuario'];
                                        $codigoUsuario[$i] = $reg['codigo_usuario'];
                                        ?>
                                        <div class="col-md-4 itensCadastrados text-center">
                                            <h4><?php echo $nomeUsuario[$i]." codigo: ".$codigoUsuario[$i]; ?></h4>
                                            <div class="btn-group" role="group" aria-label="Basic sample">
                                                <a href="#" class="btn btn-primary">Editar</a>
                                                <a href="#" class="btn btn-danger">Excluir</a>
                                            </div>
                                        </div>

                                        <?php
                                        $i++;
                                    }
                                }
                            
                            ?>
                        </div>   
                    </div>
                </div>

                <?php
                }
                ?>       
            </div>
        </div>
    </main>

<script src="https://kit.fontawesome.com/4bb29d1df9.js" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous">
</script>

<?php if(isset($con)){ mysqli_close($con); } ?>
</body>
</html>