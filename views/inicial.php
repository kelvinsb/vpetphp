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