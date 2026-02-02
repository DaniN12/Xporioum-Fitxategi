@extends('layout.masterpage')
@section('title',__('titles.home'))
@section('content')
<div class="container-fluid p-0 wow fadeIn" data-wow-delay="0.1s">
    <div class="owl-carousel header-carousel py-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="carousel-text">
                        <h1 class="display-1 text-uppercase mb-3">La Arepa: Sabores Que Nos Unen</h1>
                        <p class="fs-5 mb-5">Celebramos la tradición, el sabor auténtico y la pasión por preparar arepas que conquistan a quienes las prueban.</p>
                        <div class="d-flex">
                            <a class="btn btn-primary py-3 px-4 me-3" href="#!">Ordenar Ahora</a>
                            <a class="btn btn-secondary py-3 px-4" href="#!">Ver Menú</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="carousel-img">
                        <img class="w-100" src="img/carousel-1.jpg" alt="Imagen de arepa">
                    </div>
                </div>
            </div>
        </div>

        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="carousel-text">
                        <h1 class="display-1 text-uppercase mb-3">Arepas Para Todos Los Gustos</h1>
                        <p class="fs-5 mb-5">De reina pepiada a pabellón, nuestras arepas están hechas con ingredientes frescos y el auténtico sabor que te hace volver.</p>
                        <div class="d-flex mt-4">
                            <a class="btn btn-primary py-3 px-4 me-3" href="#!">Ordenar Ahora</a>
                            <a class="btn btn-secondary py-3 px-4" href="#!">Descubrir Sabores</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="carousel-img">
                        <img class="w-100" src="img/carousel-2.jpg" alt="Imagen de arepa">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Carousel End -->
@endsection



