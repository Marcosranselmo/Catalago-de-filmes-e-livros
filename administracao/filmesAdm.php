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
            <!-- MENU LATERAL -->
                <div class="col-md-3 col-sm-3">
                    <?php include_once "menuAdm.html"; ?>
                </div>
            <!-- //MENU LATERAL -->
           
            
        </div>
    </main>
    <!-- //PRINCIPAL -->

    <script src="https://kit.fontawesome.com/4bb29d1df9.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</body>

</html>