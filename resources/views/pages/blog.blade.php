{{-- Extendida del layout de front --}}
@extends('layouts.front')

@push('style')
    {{-- Aqui van estilos de esta vista --}}

    <link rel="stylesheet" href="{{asset('css/blog.css')}}">
@endpush

@section('contenido')
    <section class="blog">
        <div class="container contenedor">

            <div class="blog-header">
                <div class="header"> 
                    <img src="{{asset('images/backgrounds/bg-noticias.jpg')}}" alt="">
                    <div class="blog-cards">
                        <h2>NOTICIAS</h2>
                    </div>
                    <div class="backgroundgradiente"></div>
                </div>
            </div>
            
            <div class="cards-categorias row">
              <div class="container">
                <div class="row justify-content-center">  
                    <div class="categorias col-10 col-sm-11 col-md-10 col-lg-5 col-xl-5 text-left">
                        <h4>Categorías</h4>
                        <ul>
                            <li><a href="#">Categoría 1</a></li>
                            <li><a href="#">Categoría 2</a></li>
                            <li><a href="#">Categoría 3</a></li>
                            <li><a href="#">Categoría 4</a></li>
                        </ul>
                    </div>
                    <div class="col-12  col-sm-6 col-md-12 col-lg-4 col-xl-4 text-right">
                        <div class="buscador">
                            <form action="">
                                <input type="search" name="buscar" id="buscar" placeholder="Buscar">
                                <i class="fas fa-search"></i>
                            </form>
                        </div>
                    </div>
                </div>
              </div>
            </div>
            <!-- /.cards-categorias -->
            
            <div class="container">
                <div class="row justify-content-center">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 p-0 m-0r">
             
                            <div class="cards-information row  justify-content-center">
                                
                                <div class="card col-12 col-sm-6 col-md-5 col-lg-4 col-xl-4 p-0 mt-4">
                                        <img class="img-fluid" src="{{asset('images/blog/blog1.png')}}" alt="">
                                    <div class="card-body">
                                        <h5 class="card-title">Título de la nota</h5>
                                        <p class="card-text">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sed sapien et massa scelerisque vulputate vel vitae massa.
                                        </p>
                                        <button class="button"><a href="#">Leer más</a></button>
                                    </div>
                                </div>
                                <div class="card col-12 col-sm-6 col-md-5 col-lg-4 col-xl-4 p-0 mt-4 ">
                                    <img class="img-fluid" src="{{asset('images/blog/blog2.png')}}" alt="">
                                    <div class="card-body">
                                        <h5 class="card-title">Título de la nota</h5>
                                        <p class="card-text">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sed sapien et massa scelerisque vulputate vel vitae massa.
                                        </p>
                                        <button class="button"><a href="#">Leer más</a></button>
                                    </div>
                                </div>
                                <div class="card col-12 col-sm-6 col-md-5 col-lg-4 col-xl-4 p-0 mt-4 ">
                                    <img class="img-fluid" src="{{asset('images/blog/blog3.png')}}" alt="">
                                    <div class="card-body">
                                        <h5 class="card-title">Título de la nota</h5>
                                        <p class="card-text">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sed sapien et massa scelerisque vulputate vel vitae massa.
                                        </p>
                                        <button class="button"><a href="#">Leer más</a></button>
                                    </div>
                                </div>
                                <div class="card col-12 col-sm-6 col-md-5 col-lg-4 col-xl-4 p-0 mt-4">
                                        <img class="img-fluid" src="{{asset('images/blog/blog1.png')}}" alt="">
                                    <div class="card-body">
                                        <h5 class="card-title">Título de la nota</h5>
                                        <p class="card-text">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sed sapien et massa scelerisque vulputate vel vitae massa.
                                        </p>
                                        <button class="button"><a href="#">Leer más</a></button>
                                    </div>
                                </div>
                                <div class="card col-12 col-sm-6 col-md-5 col-lg-4 col-xl-4 p-0 mt-4">
                                    <img class="img-fluid" src="{{asset('images/blog/blog2.png')}}" alt="">
                                    <div class="card-body">
                                        <h5 class="card-title">Título de la nota</h5>
                                        <p class="card-text">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sed sapien et massa scelerisque vulputate vel vitae massa.
                                        </p>
                                        <button class="button"><a href="#">Leer más</a></button>
                                    </div>
                                </div>
                                <div class="card col-12 col-sm-6 col-md-5 col-lg-4 col-xl-4 p-0 mt-4">
                                    <img class="img-fluid" src="{{asset('images/blog/blog3.png')}}" alt="">
                                    <div class="card-body">
                                        <h5 class="card-title">Título de la nota</h5>
                                        <p class="card-text">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sed sapien et massa scelerisque vulputate vel vitae massa.
                                        </p>
                                        <button class="button"><a href="#">Leer más</a></button>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="navegacion row justify-content-center mt-5">
                                <div class="col-6 text-center">
                                    <ul>
                                        <li>
                                            <a href="#"><</a>
                                        </li>
                                        <li>
                                            <a href="#">1</a>
                                        </li>
                                        <li>
                                            <a href="#">2</a>
                                        </li>
                                        <li>
                                            <a href="#">3</a>
                                        </li>
                                        <li>
                                            <a href="#">4</a>
                                        </li>
                                        <li>
                                            <a href="#">></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                           
                        </div>
                </div>
            </div>

            <!-- /.container -->

        </div>

        <!-- /.container -->
    </section>
@endsection

@push('js')
    {{-- Aqui van los scripts para esta vista     --}}
   
@endpush
