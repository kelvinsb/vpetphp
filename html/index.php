<?php
	include "Pet.php"; ?> 
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">	
	<title><?php echo GAMENAME; ?></title>
	<link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	<link href="css/pet.css" rel="stylesheet">
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
		<a class="py-2 d-none d-md-inline-block" href="?action=ranking">Ranking</a>
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
		if( ($_GET['action'] == NULL)) {
			$conta->protege();
			die();
		}
?>
<?php if(($_GET['action'] == "selectPet") || ($_GET['action'] == "home")) {
	include "views/inicial.php";	
?>
<?php //--------------------------------------------------------- ?>
<?php
 } elseif($_GET['action'] == "createPet") {  	?>
<?php include "views/createPet.php"; ?>
<?php //--------------------------------------------------------- ?>
<?php
 } elseif($_GET['action'] == "login") {  	?>
<?php include "views/login.php"; ?>
<?php //--------------------------------------------------------- ?>
<?php
 } elseif($_GET['action'] == "cadastrar") {  	?>
<?php include "views/cadastrar.php"; ?>
<?php //--------------------------------------------------------- ?>
<?php
 } elseif($_GET['action'] == "deslogar") {  	?>
<?php include "views/deslogar.php"; ?>
<?php //--------------------------------------------------------- ?>
<?php
 } elseif($_GET['action'] == "ranking") {  	?>
<?php include "views/ranking.php"; ?>
<?php //--------------------------------------------------------- ?>
<?php
 } elseif($_GET['action'] == "deletar" && $_GET["name"]!=null) {  	?>
<?php include "views/deletarPet.php"; ?>
<?php //--------------------------------------------------------- ?>

<?php
	//Query string "game inicial"
 } elseif($_GET['action'] == "game" && $_GET["name"]!=null) {  	?>
<?php include "views/game.php"; ?>
<?php //--------------------------------------------------------- ?>
<?php
 } elseif($_GET['action'] == "play" && $_GET["game"] == "memoria" && $_GET["name"] != null) {  	?>
<?php include "views/gameMemoria.php"; ?>
<?php //--------------------------------------------------------- ?>
<?php  } }?>

</body>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
<script type="text/javascript">
	<?php if(($_GET['action'] == "game" && $_GET["name"]!=null) || ($_GET['action'] == "play" && $_GET["game"] == "memoria" && $_GET["name"] != null)) { ?>
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
				
				classe = "hyper";
				fundo = "yellow";

				if(dados["tired"] > 50 ) {
					classe = "sleepy";
					fundo = "grey";
				}
				if(dados["dirty"] > 50 ) {
					classe = "";
					fundo = "brown";
				}
				if(dados["sad"] == 1) {
					classe = "sad";
					fundo = "blue";
				}
				if(dados["sick"] == 1) {
					classe = "nervous";
					fundo = "limegreen";
				}
				if(dados["sleeping"] == 1 && dados["lights"] == 0) {
					classe = "sleepy";
					fundo = "darkgrey";
				}
				if(classe ==  "") {
					classe = "item creature-box mod-hyper";
				} else {
					classe = "item creature-box mod-" + classe;
				}
				fundo = "background-color: " + fundo + "; animation-duration: 4.99s; animation-delay: -5.48s;";
				$('#creature_0').attr("class", classe);
				$('.creature').attr("style", fundo);
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
	function jogar(nome, user_id, pontos)
	{
		console.log(nome);
		console.log(user_id);
		console.log(pontos);
		$.ajax({
			type: "POST",
			url: "Pet.php",
			data: {
				act: "jogar",
				pontos: pontos,
				nome: nome
			},
			success: function(response){
				setTimeout(function() {
					window.location.href = "?action=game&name=" + nome;
					}, 5000);
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
		atualizar("<?php echo $_GET["name"]; ?>")
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
	<?php } ?>
	<?php if($_GET['action'] == "game") { ?>
	$('#alimentar').on('click', function(e){
		acao("<?php echo $_GET["name"]; ?>", <?php echo $conta->retornaId(); ?>,"alimentar");
	})
	$('#limpar').on('click', function(e){
		acao("<?php echo $_GET["name"]; ?>", <?php echo $conta->retornaId(); ?>,"limpar");
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
	<?php
 		if($_GET['action'] == "play" && $_GET["game"] == "memoria" && $_GET["name"] != null) {  	?>
	var vezes = 0;
	$('.overflow').each(function(){
		$(this).hide('fast');
	});
	setTimeout(function() {
		$('.overflow').each(function(){
			$(this).show('fast');
		});
	}, 2000);
	var pos1B;
	var pos1E;
	var pos2B;
	var pos2E;
	var posicoes = 0;
	let erros = 0;
	$('#mensagem').hide();
	$('#faltam').text((posicoesMax/2)-(posicoes/2));
	$('.pt-2.row').on('click','.overflow', function(){
		$(this).hide('fast');
		vezes++;
		console.log("vezes : " + vezes);
		if(vezes==1) {
			pos1E = $(this);
			pos1B = pos1E.parent().css("background-color");
		}  else if (vezes==2) {
			console.log("entrou");
			pos2E = $(this);
			pos2B = pos2E.parent().css("background-color");
			if(pos1B == pos2B) {
				console.log("entrou 2");
				console.log(pos1B);
				console.log(pos2B);
				pos1E.addClass("over-forever");
				pos2E.addClass("over-forever");
				posicoes+=2;
				$('#faltam').text((posicoesMax/2)-(posicoes/2));
				vezes=0;
			}
		} else {
			$('.overflow').each(function(){
				if(!($(this).hasClass("over-forever"))) {
					$(this).show('fast');
				}
				
			});
			vezes=0;
			erros++;
			$('#erros').text(erros);
		};
		if(posicoes==posicoesMax) {
			$('#mensagem').show("slow");
			$('#mensagem').text("Parabéns!");
			jogar("<?php echo $_GET["name"]; ?>", <?php echo $conta->retornaId(); ?>, erros);
		}
	});
	<?php } ?>
</script>
</html>