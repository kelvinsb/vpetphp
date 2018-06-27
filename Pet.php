<?php
	date_default_timezone_set("Brazil/East");
?>
<?php
	include "Usuario.php";
	include "Conexao.php";
?>

<?php
	$conexao = new Conexao();
	$conta = new Usuario();
	//
		if(isset($_POST["act"])){
			if($_POST["act"]==="cadastrar") {
				$usuario = !empty($_POST['usuario']) ? trim($_POST['usuario']) :  null;
				$senha = !empty($_POST['senha']) ? trim($_POST['senha']) :  null;
				$email = !empty($_POST['email']) ? trim($_POST['email']) :  null;

				$cadastrado = $conexao->cadastrarUsuario($usuario, $senha, $email);
				if($cadastrado) {
					$resposta = array(
						"status" => true,
						"name" => $usuario
					);
					$json_resposta = json_encode($resposta);
					echo $json_resposta;
					return;
				}
				$resposta = array(
					"status" => false,
				);
				$json_resposta = json_encode($resposta);
				echo $json_resposta;
				return;
			}
			elseif($_POST["act"]==="login") {
				$usuario = !empty($_POST['usuario']) ? trim($_POST['usuario']) :  null;
				$senha = !empty($_POST['senha']) ? trim($_POST['senha']) :  null;

				$logado = $conexao->logarUsuario($usuario, $senha);
				if($logado) {
					$json_resposta = json_encode(array(
						"status" => true,
						"name" => $usuario
					));
					echo $json_resposta;
					return;
				}
				$json_resposta = json_encode(array(
					"status" => false
				));
				echo $json_resposta;
				return;
			}
			elseif($_POST["act"]==="criar") {
				$criado = $conexao->CriarPet($_POST["nome"], 1);
				if($criado==true || $criado ==false) {
					$resposta = array(
						"status" => $criado,
						"name" => $_POST["nome"]
					);
					$json_resposta = json_encode($resposta);
					echo $json_resposta;
				}
			}
			elseif ($_POST["act"]==="pegardados") {
				$dados = $conexao->getData($_POST["nome"], 1);
				if($dados) {
					echo $dados;
				}
			}
			elseif ($_POST["act"]==="atualizar") {
				$dados = $conexao->update($_POST["nome"], 1);
				if($dados) {
					echo $dados;
				}
			}
			elseif ($_POST["act"]==="alimentar") {
				$dados = $conexao->feed($_POST["nome"], 1, 1);
				if($dados) {
					echo $dados;
				}
			}
			elseif ($_POST["act"]==="limpar") {
				$dados = $conexao->flush($_POST["nome"], 1);
				if($dados) {
					echo $dados;
				}
			}
			elseif ($_POST["act"]==="brincar") {
				$dados = $conexao->play($_POST["nome"], 1, 10);
				if($dados) {
					echo $dados;
				}
			}
			elseif ($_POST["act"]==="curar") {
				$dados = $conexao->cure($_POST["nome"], 1);
				if($dados) {
					echo $dados;
				}
			}
			elseif ($_POST["act"]==="luzes") {
				$dados = $conexao->lights($_POST["nome"], 1);
				if($dados) {
					echo $dados;
				}
			}
			
		}
		
	
?>