<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"><?php
	include "Pet.php"; ?> 
	<title><?php echo GAMENAME; ?></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	<style type="text/css">
		.site-header {
		  background-color: #000000;
		}
		.site-header a {
		  color: #999;
		  transition: ease-in-out color .15s;
		}
		.site-header a:hover {
		  color: #fff;
		  text-decoration: none;
		}
		.list-group-item:hover {
			background-color: #CCC;
		}
		.list-group-item {
			margin-bottom: 1px !important;
		}
	</style>
</head>
<body>

<nav class="site-header sticky-top py-1">
	<div class="container d-flex flex-column flex-md-row justify-content-between">
		<a class="py-2 d-none d-md-inline-block" href="?action=home">Página inicial</a>
		<?php if($conta->estaLogado()) { ?>
		<a class="py-2 d-none d-md-inline-block" href="?action=createPet">Criar pet</a>
		<a class="py-2 d-none d-md-inline-block" href="?action=selectPet">Selecionar pets</a>
		<a class="py-2 d-none d-md-inline-block" href="?action=deslogar">Sair</a>
		<?php } else  { ?>
		<a class="py-2 d-none d-md-inline-block" href="?action=login">Login</a>
		<a class="py-2 d-none d-md-inline-block" href="?action=cadastrar">Fazer cadastro</a>
		<?php } ?>

	</div>
</nav>

<?php 
	//Query string "Página inicial" ou "Selecionar pets"
	if(isset($_GET["action"])){
	if( ($_GET['action'] == NULL) || ($_GET['action'] == "selectPet") || ($_GET['action'] == "home") ) {
		$conta->protege();
?>
<div class="container">
	<div class="row">
		<div class="col-sm-12 pt-2">
			<a href="?action=createPet">
				<div class="btn btn-primary">
						Criar pet
				</div>
			</a>
			<br><br>
			<ul class="list-group">
			<?php $resultado = $conexao->listarPets(); ?>
			<?php foreach ($resultado as $item) { ?>
				
				<li class="list-group-item d-flex justify-content-between align-items-center row">
					<a href="?action=game&name=<?php echo $item["name"]; ?>" class="col-sm-10">
						<?php echo $item["name"]; ?>
					</a>
					<a href="?action=deletar&name=<?php echo $item["name"]; ?>">
						<div class="btn  btn-danger">
							Deletar
						</div>
					</a>
					<?php if($item["faliceu"] == 1) { ?>
						<span class="badge badge-danger badge-pill">Morto</span>
					<?php } ?>
				</li>
			<?php } ?>
			</ul>
		</div>
	</div>
</div>
<?php
 } elseif($_GET['action'] == "createPet") {  	?>
<?php $conta->protege(); ?>
<div class="container">
	<div class="row">
		<div class="col-sm-12 pt-2">
			<form id="criarPet" method="POST">
				<div class="form-group">
					<label for="nome">Nome do pet:</label>
					<input type="text" class="form-control" name="nome" id="nome">
				</div>
				<div id="createPetMsg" class="alert alert-info" style="display:none;">
					
				</div>
				<button type="submit" class="btn btn-primary">Criar</button>
			</form>
		</div>
	</div>
</div>
<?php
 } elseif($_GET['action'] == "login") {  	?>
<?php $conta->estaLogadoRedir(); ?>
<div class="container">
	<div class="row">
		<div class="col-sm-12 pt-2">
			<form id="logar" method="POST">
				<div class="form-group">
					<label for="usuario">Usuario:</label>
					<input type="text" class="form-control" name="usuario" id="usuario">
				</div>
				<div class="form-group">
					<label for="senha">Senha:</label>
					<input type="password" class="form-control" name="senha" id="senha">
				</div>
				<div id="createPetMsg" class="alert alert-info" style="display:none;">
					
				</div>
				<button type="submit" class="btn btn-primary">Entrar</button>
			</form>
		</div>
	</div>
</div>
<?php
 } elseif($_GET['action'] == "cadastrar") {  	?>

<?php $conta->estaLogadoRedir(); ?>
<div class="container">
	<div class="row">
		<div class="col-sm-12 pt-2">
			<form id="cadastrar" method="POST">
				<div class="form-group">
					<label for="usuario">Usuario:</label>
					<input type="text" class="form-control" name="usuario" id="usuario">
				</div>
				<div class="form-group">
					<label for="senha">Senha:</label>
					<input type="password" class="form-control" name="senha" id="senha">
				</div>
				<div class="form-group">
					<label for="email">E-mail:</label>
					<input type="email" class="form-control" name="email" id="email">
				</div>
				<div id="createPetMsg" class="alert alert-info" style="display:none;">
					
				</div>
				<button type="submit" class="btn btn-primary">Cadastrar</button>
			</form>
		</div>
	</div>
</div>
<?php
 } elseif($_GET['action'] == "deslogar") {  	?>

<?php
	$conta->deslogar();
?>
<?php
 } elseif($_GET['action'] == "deletar" && $_GET["name"]!=null) {  	?>

<?php
	$deletar = $conexao->deletarPet(trim($_GET["name"]));
	if ($deletar) {
		header('Location: ?action=selectPet');
	} else {
		echo "Houve algum erro";
	}
?>

<?php
	//Query string "game inicial"
 } elseif($_GET['action'] == "game" && $_GET["name"]!=null) {  	?>
<div class="container" id="petPainel">
	<div class="row">
		<?php 
		$dados = $conexao->getData($_GET["name"]);
		$dados = json_decode($dados, true);
		if( !$conexao->petExist($_GET["name"])) {
			echo "Este pet não existe";
		} elseif($dados["faliceu"]==1) {
		?>	
		<strong><?php echo $dados["name"]; ?> está morto</strong>
		<?php } else { ?>
		<div class="col-sm-12 row border mb-1">
			<div class="col-sm-2 mb-2">
				Felicidade
				<div class="progress">
					<div class="progress-bar bg-warning" role="progress-bar" style="width: <?php echo $dados["happy"]; ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" id="felicidade"></div>
				</div>
				<div class="justify-content-between align-items-center text-center" id="feli"><?php echo $dados["happy"]; ?>%</div>
			</div>
			<div class="col-sm-2">
				Fome
				<div class="progress">
					<div class="progress-bar bg-success" role="progress-bar" style="width: <?php echo $dados["hunger"]; ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" id="fome"></div>
				</div>
				<div class="justify-content-between align-items-center text-center" id="fom"><?php echo $dados["hunger"]; ?>%</div>
			</div>
			<div class="col-sm-2">
				Vida
				<div class="progress">
					<div class="progress-bar bg-danger" role="progress-bar" style="width: <?php echo $dados["health"]; ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" id="vida"></div>
				</div>
				<div class="justify-content-between align-items-center text-center" id="vid"><?php echo $dados["health"]; ?>%</div>
			</div>
			<div class="col-sm-2">
				Sujeira
				<div class="progress">
					<div class="progress-bar bg-info" role="progress-bar" style="width: <?php echo $dados["dirty"]; ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" id="higiene"></div>
				</div>
				<div class="justify-content-between align-items-center text-center" id="higi"><?php echo $dados["dirty"]; ?>%</div>
			</div>
			<div class="col-sm-2 text-center">
				Cansaço
				<div class="progress">
					<div class="progress-bar bg-info" role="progress-bar" style="width: <?php echo $dados["tired"]; ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" id="cansaco"></div>
				</div>
				<div class="justify-content-between align-items-center text-center" id="cansa"><?php echo $dados["tired"]; ?>%</div>
			</div>
			<div class="col-sm-2"><strong>Nome do pet:</strong> <span id="nomePet"><?php echo $dados["name"]; ?></span>
			</div>

			<!--<div class="col-sm-2 text-center">
				<div class="dropdown">
					<button class="btn btn-secondary dropdown-toggle" type="button">
						Opções
					</button>
				</div>
				-->
			</div>
		</div>
		<div class="col-sm-12 row border mb-1">
			<img src="algumaImagemDePet" class="img-responsive mx-auto d-block" style="max-height: 400px" id="ibagem">
		</div>
		<div class="col-sm-12 row text-center">
			<div class="col-sm-1"></div>
			<div class="col-sm-2">
				<div class="btn btn-primary" id="alimentar">
					Alimentar
				</div>
			</div>
			<div class="col-sm-2">
				<div class="btn btn-primary limpar" id="limpar">
					Lavar
				</div>
			</div>
			<div class="col-sm-2">
				<div class="btn btn-primary brincar" id="brincar">
					Brincar
				</div>
			</div>
			<div class="col-sm-2">
				<div class="btn btn-primary" id="curar">
					Curar
				</div>
			</div>
			<div class="col-sm-2">
				<div class="btn btn-primary lights" id="luzes">
					Desligar luzes
				</div>
			</div>
			<div class="col-sm-1"></div>
		</div>
	<?php } ?>
	</div>
</div>
<?php  } }?>

</body>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
	function pegarDados(nome, user_id)
	{
		$.ajax({
			type: "POST",
			url: "Pet.php",
			data: {
				act: "pegardados",
				nome: nome
			},
			success: function(response){
				dados = $.parseJSON(response);
				var felicidade = dados["happy"] + "%";
				var fome = dados["hunger"] + "%";
				var vida = dados["health"] + "%";
				var higiene = dados["dirty"] + "%";
				var morto = dados["faliceu"];
				var cansaco = dados["tired"] + "%";
				if(morto==1) {
					$('#petPainel').replaceWith("<div class=\"container\" id=\"petPainel\"><strong>" + dados["name"] + " está morto</strong></div>")
					setTimeout(function() {
						window.location.href = "?action=selectPet";
						}, 5000);
				}
				$('#felicidade').css("width", felicidade);
				$('#feli').text(felicidade);
				$('#higiene').css("width", higiene);
				$('#higi').text(higiene);
				$('#vida').css("width", vida);
				$('#vid').text(vida);
				$('#fome').css("width", fome);
				$('#fom').text(fome);
				$('#cansaco').css("width", cansaco);
				$('#cansa').text(cansaco);
				$('#nomePet').text(dados["name"]);
				if(dados["lights"]==0) {
					$('body').css("background-color", "#000000");
					$('body').css("color", "#FFFFFF");
				} else {
					$('body').css("background-color", "#FFFFFF")
					$('body').css("color", "#000000");
				}
			},
			error: function() {
				$('#createPetMsg').text("Houve algum erro");
			}
		})
	}
	function atualizar(nome, user_id)
	{
		$.ajax({
			type: "POST",
			url: "Pet.php",
			data: {
				act: "atualizar",
				nome: nome
			},
			success: function(response){
				console.log("Atualizou");
			},
			error: function() {
				//$('#createPetMsg').text("Houve algum erro");
			}
		})
	}
	function acao(nome, user_id, acao)
	{
		$.ajax({
			type: "POST",
			url: "Pet.php",
			data: {
				act: acao,
				nome: nome
			},
			success: function(response){
				console.log("Atualizou");
			},
			error: function() {
				//$('#createPetMsg').text("Houve algum erro");
			}
		})
		pegarDados(nome,user_id);
	}
	$(document).ready(function() {
		<?php $tempoAtu = Conexao::$tempoExec * 1000; ?>
		var tempoAtualizacao = (<?php echo $tempoAtu; ?>);
		$('#felicidade').css("width", "100%");
		$('#fome').css("width", "100%");
		$('#vida').css("width", "100%");
		$('#higiene').css("width", "100%");
		<?php if($_GET['action'] == "game") { ?>
		setInterval(function(){
			atualizar("<?php echo $_GET["name"]; ?>")
		},tempoAtualizacao);
		setInterval(function(){
			pegarDados("<?php echo $_GET["name"]; ?>")
		},tempoAtualizacao);
		if(document.getElementById("nomePet")!=null)
		{
			pegarDados("<?php echo $_GET["name"]; ?>");
		}

		<?php } ?>
	});
	<?php if($_GET['action'] == "game") { ?>
	$('#alimentar').on('click', function(e){
		acao("<?php echo $_GET["name"]; ?>", <?php echo $conta->retornaId(); ?>,"alimentar");
	})
	$('#limpar').on('click', function(e){
		acao("<?php echo $_GET["name"]; ?>", <?php echo $conta->retornaId(); ?>,"limpar");
	})
	$('#brincar').on('click', function(e){
		acao("<?php echo $_GET["name"]; ?>", <?php echo $conta->retornaId(); ?>,"brincar");
	})
	$('#curar').on('click', function(e){
		acao("<?php echo $_GET["name"]; ?>", <?php echo $conta->retornaId(); ?>,"curar");
	})
	$('#luzes').on('click', function(e){
		acao("<?php echo $_GET["name"]; ?>", <?php echo $conta->retornaId(); ?>,"luzes");
	})
<?php } ?>
	$('#criarPet').submit( function(e){

		e.preventDefault();
		$.ajax({
			type: "POST",
			url: "Pet.php",
			data: {
				act: "criar",
				nome: $('#nome').val()
			},
			success: function(response){
				dados = $.parseJSON(response);
				if(dados) {
					if(dados["status"] == true ){
						$('#createPetMsg').text(dados["name"] + " criado");
						$('#createPetMsg').show("slow");
						
						setTimeout(function() {
						window.location.href = "?action=selectPet";
						}, 2000);
					} else {
						$('#createPetMsg').show("slow");
						$('#createPetMsg').text("Já existe um pet com esse nome");
					}
				} else {
					$('#createPetMsg').text("Houve algum problema ao criar, provavelmente já existe um pet com esse nome" + dados["name"]);
				}
			},
			error: function() {
				$('#createPetMsg').text("Houve algum erro");
			}
		})
	});
	$('#cadastrar').submit( function(e){

		e.preventDefault();
		$.ajax({
			type: "POST",
			url: "Pet.php",
			data: {
				act: "cadastrar",
				usuario: $('#usuario').val(),
				senha: $('#senha').val(),
				email: $('#email').val()
			},
			success: function(response){
				dados = $.parseJSON(response);
				if(dados) {
					if(dados["status"] == true ){
						$('#createPetMsg').text(dados["name"] + " criado");
						$('#createPetMsg').show("slow");
						
						setTimeout(function() {
						window.location.href = "?action=selectPet";
						}, 2000);
					} else {
						$('#createPetMsg').show("slow");
						$('#createPetMsg').text("Houve algum erro ao criar a conta, provavelmente esse usuário já existe.");
					}
				} else {
					$('#createPetMsg').text("Houve algum erro ao criar a conta, provavelmente esse usuário já existe: " + dados["name"]);
				}
			},
			error: function() {
				$('#createPetMsg').text("Houve algum erro");
			}
		})
	});
	$('#logar').submit( function(e){

		e.preventDefault();
		$.ajax({
			type: "POST",
			url: "Pet.php",
			data: {
				act: "login",
				usuario: $('#usuario').val(),
				senha: $('#senha').val()
			},
			success: function(response){
				dados = $.parseJSON(response);
				if(dados) {
					if(dados["status"] == true ){
						$('#createPetMsg').text("Entrou");
						$('#createPetMsg').show("slow");
						
						setTimeout(function() {
						window.location.href = "?action=selectPet";
						}, 2000);
					} else {
						$('#createPetMsg').show("slow");
						$('#createPetMsg').text("Usuário ou senha incorretos.");
					}
				} else {
					$('#createPetMsg').text("Houve algum erro.");
				}
			},
			error: function() {
				$('#createPetMsg').text("Houve algum erro");
			}
		})
	});

</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</html>