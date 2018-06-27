<?php
	$deletar = $conexao->deletarPet(trim($_GET["name"]));
	if ($deletar) {
		header('Location: ?action=selectPet');
	} else {
		echo "Houve algum erro";
	}
?>