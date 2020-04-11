
<?php
	/*Definir as classes necessárias para o calculo de rede/subrede.
Deverá receber a rede (10.0.0.0/24) e calcular a mascara.
Ao atualizar este objeto e passar nova definição de rede, subrede ou quantidade de host, deve recalcular e exibir os novos valores.
Utilizar formulário para receber os dados em tempo de execução.

Exemplos :
https://www.site24x7.com/pt/tools/ipv4-sub-rede-calculadora.html
https://blog.alura.com.br/como-calcular-mascaras-de-sub-rede/*/

	require 'class/EnderecoIp.php';
	
	if (isset($_POST['enderecoIP']) && isset($_POST['mascaraDeRede'])){
		$enderecoIp = new EnderecoIp($_POST['enderecoIP'], $_POST['mascaraDeRede']);
		$ip = $enderecoIp->getIp();
		$mascaraDeRede = $enderecoIp->getMascaraDeRede();
	}
	
	
	
?>

<!DOCTYPE html>

<html lang="pt">
<head>
	<title>Pagina Principal</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery-3.4.1.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<style>
		html,
		body {
			background-color: #e9ecef;
		}
	</style>
</head>
<body>
<div class="container">
	<header class="blog-header py-3">
		<div class="row flex-nowrap align-items-center">
			<div class="col text-center">
				<h1 class="display-4 font-italic">Calculo de rede</h1>
			</div>
		</div>
	</header>
	

	<div class="jumbotron p-4 p-md-5 text-white rounded bg-dark" id="formaDePagamento" >
		<div class="col-md-6 px-0">
			<form action="#" method="POST" id="formFormaDePagamento">
				<div class="form-group">
					<div class="input-group mb-2">
						<div class="input-group-prepend">
							<div class="input-group-text">Endereco IP</div>
						</div>
						<label class="sr-only" for="enderecoIp">Endereco IP</label>
						<input type="text" class="form-control" id="enderecoIp" name="enderecoIP" placeholder="Endereco IP" required>
						<label class="sr-only" for="mascaraDeRede">Máscara de rede</label>
						<select id="mascaraDeRede" class="custom-select ml-2" name="mascaraDeRede">
							<?php
								for ($i = 1; $i < 33; $i++){
									echo '<option value="'.$i.'">'.$i.'</option>';
								}
							?>
						</select>
					</div>
					<div class="input-group mb-2">
					
					</div>
					<div class="input-group mb-2">
						<input type="submit" value="Enviar" class="btn btn-success">
					</div>
				</div>
			</form>
		</div>
	</div>
	
	<div class="row mb-2">
		<div class="col-md-12">
			<div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative bg-white">
				<div class="col p-4 d-flex flex-column position-static" >
					<strong class="d-inline-block mb-2 text-success">Resultado</strong>
					<div  id="cardGastos">
						<?php
							if (isset($enderecoIp)){
								echo '<p>Endereço: '.$ip.'</p>';
								echo '<p>Máscara de rede: '.$enderecoIp->cidrParaMascaraDeRede($mascaraDeRede).' = '.$mascaraDeRede.'</p>';
								echo '<p>Rede: '.$enderecoIp->cidrParaEnderecoDeRede($ip, $mascaraDeRede).'/'.$mascaraDeRede.'</p>';
								echo '<p>Broadcast: '.$enderecoIp->broadcast($ip, $mascaraDeRede).'</p>';
								echo '<p>Primeiro host: '.$enderecoIp->primeiroHost($ip, $mascaraDeRede).'</p>';
								echo '<p>Último host: '.$enderecoIp->ultimoHost($ip, $mascaraDeRede).'</p>';
								echo '<p>Quantidade de hosts: '.$enderecoIp->quantidadeDeHosts($ip, $mascaraDeRede).'</p>';
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<footer class="my-5 pt-5 text-muted text-center text-small">
		<p class="mb-1">Braian Gabriel Antoniolli</p>
		<p class="mb-1">Projeto baseado no tema <a href="https://getbootstrap.com/docs/4.3/examples/blog/">Blog</a></p>
	</footer>
</div>

</body>
</html>
