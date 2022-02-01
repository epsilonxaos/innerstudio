{{-- Extendida del layout de front --}}
@extends('layouts.front')

@push('style')
    {{-- Aqui van estilos de esta vista --}}

    <link rel="stylesheet" href="{{asset('css/blogdetalle.css')}}">
@endpush

@section('contenido')
    <section class="blogdetalle">
        <!-- Go to www.addthis.com/dashboard to customize your tools --> <div class="addthis_inline_share_toolbox_jhna"></div>
        <div class="container contenedor">
           <div class="row blogcards">
                <div class="first-card col-12 col-sm-8 col-md-8 col-lg-6 col-xl-6  align-self-stretch">
                    <div class="card">
                        <img class="img-fluid" src="{{asset('images/blog/blog1.png')}}" alt="">
                        <div class="card-body">
                            <h5 class="card-title">Título de la nota</h5>
                            <p><span>03 de Febrero del 2019 | Bienestar</span></p>
                            <div class="card-text">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur posuere tempus maximus. Maecenas vulputate mauris nec erat lobortis, vitae maximus arcu tincidunt. Curabitur hendrerit sem id ipsum maximus tincidunt. Quisque vitae leo vitae orci hendrerit aliquet feugiat id ligula. Donec eu suscipit dolor. Nullam non mi magna. Aenean consectetur eu nunc id feugiat. Mauris in mi dui. Curabitur ac augue velit. 
                                </p>
                                <p>
                                    Donec interdum facilisis libero, non laoreet mauris condimentum vitae. Nullam pharetra libero eu urna bibendum elementum. Curabitur ullamcorper mi id ante ullamcorper egestas. Pellentesque eu turpis vitae lacus dapibus aliquam. Mauris risus mauris, molestie sit amet cursus mollis, euismod sit amet urna. Nunc consequat fermentum nibh nec eleifend.
                                </p>
                                <p>
                                    Donec et leo sit amet lorem suscipit sagittis non sit amet sem. Nunc convallis egestas neque, quis imperdiet tortor eleifend sed. Aliquam vitae velit nibh. Curabitur eu sodales diam. Morbi fermentum nisl eget justo blandit, at lacinia massa aliquam. Duis vitae pretium dui. Nulla blandit euismod nibh. Cras dictum varius augue, id pharetra quam faucibus consequat.
                                </p>
                            </div>
                            <div class="card-text">
                                <img class="img-fluid mt-4 mb-4" src="{{asset('images/blog/blog3.png')}}" alt="">
                                <p>
                                    Donec interdum facilisis libero, non laoreet mauris condimentum vitae. Nullam pharetra libero eu urna bibendum elementum. Curabitur ullamcorper mi id ante ullamcorper egestas. Pellentesque eu turpis vitae lacus dapibus aliquam. Mauris risus mauris, molestie sit amet cursus mollis, euismod sit amet urna. Nunc consequat fermentum nibh nec eleifend.
                                </p>
                                <p>
                                    Donec et leo sit amet lorem suscipit sagittis non sit amet sem. Nunc convallis egestas neque, quis imperdiet tortor eleifend sed. Aliquam vitae velit nibh. Curabitur eu sodales diam. Morbi fermentum nisl eget justo blandit, at lacinia massa aliquam. Duis vitae pretium dui. Nulla blandit euismod nibh. Cras dictum varius augue, id pharetra quam faucibus consequat.
                                </p>
                            </div>
                            <!-- /.card-text -->
                        </div>
                    </div>
                  
                </div>
                <div class="second-card col-12 col-sm-4 col-md-4 col-lg-3 col-xl-3  align-self-stretch">
                    <div class="buscador">
                        <form action="">
                            <input type="search" name="buscar" id="buscar" placeholder="Buscar">
                            <i class="fas fa-search"></i>
                        </form>
                    </div>
                    <div class="categorias mt-5">
                        <h4>Categorías</h4>
                        <hr class="border-decoration">
                        <ul>
                            <li><a href="#">Categoría 1</a></li>
                            <li><a href="#">Categoría 2</a></li>
                            <li><a href="#">Categoría 3</a></li>
                            <li><a href="#">Categoría 4</a></li>
                        </ul>
                    </div>
                    <div class="posts mt-5">
                        <div class="col-12 p-0">
                            <h4>Posts Recientes</h4>
                            <hr class="border-decoration">
                        </div>
                        <div class="card col-12 p-0 mt-4">
                            <img class="img-fluid" src="{{asset('images/blog/blog2.png')}}" alt="">
                            <div class="card-body">
                                <h5 class="card-title">Título de la nota</h5>
                                <p class="card-text">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sed sapien et massa scelerisque vulputate vel vitae massa.
                                </p>
                                <button class="button"><a href="#">Leer más</a></button>
                            </div>
                        </div>
                        <div class="card col-12 p-0 mt-4">
                            <img class="img-fluid" src="{{asset('images/blog/blog2.png')}}" alt="">
                            <div class="card-body">
                                <h5 class="card-title">Título de la nota</h5>
                                <p class="card-text">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sed sapien et massa scelerisque vulputate vel vitae massa.
                                </p>
                                <button class="button"><a href="#">Leer más</a></button>
                            </div>
                        </div>
                    </div>
                </div>
           </div>
        </div>
 
    </section>
@endsection

@push('js')

    {{-- Aqui van los scripts para esta vista     --}}

<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5dd0403a34c733ea"></script>


@endpush
