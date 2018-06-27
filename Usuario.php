<?php
	
	session_start();
	class Usuario{
		var $user;
		var $pw;
		var $email;
		var $pets;

		function protege() {
			if(!isset($_SESSION['usuario_id']) || !isset($_SESSION['logado_em'])){
				header('Location: ?action=login');
			}
		}
		function estaLogado() {
			if(isset($_SESSION['usuario_id']) || isset($_SESSION['logado_em'])){
				return true;
			}
		}
		function estaLogadoRedir() {
			if($this->estaLogado()){
				header('Location: ?action=home');
			}
		}
		function deslogar() {
			session_destroy();
			header('Location: ?action=login');
		}
		function retornaId()  {
			if($this->estaLogado()) {
				return $_SESSION['usuario_id'];
			}
			return false;
		}
	}
	
?>