<?php
	include('config.php');
	class Conexao
	{
		private $host = DBHOST;
		private $user = DBUSER;
		private $pw = DBPW;
		private $dbname = DBNAME;
		static $tempoExec = TEMPOEXEC;//tempo de atualização do código em segundos

		private $conexao;
		public function __construct() {
			try {
				$host = $this->host;
				$db = $this->dbname;
				$this->conexao = new PDO("mysql:host=$host;dbname=$db", $this->user, $this->pw);
				$this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				   $this->conexao->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				// echo "Conectado\n";
			}
			catch(PDOException $e) {
				// echo "Conexão falhou\n";
			}
		}
		function fecharConexao() {
			$this->conexao=null; 
		}
		function listarPets() {
			$usuario_id = $_SESSION['usuario_id'];
			$qr = $this->conexao->prepare("SELECT * FROM pet WHERE usuario_id = :usuario_id");
			$qr->bindParam(':usuario_id', $usuario_id);
			if($qr->execute()) {
				$resultado = $qr->fetchAll(PDO::FETCH_ASSOC);
				//print_r($resultado);
				return $resultado;
			}
			return false;
		}
		function listarPetsOrdenado() {
			$qr = $this->conexao->prepare("SELECT * FROM pet ORDER BY pontos");
			if($qr->execute()) {
				$resultado = $qr->fetchAll(PDO::FETCH_ASSOC);
				return $resultado;
			}
			return false;
		}
		function cadastrarUsuario($usuario, $senha, $email) {
			$qr1 = $this->conexao->prepare("SELECT usuario FROM usuario WHERE usuario = :usuario ");
			$qr1->bindParam(':usuario', $usuario);
			$qr1->fetchAll(PDO::FETCH_ASSOC);
			$qr1->execute();
			if($qr1->rowCount() == 0) {
				$senhaHash = password_hash($senha, PASSWORD_BCRYPT, array("cost" => 12));
				$qr = $this->conexao->prepare("INSERT INTO usuario(usuario,senha,email) VALUES(:usuario, :senha, :email)");
				$qr->bindParam(':usuario', $usuario);
				$qr->bindParam(':senha', $senhaHash);
				$qr->bindParam(':email', $email);
				if($qr->execute()) {
					return true;
				}
			} else {
				return false;
			}
		}
		function logarUsuario($usuario, $senha) {
			$qr = $this->conexao->prepare("SELECT  id,senha, usuario FROM usuario WHERE usuario = :usuario");
			$qr->bindParam(':usuario', $usuario);
			$qr->execute();
			$conta = $qr->fetch(PDO::FETCH_ASSOC);
			if($conta != false) {
				$validarSenha = password_verify($senha, $conta["senha"]);
				if($validarSenha) {
					$_SESSION['usuario_id'] = $conta['id'];
					$_SESSION['logado_em']  =  time();
					return true;
				}
			}
			return false;

		}
		function verSeTem($name) {
			$usuario_id = $_SESSION['usuario_id'];
			$qr1 = $this->conexao->prepare("SELECT * FROM pet WHERE usuario_id = :usuario_id AND name = :name");
			$qr1->bindParam(':usuario_id', $usuario_id);
			$qr1->bindParam(':name', $name);
			$qr1->fetchAll(PDO::FETCH_ASSOC);
			$qr1->execute();
			return $qr1->rowCount();
		}
		function criarPet($name) {			
			$verificar = self::verSeTem($name);
			$usuario_id = $_SESSION['usuario_id'];
			
			if($verificar>0)
			{
				return false;
			}
			$qr = $this->conexao->prepare("INSERT INTO pet(name,happy,hunger,health,sick,tired,dirty,sad,sleeping,faliceu,usuario_id, deltaTime, lights, pontos) VALUES(:name, :happy, :hunger, :health, :sick, :tired, :dirty, :sad, :sleeping, :faliceu, :usuario_id, :deltaTime, :lights, :pontos);");
			$happy = 100;
			$hunger = 0;
			$health = 100;
			$sick = 0;
			$tired = 0;
			$dirty = 0;
			$sad = 0;
			$sleeping = 0;
			$faliceu = 0;
			$deltaTime = date('Y-m-d H:i:s');
			$lights = 1;
			$pontos = 0;
			$qr->bindParam(':name', $name);
			$qr->bindParam(':happy', $happy);
			$qr->bindParam(':hunger', $hunger);
			$qr->bindParam(':health', $health);
			$qr->bindParam(':sick', $sick);
			$qr->bindParam(':tired', $tired);
			$qr->bindParam(':dirty', $dirty);
			$qr->bindParam(':sad', $sad);
			$qr->bindParam(':sleeping', $sleeping);
			$qr->bindParam(':faliceu', $faliceu);
			$qr->bindParam(':usuario_id', $usuario_id);
			$qr->bindParam(':deltaTime', $deltaTime);
			$qr->bindParam(':lights', $lights);
			$qr->bindParam(':pontos', $pontos);
			if($qr->execute())
			{
				return true;
			}
			
		
			return false;
		}
		function deletarPet($name) {
			$verificar = self::verSeTem($name);
			$usuario_id = $_SESSION['usuario_id'];

			if($verificar==0)
			{
				return false;
			}
			echo "Pet deletado";
			$qr = $this->conexao->prepare("DELETE FROM pet WHERE name = :nome AND usuario_id = :usuario_id");
			$qr->bindParam(':nome', $name);
			$qr->bindParam(':usuario_id', $usuario_id);
			if($qr->execute()) {
				return true;
			}
			return false;

		}
		function feed($name, $amount) {
			$qr1 = $this->conexao->prepare("SELECT hunger,sick, health FROM pet WHERE usuario_id =:usuario_id AND name = :name");

			$usuario_id = $_SESSION['usuario_id'];
			$qr1->bindParam(':usuario_id', $usuario_id);
			$qr1->bindParam(':name', $name);
			if($qr1->execute()) {
				$resultado = $qr1->fetch(PDO::FETCH_ASSOC);
				$hunger = $resultado["hunger"];
				$life = $resultado["health"];
				//echo $hunger . "\n";
				$hunger-=$amount;
				$life+=$amount;
				$sick = $resultado["sick"];
				if($hunger<0) {
					$hunger=0;
					$sick = 1;
				}
				$qr = $this->conexao->prepare("UPDATE pet SET hunger = :hunger, sick = :sick, health = :health WHERE usuario_id = :usuario_id AND name = :name");
				$qr->bindParam(':usuario_id', $usuario_id);
				$qr->bindParam(':name', $name);
				$qr->bindParam(':hunger', $hunger);
				$qr->bindParam(':sick', $sick);
				$qr->bindParam(':health', $life);
				if($qr->execute()) {
					return true;
				}
			}
			return false;
		}
		function flush($name) {
			$qr1 = $this->conexao->prepare("SELECT health FROM pet WHERE usuario_id = :usuario_id AND name = :name");

			$usuario_id = $_SESSION['usuario_id'];
			$qr1->bindParam(':usuario_id', $usuario_id);
			$qr1->bindParam(':name', $name);
			if($qr1->execute()) {
				$dirty = 0;
				$resultado = $qr1->fetch(PDO::FETCH_ASSOC);
				$vida = $resultado["health"];
				$vida+=1;
				if($vida>100) {
					$vida = 100;
				}
				$qr = $this->conexao->prepare("UPDATE pet SET dirty = :dirty, health = :health WHERE usuario_id = :usuario_id and name = :name");
				$qr->bindParam(':usuario_id', $usuario_id);
				$qr->bindParam(':name', $name);
				$qr->bindParam(':dirty', $dirty);
				$qr->bindParam(':health', $vida);
				if($qr->execute()) {
					return true;
				}
			}
			return false;
		}
		function play($name, $pontos) {
			$qr1 = $this->conexao->prepare("SELECT happy, hunger, pontos FROM pet WHERE usuario_id = :usuario_id AND name = :name");
			$usuario_id = $_SESSION['usuario_id'];
			$qr1->bindParam(':usuario_id', $usuario_id);
			$qr1->bindParam(':name', $name);
			if($qr1->execute()) {
				$resultado = $qr1->fetch(PDO::FETCH_ASSOC);
				$happy = $resultado["happy"];
				$hunger = $resultado["hunger"];
				while($pontos>=10) {
					if($pontos>=10) {
						$happy+=1;
						$pontos-=10;
					}
				}
				$hunger+=1;
				$qr = $this->conexao->prepare("UPDATE pet SET happy = :happy, hunger = :hunger, pontos = :pontos WHERE usuario_id = :usuario_id AND name = :name");
				$qr->bindParam(':usuario_id', $usuario_id);
				$qr->bindParam(':name', $name);
				$qr->bindParam(':happy', $happy);
				$qr->bindParam(':hunger', $hunger);
				$pontos+= $resultado["pontos"];
				$qr->bindParam(':pontos', $pontos);
				if($qr->execute()) {
					return true;
				}
			}
			return false;
		}
		function cure($name) {
			$qr1 = $this->conexao->prepare("SELECT sick, health FROM pet WHERE usuario_id = :usuario_id AND name = :name");

			$usuario_id = $_SESSION['usuario_id'];
			$qr1->bindParam(':usuario_id', $usuario_id);
			$qr1->bindParam(':name', $name);
			if($qr1->execute()) {
				$resultado = $qr1->fetch(PDO::FETCH_ASSOC);
				$sick = $resultado["sick"];
				$health = $resultado["health"];
				if($sick == 1) {
					$health+=10;
					if($health>100) {
						$health=100;
					}
					if($health>25) {
						$sick=0;
					}
				}
				else if($sick == 0) {
					$random = rand(0,100);
					if($random < 50) {
						$sick = 1;
					}
				}
				$qr = $this->conexao->prepare("UPDATE pet SET sick = :sick, health = :health WHERE usuario_id = :usuario_id AND name = :name");
				$qr->bindParam(':usuario_id', $usuario_id);
				$qr->bindParam(':name', $name);
				$qr->bindParam(':sick', $sick);
				$qr->bindParam(':health', $health);
				if($qr->execute()) {
					return true;
				}
			}
			return false;
		}
		function lights($name) {
			$qr1 = $this->conexao->prepare("SELECT lights FROM pet WHERE usuario_id = :usuario_id AND name = :name");

			$usuario_id = $_SESSION['usuario_id'];
			$qr1->bindParam(':usuario_id', $usuario_id);
			$qr1->bindParam(':name', $name);
			if($qr1->execute()) {
				$resultado = $qr1->fetch(PDO::FETCH_ASSOC);
				$lights = $resultado["lights"];
				$sleeping = $resultado["sleeping"];
				if($lights == 1) {
					$lights = 0;
					$sleeping = 1;
				} else {
					$lights = 1;
					$sleeping = 0;
				}
				$qr = $this->conexao->prepare("UPDATE pet SET lights = :lights,sleeping = :sleeping WHERE usuario_id = :usuario_id AND name = :name");
				$qr->bindParam(':usuario_id', $usuario_id);
				$qr->bindParam(':name', $name);
				$qr->bindParam(':lights', $lights);
				$qr->bindParam(':sleeping', $sleeping);
				if($qr->execute()) {
					return True;
				}
			}
			return False;
		}
		function getData($name) {
			$qr1 = $this->conexao->prepare("SELECT * FROM pet WHERE usuario_id = :usuario_id AND name = :name");

			$usuario_id = $_SESSION['usuario_id'];
			$qr1->bindParam(':usuario_id', $usuario_id);
			$qr1->bindParam(':name', $name);
			if($qr1->execute()) {
				$resultado = $qr1->fetch(PDO::FETCH_ASSOC);
				$json_resposta = json_encode($resultado);
				return $json_resposta;
			}
			return false;

		}
		function petExist($name) {
			$qr1 = $this->conexao->prepare("SELECT * FROM pet WHERE usuario_id = :usuario_id AND name = :name");

			$usuario_id = $_SESSION['usuario_id'];
			$qr1->bindParam(':usuario_id', $usuario_id);
			$qr1->bindParam(':name', $name);
			if($qr1->execute()) {
				$resultado = $qr1->fetch(PDO::FETCH_ASSOC);
				if($resultado) {
					return true;
				}
				
			}
			//return false;
		}
		function teto(&$variavel) {
			if($variavel > 100) {
				$variavel = 100;
			}
		}
		function chao(&$variavel) {
			if($variavel < 0) {
				$variavel = 0;
			}
		}
		function update($name) {
			$qr1 = $this->conexao->prepare("SELECT * FROM pet WHERE usuario_id = :usuario_id AND name = :name");

			$usuario_id = $_SESSION['usuario_id'];
			$qr1->bindParam(':usuario_id', $usuario_id);
			$qr1->bindParam(':name', $name);
			$qr1->fetchAll(PDO::FETCH_ASSOC);
			
			$qr1->execute();
			if($qr1->rowCount() > 0) {
				$resultado = $qr1->fetch(PDO::FETCH_ASSOC);
				if($resultado["sad"] == 1) {
					$taxaFelicidade = 2;
				} else {
					$taxaFelicidade = 1;
				}
				if($resultado["sick"] == 1) {
					$taxaVida = 2;
				} else {
					$taxaVida = 1;
				}
				if($resultado["dirty"] > 25) {
					$taxaVida*=2;
				}
				if($resultado["sleeping"] == 1) {
					$taxafome = 1;
					$taxavida = 1;
				} else {
					$taxafome = 2;
				}
				date_default_timezone_set("Brazil/East");
				$dataAtual = $deltaTime = date('Y-m-d H:i:s');
				$i = $resultado["deltaTime"];
				while($i<=$dataAtual) {
					$resultado["happy"]-=$taxaFelicidade;
					$resultado["hunger"]+=$taxafome;
					$resultado["health"]-=$taxaVida;
					if($resultado["happy"] < 25) {
						$resultado["sad"] = 1;
					}
					if($resultado["health"] < 25) {
						$resultado["sick"] = 1;
					}
					$resultado["dirty"]+=1;
					if($resultado["lights"] == 0) {
						$resultado["tired"]-=1;
						if($resultado["tired"]<0)
						{
							$resultado["tired"]=0;
						}
					} else {
						$resultado["tired"]+=1;
					}
					self::teto($resultado["happy"]);
					self::chao($resultado["happy"]);
					self::teto($resultado["hunger"]);
					self::chao($resultado["hunger"]);
					self::teto($resultado["health"]);
					self::chao($resultado["health"]);
					self::teto($resultado["dirty"]);
					self::chao($resultado["dirty"]);
					$i = date('Y-m-d H:i:s',strtotime('+' . self::$tempoExec . ' seconds',strtotime($i)));
				}
				$horaSalvar = $i;
				if($resultado["health"] == 0 || $resultado["hunger"] == 100 || $resultado["happy"] == 0 || $resultado["tired"] == 100) {
					$resultado["faliceu"] = 1;
				}
				$qr = $this->conexao->prepare("UPDATE pet
					SET happy = :happy ,
					hunger = :hunger ,
					health = :health ,
					sad = :sad ,
					sick = :sick ,
					faliceu = :faliceu ,
					dirty = :dirty ,
					tired = :tired ,
					deltaTime = :deltaTime
					WHERE usuario_id = :usuario_id AND name = :name");
				$qr->bindParam(':usuario_id', $usuario_id);
				$qr->bindParam(':name', $name);
				$qr->bindParam(':happy', $resultado["happy"]);
				$qr->bindParam(':hunger', $resultado["hunger"]);
				$qr->bindParam(':health', $resultado["health"]);
				$qr->bindParam(':sad', $resultado["sad"]);
				$qr->bindParam(':sick', $resultado["sick"]);
				$qr->bindParam(':faliceu', $resultado["faliceu"]);
				$qr->bindParam(':tired', $resultado["tired"]);
				$qr->bindParam(':dirty', $resultado["dirty"]);
				$qr->bindParam(':deltaTime', $horaSalvar);
				if($qr->execute()) {
					$json_resposta = json_encode(array(
						"status" => true,
						"name" => $name
					));
					return $json_resposta;
				}
			}
			$json_resposta = json_encode(array(
				"status" => false,
				"name" => $name
			));
			return $json_resposta;

		}

	}
?>