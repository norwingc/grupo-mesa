@extends('templates.maintemplate')
@section('imgfacebook')
	<?php 
		$imagen = DB::table('propiedades_img')->where('id_propiedad', '=', $propiedad->id )->first();  
		if(!$imagen)$imagen = 'noimage.jpg';
		else $imagen = $imagen->ruta;		
	?>
	<meta property="og:title" content="{{$propiedad->titulo}}" />
	<meta property="og:image" content="{{ asset('upload/'. $imagen .'') }}">
	<meta property="og:image:type" content="image/jpg" />
	<meta property="og:description" content="{{$propiedad->descripcion}}" />
	<meta property="og:url" content="{{Request::url()}}" />
	<meta property="og:locale:alternate" content="es_NI" />


	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:site" content="@grupomesagt">
	<meta name="twitter:creator" content="@grupomesagt">
	<meta name="twitter:title" content="{{$propiedad->titulo}}">
	<meta name="twitter:description" content="{{$propiedad->descripcion}}">
	<meta name="twitter:image:src" content="{{ asset('upload/'. $imagen .'') }}">
	<meta name="twitter:url" content="{{Request::url()}}" />

	<meta itemprop="name" content="{{$propiedad->titulo}}">
	<meta itemprop="description" content="{{$propiedad->descripcion}}">
	<meta itemprop="image" content="{{ asset('upload/'. $imagen .'') }}">
	<meta itemprop="url" content="{{Request::url()}}" />
@stop
@section('vistacasa')

<div class="col-md-7">

	<h2 class="titulovista" align="center">{{$propiedad->titulo}}</h2>
	<br>
	<?php $minibanner = DB::table('propiedades_img')->where('id_propiedad','=',$propiedad->id)->get(); 
		$cont = 0;
		$count = 0;
	?>
	@if(!$minibanner)
		<img src="{{ asset('img/noimage.jpg') }}" class="img-responsive">
	@else
		<div id="mini_carousel" class="carousel slide yeyo" data-pause="true">
			{{-- NO JODAN COMO SIEMPRE NO IDENTAN LA MIERDA --}}
			<!-- Indicators -->		
			<ol class="carousel-indicators">
				@foreach($minibanner as $value1)
					@if($count == 0)
						<li data-target="#mini_carousel" data-slide-to="0" class="active"></li>
						<?php $count++; ?>
					@else
						<?php $count++; ?>
						<li data-target="#mini_carousel" data-slide-to="{{$count-1}}"></li>			
					@endif			
				@endforeach						                                                    
			</ol>		
			<div class="carousel-inner yeyo">
				@foreach($minibanner as $value)
					@if($cont == 0)
						<div class="item active">
							<img class="" src="{{ asset('upload/'. $value->ruta .'') }}" alt="...">
							<?php $cont++; ?>                          
						</div>	
					@else
						<div class="item">
							<img class="" src="{{ asset('upload/'. $value->ruta .'') }}" alt="..."> 	                
						</div>	
					@endif			
				@endforeach               
			</div>
			<!-- Controls -->
			<a class="left carousel-control" href="#mini_carousel" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left"></span>
			</a>
			<a class="right carousel-control" href="#mini_carousel" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right"></span>
			</a>
		</div>
	@endif


	@if($propiedad->url != '')
<br>

	<iframe class="youtube-player video" type="text/html" width="100%" src="http://www.youtube.com/embed/{{$propiedad->url}}" frameborder="0"></iframe>
@endif
	<input type="hidden" value="{{$propiedad->latitud}}" id="latitud">	
	<input type="hidden" value="{{$propiedad->longitud}}" id="longitud">
	<br>
	<div id="map" style="height:300px;"></div>

</div>
<br><br>
<div class="col-md-5">
	
	<h3 align="center">Información</h3>
	<hr>
		<h4>{{$propiedad->tipoanuncio}} de {{$propiedad->tipopropiedad}}</h4>
		


	<div id="precio">

		<?php
			$valor = " ";
			if($propiedad->moneda == 'Dolares'){
				$valor="U$";
			}else{
				$valor="C$";
			}

		?>

		@if($propiedad->tipoanuncio == 'Venta')
			<strong> Precio Venta: {{$valor}} {{$propiedad->precioventa}}</strong><br>
		@elseif($propiedad->tipoanuncio == 'Alquiler')
			<strong> Precio Alquiler: {{$valor}} {{$propiedad->precioalquiler}}</strong>
			<strong> {{ $propiedad->tiempo }}</strong><br>
		@else
			<strong> Precio Venta: {{$valor}} {{$propiedad->precioventa}}</strong><br>
			<strong> Precio Alquiler: {{$valor}} {{$propiedad->precioalquiler}}</strong>
			<strong> {{ $propiedad->tiempo }}</strong><br>
		@endif

		
		<strong>Código de Propiedad: {{$propiedad->codigo}}</strong><br>
			
			<?php $dep = DB::table('depto')->where('id','=',$propiedad->departamento)->first();?>
			<?php $mun = DB::table('municipio')->where('id','=',$propiedad->municipio)->first();?>
			
				Estado: {{ $propiedad->estadofisico }} <br>
				Año Construcción: {{ $propiedad->anocontruccion }} <br>
				Área Construcción: {{ $propiedad->areautil}} {{$propiedad->medidaconstruccion}} <br>
				Área Terreno: {{ $propiedad->areaterreno}} {{$propiedad->medidaterreno}} <br> 
				Cuartos: {{ $propiedad->cuartos }} <br>
				Baños: {{ $propiedad->banos }} <br>
				Garajes: {{ $propiedad->garaje }} <br>
				País: {{ $propiedad->pais }}<br>
				Departamento: {{ $dep->opcion }} <br>
				Municipio: {{ $mun->opcion }} <br>
				Zona: {{ $propiedad->zona }} <br>
			
		
	</div>



	<div class="row">
	<h3 align="center">Otras Caracteristicas</h3>
	<hr>
		
		<div class="col-md-5">

			<ul class="casades">			
				<?php 
					$detail = explode(",", $propiedad->detallecasa);
				?>

				@foreach($detail as $value)				
					<li class="desc">{{ $value }} </li>
				@endforeach
			</ul>
		</div>
	

	</div>

	<div class="row">
	<h3 align="center">Descripción</h3>
	<hr>
		<p>{{$propiedad->descripcion}}</p> 
	</div>
	

<div class="row">
<h3 align="center">Compartir</h3>
	<hr>
<span class='st_facebook_large' displayText='Facebook'></span>
<span class='st_twitter_large' displayText='Tweet'></span>
<span class='st_linkedin_large' displayText='LinkedIn'></span>
<span class='st_googleplus_large' displayText='Google +'></span>

{{-- ---------------------------------------------------------------------------------------------------------------------------------- --}}
<a id="mailshare" href="" data-toggle="modal" data-target="#myModalshare"><img  class="correo" src="{{asset ('img/correo.jpg') }}" width="40" ></a>
	

<!-- Modal -->
<div class="modal fade" id="myModalshare" tabindex="-1" style="margin-top:2em !important" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Comparte con un Amigo</h4>
			</div>
			<div class="modal-body">
				{{ Form::open(array('url' => 'send/shareemailcasa', 'method' => 'POST', 'class'=> 'form-horizontal'), array('role' => 'form')) }}

				<div class="form-group">
					<label class="col-lg-2 control-label">Nombre</label>
					<div class="col-lg-10">
						<input required type="text" class="form-control" placeholder="Nombre y Apellido" name="nombre1">
					</div>
				</div>

				<div class="form-group">
					<label class="col-lg-2 control-label">E-mail</label>
					<div class="col-lg-10">
						<input required type="email" class="form-control" placeholder="Escriba su Correo" name="email1">
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-lg-2 control-label">Enviar a</label>
					<div class="col-lg-10">
						<input required type="text" class="form-control" placeholder="Nombre del Destinatario" name="nameto">
					</div>
				</div>

				<div class="form-group">
					<label class="col-lg-2 control-label">E-mail</label>
					<div class="col-lg-10">
						<input required type="email" class="form-control" placeholder="Correo del Destinatario" name="emailto">
					</div>
				</div>

				<div class="form-group">
					<label class="col-lg-2 control-label">Mensaje</label>
					<div class="col-lg-10">
						<textarea required class="form-control" rows="2" name="mensaje1"></textarea>
					</div>
				</div>
				
				<div>
				    <input name="idshare" type="hidden" value="{{$propiedad->id}}">
				    <input name="tiposhare" type="hidden" value="{{$propiedad->tipoanuncio}} de {{$propiedad->tipopropiedad}}">
				    <input name="tituloshare" type="hidden" value="{{$propiedad->titulo}}">
				    <input name="descshare" type="hidden" value="{{$propiedad->descripcion}}">
				    <input name="banosshare" type="hidden" value="{{$propiedad->banos}}">
				    <input name="cuartosshare" type="hidden" value="{{$propiedad->cuartos}}">
				    <input name="terrenoshare" type="hidden" value="{{$propiedad->areaterreno}}">
				    <input name="urlshare" type="hidden" value="{{Request::url()}}#ContenidoPrincipal">
				    <input name="medidashare" type="hidden" value="{{$propiedad->medidaterreno}}">
				    
                    <input name="pvtashare" type="hidden" value="{{$valor}} {{$propiedad->precioventa}}">
                    <input name="palshare" type="hidden" value="{{$valor}} {{$propiedad->precioalquiler}} {{$propiedad->tiempo}}">
                    <input name="anuncioshare" type="hidden" value="{{$propiedad->tipoanuncio}}">
				    
				    <input name="detalleshare" type="hidden" value="{{$propiedad->detallecasa}}">
				</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				{{ Form::submit('Enviar' , array('class'=> 'btn btn-primary', 'data-toggle' => 'modal',  'data-target' => '#myEmailModal')) }}
			</div>
			{{ Form::close() }}
		</div>
	</div>
</div>

<!---------------------------------------------------------------------------------------------------------------------------------->

<hr>
<!--
      <div class="socialtwitter">
        <a href="https://twitter.com/share" data-count="horizontal" class="twitter-share-button" data-via="grupomesagt" data-lang="es" data-hashtags="megustapropiedad"></a>

        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
        </script>

      </div>
      <img src="{{asset ('img/correo.jpg') }}">
      <div class="socialgoogle">
            
          <script src="https://apis.google.com/js/platform.js" async defer>
            {lang: 'es-419'}
          </script>

          
          <div class="g-plus" data-action="share" data-annotation="none"></div>
      </div>


      <div class="socialfacebook">
        <div class="fb-share-button" data-layout="button"></div>


  		<div id="fb-root"></div>
		<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.0";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>
      </div>



      <div class="sociallinkedin">

        <script src="//platform.linkedin.com/in.js" type="text/javascript">
            lang: es_ES
        </script>
        <script type="IN/Share"></script>
      </div>

</div>
-->
<button id="interesa" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Contactar al Asesor</button>	

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" style="margin-top:2em !important" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Me interesa esta Propiedad</h4>
			</div>
			<div class="modal-body">
				{{ Form::open(array('url' => 'send/emailcasa', 'method' => 'POST', 'class'=> 'form-horizontal'), array('role' => 'form')) }}

				<div class="form-group">
					<label class="col-lg-2 control-label">Nombre</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" placeholder="Nombre y Apellido" name="nombre">
					</div>
				</div>

				<div class="form-group">
					<label class="col-lg-2 control-label">E-mail</label>
					<div class="col-lg-10">
						<input type="email" class="form-control" placeholder="Correo Electronico" name="email">
					</div>
				</div>

				<div class="form-group">
					<label class="col-lg-2 control-label">Telefono</label>
					<div class="col-lg-10">
						<input type="tel" class="form-control" placeholder="Telefono" name="telefono">
					</div>
				</div>

				<div class="form-group">
					
					<div class="col-lg-10">
						<input type="hidden" class="form-control"  name="id_propiedad" value="{{$propiedad->codigo}}">
					</div>
				</div>

				<div class="form-group">
					<label class="col-lg-2 control-label">Mensaje</label>
					<div class="col-lg-10">
						<textarea class="form-control" rows="9" name="mensaje"></textarea>
					</div>
				</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				{{ Form::submit('Enviar' , array('class'=> 'btn btn-primary')) }}
			</div>
			{{ Form::close() }}
		</div>
	</div>
</div>

<!-- Mensaje Modal -->
<div class="modal fade" id="myEmailModal" tabindex="-1" style="margin-top:2em !important" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>                     </button>
				<h4 class="modal-title" id="myModalLabel">Mensaje</h4>
			</div>
			<div class="modal-body">
				SU MENSAJE FUE ENVIADO, GRACIAS POR COMPARTIR ESTA PROPIEDAD.
		    </div>
        </div>
    </div>
</div>



@stop

@section('js')
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDY0kkJiTPVd2U7aTOAwhc9ySH6oHxOIYM&sensor=false"></script>
<script>

	var lat = null;
	var lng = null;
	var map = null;
	var geocoder = null;
	var marker = null;
	$(document).ready(function(){
	     //obtenemos los valores en caso de tenerlos guardados en la BD
	     lat = $('#latitud').val();
	     lng = $('#longitud').val();

	     initialize();	
	 });     

	function initialize() {

		geocoder = new google.maps.Geocoder(); 

       //Si hay valores creamos un objeto Latlng
       if(lat !='' && lng != '')
       {
       	var latLng = new google.maps.LatLng(lat,lng);
       }
       else
       {
        //Si no creamos el objeto con una latitud cualquiera 
        var latLng = new google.maps.LatLng(12.13282,-86.2504);
    }

    var myOptions = {
          center: latLng,//centro del mapa
          zoom: 15,//zoom del mapa
          mapTypeId: google.maps.MapTypeId.ROADMAP, //tipo de mapa, carretera, satelite etc etc
          draggable: false
      };
        //creamos el mapa con las opciones anteriores y le pasamos el elemento div
        map = new google.maps.Map(document.getElementById("map"), myOptions);

        marker = new google.maps.Marker({
            map: map,//el mapa ya creado
            position: latLng,//objeto con latitud y longitud
            draggable: false //que el marcador se pueda arrastrar
        });
    }     

</script>

<script>
	(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.0";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));

</script>

<script src="https://apis.google.com/js/platform.js" async defer>
	{lang: 'es'}
</script>
<script>
	!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "6554add6-04f5-48f4-addd-fc65271d2e55", doNotHash: false, doNotCopy: false, hashAddressBar: true});</script>

@stop

