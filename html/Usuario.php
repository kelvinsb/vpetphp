<?php
	
	session_start();
	class Usuario{
		var $user;
		var $pw;
		var $email;
		var $pets;

		function protege() {
			if(!isset($_SESSION['usuario_id']) || !isset($_SESSION['logado_em'])): ?>
				<div class="container">
					<div class="row">
						<div class="col-sm-12 text-center">Area restrita</div>
					</div>
				</div>
		<?php endif ?>
		<?php 
				// header('Location: ?action=login');
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