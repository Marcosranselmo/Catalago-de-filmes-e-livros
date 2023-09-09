<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/icones/css/line-awesome.css">

    <title>Estante livros</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="shortcut icon" href="/imagens/favicon.png">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <!-- MENU SUPERIOR -->
    <nav class="navbar navbar-expand-lg bg-primary rounded" aria-label="Toggle navigation">
        <div class="container">
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#menuSuperior" aria-controls="menuSuperior" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </button>

            <div class="navbar-collapse d-lg-flex collapse" id="menuSuperior" style="">
                <a class="navbar-brand col-lg-3 me-0" href="#">Logo</a>
                <ul class="navbar-nav col-lg-6 justify-content-lg-center">
                    <li class="nav-item">
                        <a class="nav-link text-white" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" aria-disabled="true">Disabled</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown"
                            aria-expanded="false">Dropdown</a>
                        <ul class="dropdown-menu mt-2">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="d-lg-flex col-lg-3 justify-content-lg-end">
                    <button class="btn btn-primary">Button</button>
                </div>
            </div>
        </div>
    </nav>
    <!-- //MENU SUPERIOR -->

    <!-- SLIDER -->
    <div id="carouselExampleIndicators" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="./imgSlide/slider01.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="./imgSlide/slider02.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="./imgSlide/slider03.jpg" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <!-- <i class="las la-angle-left"></i> -->
            <span class="material-symbols-outlined">arrow_back_ios</span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <!-- <i class="las la-angle-right"></i> -->
            <span class="material-symbols-outlined">arrow_forward_ios</span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- //SLIDER -->

    <!-- ATORES/ATRIzES POPULARES -->
    <br>
    <h2 class="text-center">Atores/AtriZes mais buscados</h2>
    <div class="row">
        <div class="col-lg-4 col-md-6 atoresPopulares card mb-3">
            <div class="row no-gutters">
                <div class="col-md-4">

                </div>
                <div class="col-md-8">

                </div>
            </div>
        </div>
    </div>
    <!-- //ATORES/ATRIzES POPULARES -->


    <!-- FOOTER -->
    <footer class="py-3 my-4">
        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Home</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Features</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Pricing</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">FAQs</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">About</a></li>
        </ul>
        <p class="text-center text-body-secondary">© 2023 Company, Inc</p>
    </footer>
    <!-- //FOOTER -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</body>

</html>