<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

	<title>Protestos Brasil</title>

	<!-- Compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="/assets/style.css">
</head>
<body>

	<div class="container-flex">
		<div class="row">
			<div class="col s12 background">		
				<div class="container">
					<nav>
						<div class="nav-wrapper">						
							<ul id="nav-mobile" class="right hide-on-med-and-down">
								<li>
									<a class="modal-trigger" href="#modal1">Cadastrar Protesto</a>
								</li>
								<li>
									<a href="badges.html">Colabore</a>
								</li>
									<li>
									<a href="collapsible.html">Contato</a>
								</li>
							</ul>
						</div>
					</nav>

					<!-- Page Content goes here -->
					<h1>Democracia nas Ruas</h1>

					<div class="row">
						<div class="input-field col s12">
							<input id="search" type="text" class="validate">
							<label for="search">Procurar Protesto</label>
						</div>
					</div>
					<div class="row">
						
						<div class="input-field col s6">
							<select>
								<option value="">Escolha o estado</option>
								<option value="1">Option 1</option>
								<option value="2">Option 2</option>
								<option value="3">Option 3</option>
							</select>
							<label>Filtro de Estado</label>
						</div>

						<div class="input-field col s6">
							<select multiple>
								<option value="">Escolha a cidade</option>
								<option value="1">Option 1</option>
								<option value="2">Option 2</option>
								<option value="3">Option 3</option>
							</select>
							<label>Filtro de Cidade</label>
						</div>

					</div>

					<div class="row">
					 	<div class="col s12 text-center">
							<a class="waves-effect waves-light btn-large red">Procurar</a>
						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="row">
			<?php for ($i = 0; $i < 8; $i++): ?>
			<div class="col s12 m3">
				<div class="card blue-grey darken-1">
		            <div class="card-image">
		            	<img src="https://d3oilk4eevknv6.cloudfront.net/newsweb/mediatools/image/image/000/001/814/464_1280x853_282157931_900x600.jpg">
		            </div>
					<div class="card-content white-text">
						<span class="card-title">Defesa a escola publica</span>
						<p>Por Mídia NINJA com colaboração do estudante Nathan Follmann, um dos líderes do movimento de ocupação na cidade.</p>
					</div>
					<div class="card-action text-right">
						<a class="waves-effect waves-light btn-floating blue darken-1"><i class="fa fa-eye"></i></a>
						<a class="waves-effect waves-light btn-floating blue darken-2 cicle"><i class="fa fa-twitter"></i></a>
						<a class="waves-effect waves-light btn-floating blue darken-3 cicle"><i class="fa fa-facebook"></i></a>
						<a class="waves-effect waves-light btn-floating red cicle"><i class="fa fa-google-plus-official"></i></a>
					</div>
				</div>
			</div>
			<?php endfor; ?>
		</div>

		<div class="row">            
			<div class="col s12 grey lighten-4 footer">
				<p>Projeto independente apoiado pela empresa <a href="http://www.ciawn.com.br">CiaWN</a> </p>
			</div>
		</div>
	</div>

	<!-- Modal Structure -->
	<div id="modal1" class="modal">
		<div class="modal-content">
		  	<h4>Cadastrar Evento</h4>
		  	<p>Insira as informações no formulario abaixo</p>
		</div>

		<div class="modal-body">
			<div class="row">
			    <form class="col s12">
			      <div class="row">
			        <div class="input-field col s12">
			          <input placeholder="Titulo" id="title" type="text" class="validate">
			          <label for="title">Digite um titulo</label>
			        </div>
			      </div>
			      <div class="row">
			      	<div class="input-field col s12">
				      	<textarea id="description" class="validate materialize-textarea"></textarea>
				      	<label for="description">Digite uma descrição</label>
				    </div>
			      </div>
			      <div class="row">
			        <div class="input-field col s4">
			          <input placeholder="Endereço" id="street" type="text" class="validate">
			          <label for="street">Digite o endereço do evento</label>
			        </div>
			        <div class="input-field col s4">
			          <input placeholder="Número" id="number" type="text" class="validate">
			          <label for="street">Digite o número aproximado do evento</label>
			        </div>
			        <div class="input-field col s4">
			          <input placeholder="Bairro" id="neighborhood" type="text" class="validate">
			          <label for="street">Digite o bairro do evento</label>
			        </div> 
			      </div>
			      <div class="row">
			        <div class="input-field col s4">
			          <input placeholder="CEP" id="postal_code" type="text" class="validate">
			          <label for="postal_code">Digite o cep do evento</label>
			        </div>
			        <div class="input-field col s4">
			          <input placeholder="Complemento" id="complement" type="text" class="validate">
			          <label for="complement">Digite o complemento do evento</label>
			        </div>
			        <div class="input-field col s4">
			          <input placeholder="Referencia" id="reference" type="text" class="validate">
			          <label for="reference">Digite uma referencia de local do evento</label>
			        </div> 
			      </div>
			      <div class="row">
			        <div class="input-field col s6">
			          <input placeholder="Estado" id="state" type="text" class="validate">
			          <label for="state">Digite o estado do evento</label>
			        </div>
			        <div class="input-field col s6">
			          <input placeholder="Cidade" id="city" type="text" class="validate">
			          <label for="city">Digite a cidade de local do evento</label>
			        </div> 
			      </div>
			      <div class="row">
			        <div class="input-field col s4">
			          <input placeholder="Titulo do movimento" id="title" type="text" class="validate">
			          <label for="title">Titulo do movimento</label>
			        </div>
			        <div class="input-field col s4">
			          <input placeholder="Descrição" id="description" type="text" class="validate">
			          <label for="description">Digite a descrição do movimento</label>
			        </div>
			        <div class="input-field col s4">
			          <input placeholder="Facebook" id="facebook" type="text" class="validate">
			          <label for="facebook">Facebook do movimento</label>
			        </div> 
			      </div>
			      <div class="row">
			        <div class="input-field col s4">
			          <input placeholder="Twitter" id="twitter" type="text" class="validate">
			          <label for="twitter">Twitter do movimento</label>
			        </div>
			        <div class="input-field col s4">
			          <input placeholder="Site" id="site" type="text" class="validate">
			          <label for="site">Digite a site do movimento</label>
			        </div>
			        <div class="input-field col s4">
			          <input placeholder="E-mail" id="email" type="text" class="validate">
			          <label for="email">Digite o email do movimento</label>
			        </div> 
			      </div>
			      <div class="row">
			        <div class="input-field col s6">
			          <input placeholder="Twitter" id="phone1" type="text" class="validate">
			          <label for="phone1">Telefone para contato</label>
			        </div>
			        <div class="input-field col s6">
			          <input placeholder="Celular" id="phone2" type="text" class="validate">
			          <label for="phone2">Digite o celular para contato</label>
			        </div> 
			      </div>
			      <div class="row">
			        <div class="input-field col s6">
					    <div class="file-field input-field">
					      <div class="btn">
					        <span>Image</span>
					        <input type="file" id="image">
					      </div>
					      <div class="file-path-wrapper">
					        <input class="file-path validate" type="text">
					      </div>
					    </div>
			        </div>
			        <div class="input-field col s6" style="padding-top: 13px;">
  						<input type="date" id="date">
			        </div> 
			      </div>
			    </form>
			</div>
		</div>

		<div class="modal-footer" style="padding-right: 25px;">
			<a href="javascript:submitFormRegister();" class="modal-action modal-close waves-effect waves-light btn blue">Salvar</a> 
			<a href="#!" class="modal-action modal-close waves-effect waves-light btn red" style="margin-right:15px;">Cancelar</a>
		</div>
	</div>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-rc1/jquery.min.js"></script>
	
	<!-- Compiled and minified JavaScript -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script>
	<script>
		$(document).ready(function() {
			$('select').material_select();
		});

		$(document).ready(function(){
		    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
		    $('.modal-trigger').leanModal();
			});

		  $('.datepicker').pickadate({
		    selectMonths: true, // Creates a dropdown to control month
		    selectYears: 16 // Creates a dropdown of 15 years to control year
		  });
		          
	</script>
</body>
</html>