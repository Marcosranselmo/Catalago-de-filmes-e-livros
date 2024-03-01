<!doctype html>
<html lang="pt-br">

<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if (isset($_SESSION['acesso'])) {
        echo $_SESSION['usuario'];
    }
?>

<head>
    <?php 
    include "./header.html"; 
    include "./mais/conexao.php";
?>
    <title>Home</title>
</head>

<body>
    <!-- MENU SUPERIOR -->
    <?php include "./administracao/menuSuperior.html" ?>
    <!-- //MENU SUPERIOR -->

    <!-- SLIDER -->
    <?php include "slide.php" ?>
    <!-- //SLIDER -->

    <!-- CORPO PRINCIPAL -->
    <h2 class="text-center mt-5 mb-5">Filmes em Destaque</h2>
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-lg-3 col-sm-3">
                <div class="card">
                    <img src="imagens/imgatores/ator1.jpg" alt="" class="card-img-top">
                    <div class="card-body">
                        <h3 class="card-title">Nome do(a) Ator(a)</h3>
                        <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            Iusto ea delectus non consequatur culpa autem soluta maiores tempora. Id culpa dicta
                            rerum cupiditate libero distinctio pariatur beatae fuga quod deleniti.
                        </p>
                        <a href="#" class="btn btn-primary w-100">Saiba mais</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-3">
                <div class="card">
                    <img src="imagens/imgatores/ator2.jpg" alt="" class="card-img-top">
                    <div class="card-body">
                        <h3 class="card-title">Nome do(a) Ator(a)</h3>
                        <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            Iusto ea delectus non consequatur culpa autem soluta maiores tempora. Id culpa dicta
                            rerum cupiditate libero distinctio pariatur beatae fuga quod deleniti.
                        </p>
                        <a href="#" class="btn btn-primary w-100">Saiba mais</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-3">
                <div class="card">
                    <img src="imagens/imgatores/ator3.jpg" alt="" class="card-img-top">
                    <div class="card-body">
                        <h3 class="card-title">Nome do(a) Ator(a)</h3>
                        <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            Iusto ea delectus non consequatur culpa autem soluta maiores tempora. Id culpa dicta
                            rerum cupiditate libero distinctio pariatur beatae fuga quod deleniti.
                        </p>
                        <a href="#" class="btn btn-primary w-100">Saiba mais</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-3">
                <div class="card">
                    <img src="imagens/imgatores/ator4.jpg" alt="" class="card-img-top">
                    <div class="card-body">
                        <h3 class="card-title">Nome do(a) Ator(a)</h3>
                        <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            Iusto ea delectus non consequatur culpa autem soluta maiores tempora. Id culpa dicta
                            rerum cupiditate libero distinctio pariatur beatae fuga quod deleniti.
                        </p>
                        <a href="#" class="btn btn-primary w-100">Saiba mais</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-3">
                <div class="card">
                    <img src="imagens/imgatores/ator5.jpg" alt="" class="card-img-top">
                    <div class="card-body">
                        <h3 class="card-title">Nome do(a) Ator(a)</h3>
                        <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            Iusto ea delectus non consequatur culpa autem soluta maiores tempora. Id culpa dicta
                            rerum cupiditate libero distinctio pariatur beatae fuga quod deleniti.
                        </p>
                        <a href="#" class="btn btn-primary w-100">Saiba mais</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-3">
                <div class="card">
                    <img src="imagens/imgatores/ator6.jpg" alt="" class="card-img-top">
                    <div class="card-body">
                        <h3 class="card-title">Nome do(a) Ator(a)</h3>
                        <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            Iusto ea delectus non consequatur culpa autem soluta maiores tempora. Id culpa dicta
                            rerum cupiditate libero distinctio pariatur beatae fuga quod deleniti.
                        </p>
                        <a href="#" class="btn btn-primary w-100">Saiba mais</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- //CORPO PRINCIPAL -->

    <!-- DIRETORES POPULARES -->
    <hr>
    <div class="container">
        <div id="bannerDiretores" class="carousel slide container" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active card mb-3">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img src="imagens/imgdiretores/diretor1.jpg" class="card-img" alt="">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h3 class="card-title">Nome do(a) Diretor(a)</h3>
                                <p class="card-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                                    Magni eius consectetur, error ipsam distinctio repellendus deserunt delectus nostrum
                                    nobis laudantium dolores animi excepturi iste corrupti necessitatibus ipsa iure aut
                                    quia.
                                </p>
                                <a href="#" class="btn btn-success">Saiba mais...</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item active card mb-3">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img src="imagens/imgdiretores/diretor2.jpg" class="card-img" alt="">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h3 class="card-title">Nome do(a) Diretor(a)</h3>
                                <p class="card-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                                    Magni eius consectetur, error ipsam distinctio repellendus deserunt delectus nostrum
                                    nobis laudantium dolores animi excepturi iste corrupti necessitatibus ipsa iure aut
                                    quia.
                                </p>
                                <a href="#" class="btn btn-success">Saiba mais...</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item active card mb-3">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img src="imagens/imgdiretores/diretor3.jpg" class="card-img" alt="">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h3 class="card-title">Nome do(a) Diretor(a)</h3>
                                <p class="card-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                                    Magni eius consectetur, error ipsam distinctio repellendus deserunt delectus nostrum
                                    nobis laudantium dolores animi excepturi iste corrupti necessitatibus ipsa iure aut
                                    quia.
                                </p>
                                <a href="#" class="btn btn-success">Saiba mais...</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="carousel-indicators">
                <button type="button" data-bs-target="#bannerDiretores" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#bannerDiretores" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#bannerDiretores" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
        </div>
    </div>
<!-- //DIRETORES POPULARES -->

<!-- // PRINCIPAL -->

<!-- FOOTER -->
<?php include_once "footer.html" ?>
<!-- //FOOTER -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"crossorigin="anonymous"></script>

    <?php if (isset($con)) {mysqli_close($con); } ?>        
</body>


</html>