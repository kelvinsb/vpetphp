
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