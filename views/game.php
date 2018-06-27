<?php
$conta->protege();
?>
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
			<div class="col-sm-2 mb-1">
				<div class="btn btn-primary" id="alimentar">
					Alimentar
				</div>
			</div>
			<div class="col-sm-2 mb-1">
				<div class="btn btn-primary limpar" id="limpar">
					Lavar
				</div>
			</div>
			<div class="col-sm-2 mb-1">
				<a href="?action=play&game=memoria&name=<?php echo $_GET["name"]; ?>">
					<div class="btn btn-primary brincar" id="brincar">
						Brincar
					</div>
				</a>
			</div>
			<div class="col-sm-2 mb-1">
				<div class="btn btn-primary" id="curar">
					Curar
				</div>
			</div>
			<div class="col-sm-2 mb-1">
				<div class="btn btn-primary lights" id="luzes">
					Desligar luzes
				</div>
			</div>
			<div class="col-sm-1"></div>
		</div>
	<?php } ?>
	</div>
</div>