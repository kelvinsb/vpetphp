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