<!doctype html>
<html lang="pt-br">

<head>
    <?php include_once "header.html" ?>
    <title>Administração</title>

</head>

<body class="adm">
    <!-- MENU SUPERIOR -->
    <?php include_once "menuSuperior.html" ?>
    <!-- //MENU SUPERIOR -->

    <!-- PRINCIPAL -->
    <main class="container mt-5">
        <h1 class="text-center">Administração</h1>
        <div class="row gy-4 mt-4">
            <div class="col-md-3 col-sm-6 opcoes text-center">
                <i class="fa-solid fa-film"></i>
                <a href="administracao/filmesAdm.php">
                    <p>Cadastrar Filmes</p>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 opcoes text-center">
                <i class="fa-solid fa-video"></i>
                <a href="administracao/filmescadastrados.php">
                    <p>Filmes Cadastrados</p>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 opcoes text-center">
                <i class="fa-solid fa-user-tie"></i>
                <a href="administracao/diretores.php">
                    <p>Diretores</p>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 opcoes text-center">
                <i class="fa-solid fa-masks-theater"></i>
                <a href="administracao/atores.php">
                    <p>Atores</p>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 opcoes text-center">
                <i class="fa-solid fa-list"></i>
                <a href="administracao/categoriasAdm.php">
                    <p>Categorias</p>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 opcoes text-center">
                <i class="fa-solid fa-sliders"></i>
                <a href="administracao/bannerprincipal.php">
                    <p>Banner Principal</p>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 opcoes text-center">
                <i class="fa-solid fa-globe"></i>
                <a href="administracao/paises.php">
                    <p>Países</p>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 opcoes text-center">
                <i class="fa-solid fa-users"></i>
                <a href="administracao/usuarios.php">
                    <p>Usuários</p>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 opcoes text-center">
                <i class="fa-solid fa-user"></i>
                <a href="administracao/minhaconta.php">
                    <p>Minha conta</p>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 opcoes text-center">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <a href="#">
                    <p>Sair</p>
                </a>
            </div>
        </div>

    </main>
    <!-- //PRINCIPAL -->

    <script src="https://kit.fontawesome.com/4bb29d1df9.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</body>

</html>