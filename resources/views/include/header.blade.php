<header>
	<div class="menu--header">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-6 col-md-3">
					<a href="{{url('/')}}" class="d-inline-block"><img class="logo" src="{{asset('images/logo/logo.svg')}}" alt="Inner"></a>
				</div>
				<div class="d-none d-sm-none d-md-block col-md-6 ">
					<ul class="menu-desk d-flex aling-items-center justify-content-between">
						<li><a href="{{url('reservar')}}" class="d-inline-block">Reservar</a></li>
						<li><a href="{{url('paquetes')}}" class="d-inline-block">Comprar</a></li>
						@if (Auth::check() && Auth::User()->type != 0)

							<li><a href="{{route('profile')}}" class="d-inline-block">Perfil</a> </li>
						@else
							<li><a href="#" data-toggle="modal" data-target="#mdLogin" class="d-inline-block">Login</a> </li>
						@endif
					</ul>
				</div>
				<div class="col-6 col-md-3">
					<ul class="redes--menu d-flex aling-items-center justify-content-end">
						{{-- <li><a href="" class="d-inline-block"><i class="fab fa-facebook-f"></i></a></li> --}}
						<li><a href="https://www.instagram.com/innerstudiomx/" target="_blank" class="d-inline-block"><i class="fab fa-instagram"></i></a></li>
						<li>
							<div class="open-menu menu-3" id="open-menu">
								<span></span>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="overlay" id="overlay">
		<ul class="menu container">
			<li><a href="{{url('reservar')}}">Reservar</a></li>
			<li><a href="{{url('terminos')}}">Faqs</a></li>
			<li><a href="{{url('paquetes')}}">Comprar</a></li>
			<li><a href="{{url('team')}}">Team</a></li>
			<li><a href="{{url('clases')}}">Clases</a></li>
			{{-- <li><a href="{{url('blog')}}">Noticias</a></li> --}}
			<li><a href="{{url('ubicacion')}}">Ubicación</a></li>
		  	@if (Auth::check() && Auth::User()->type != 0)
			  	<li><a href="{{route('profile')}}">Perfil</a></li>
			@else
				<li><a href="#" data-toggle="modal" data-target="#mdLogin" class="d-inline-block">Login</a> </li>
			@endif
		</ul>
	  </div>

	</div>
</header>