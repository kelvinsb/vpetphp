<?php
$conta->protege();
?>
<?php 
		$dados = $conexao->getData($_GET["name"]);
		$dados = json_decode($dados, true);
		if( !$conexao->petExist($_GET["name"])) {
			echo "Este pet não existe";
		} elseif($dados["faliceu"]==1) {
		?>	
		<strong><?php echo $dados["name"]; ?> está morto</strong>
		<?php } else { ?>
<?php
	$vetor = array();
	$cores =  array("#00FFFF", "#0000FF", "#8A2BE2", "#5F9EA0", "#7FFF00", "#DC143C", "#008B8B", "#006400");
	$usoCores = array(0, 0, 0, 0, 0, 0, 0, 0);
	$dimensao = 4;
	$i = 0;
	$j = 0;
	$k = 0;
	function gerarAleatorio($dimensao) {
		$random = rand(0,(($dimensao*$dimensao)/2)-1);
		return $random;
	}
	//black, yellow,  blue, red, grey, white
	for($i=0; $i < $dimensao; $i++) {
		for($j=0; $j < $dimensao; $j++) {
			$random = gerarAleatorio($dimensao);
			while($usoCores[$random]==2) {
				//echo "caiu  " . $k++ . "\n";
				$random = gerarAleatorio($dimensao);
			}
			if($usoCores[$random]<2) {
				$usoCores[$random]+=1;
				$vetor[$i][$j]=$cores[$random];
			}
			//$vetor[$i][$j] = $cores[$i];
			$k++;
		}
	}
?>
<script type="text/javascript">
	let posicoesMax = <?php echo $dimensao*$dimensao; ?>;
</script>
<style type="text/css">
	.quadro-memoria {
		padding: 1px;
		width: 100%;
		height: 100px;
	}
	.interno, .overflow {
		width: 100%;
		height: 100%;
		float:left;
	}
	.overflow {
		background-color: #000000;
	}
	.overflow:hover {
		filter: brightness(120%);
	}
	.over-forever {
		display: none;
	}
</style>
<div class="container">
	<div class="row">
		<div class="col-sm-12 pt-2 row">
			<div class="bg-info col-sm-12 text-white p-2 mb-3" id="mensagem">
				
			</div>
			<div class="bg-dark text-white col-sm-12 row">
				<div class="col-sm-6">
					Erros: <span id="erros">0</span>
				</div>
				<div class="col-sm-6">
					Faltam: <span id="faltam"></span>
				</div>
			</div>
			<?php
				$l = 0;
				for($i=0; $i < $dimensao; $i++) {
					for($j=0; $j < $dimensao; $j++) { ?>
			<div class="col-sm-3 quadro-memoria" id="<?php echo $l; ?>">
				<div class="interno" style="background-color: <?php echo $vetor[$i][$j]; ?>">
					<div class="overflow">
						
					</div>
				</div>
			</div>
			<?php	$l++;
					}
				}
			?>
		</div>
	</div>
</div>

<?php } ?>