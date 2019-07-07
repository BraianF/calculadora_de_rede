<?php
	
	
	class EnderecoIp {
		private $ip;
		private $mascaraDeRede;
		private $quantidadeDeHosts;
		private $quantidadeDeSubredes;
		
		/**
		 * EnderecoIp constructor.
		 * @param $ip
		 * @param $mascaraDeRede
		 */
		public function __construct($ip, $mascaraDeRede) {
			$this->ip = $ip;
			$this->mascaraDeRede = $mascaraDeRede;
		}
		
		/**
		 * @return mixed
		 */
		public function getIp() {
			return $this->ip;
		}
		
		/**
		 * @return mixed
		 */
		public function getMascaraDeRede() {
			return $this->mascaraDeRede;
		}
		
		
//		Converte o numero de bits (texto apos a barra) em mascara de rede
//		ex: 24 = 255.255.255.0
		public function cidrParaMascaraDeRede($cidr){
//			Se o CIDR for 0, a mascara de rede fica 0.0.0.0. Acredito que isso nao fica muito certo
			if ( $cidr == "0"){
				return false;
			}

//			Percorre toda a quantidade de bits do ipv4
			$binario='';
			for( $i = 1; $i <= 32; $i++ ) {
//				Enquanto o cidr for maior que o index, adiciona 1 ao texto
				$binario .= $cidr >= $i ? '1' : '0';
			}
//			Transforma o valor binario para decimal e apos isso transforma para o texto em ip
			$mascaraDeRede = long2ip(bindec($binario));
			
			return $mascaraDeRede;
		}

//		Transforma a mascara de rede no formato IP para cidr
//		ex: 255.255.255 = 24
		public function mascaraDeRedeParaCidr($netmask){
			$bitsCidr = 0;

//			Transforma a string em um array, separado pelo .
			$netmask = explode(".", $netmask);
			
			foreach($netmask as $octecto){
//				Transforma o octeto em binario
				$octetoEmBinario = decbin($octecto);
//				Remove os bits 0 do octeto e pega o tamanho restante da string, somando a variavel $bits
				$bitsCidr += strlen(
					str_replace(
						"0",
						"",
						$octetoEmBinario
					)
				);
			}
			return $bitsCidr;
		}

//		Converte o endereco ip com cidr para o endereco de rede
//		ex: 10.0.0.25/24 = 10.0.0.0
		public function cidrParaEnderecoDeRede($ip, $cidr){
//			O << desloca os bits de 1 em 32 - $cidr passos para a esquerda. Cada passo significa "multiplica por dois"
//			Ou seja, se o cidr for 24, desloca 8 bits a esquerda, levando ao numero de 256
			$bitsDeRede = -1 << (32 - (int)$cidr);
//			Utiliza o operador bit a bit AND para retornar os bits ativos tanto no $ip e em $bitsDeRede
			$rede = long2ip((ip2long($ip)) & ($bitsDeRede));
			
			return $rede;
		}

//		Verifica se o endereco de ip percence a uma subrede com o cidr
//		ex: 10.2.0.152 esta em 10.0.0.0/24 ? FALSO
//			10.0.0.60 esta em 10.0.0.0/24 ? VERDADEIRO
		public function ipPertenceARedeComCidr($ip, $rede, $cidr){
//			O << desloca os bits de 1 em 32 - $cidr passos para a esquerda. Cada passo significa "multiplica por dois"
			$bitsDeRede = (1 << (32 - $cidr));
//			Utiliza o operador bit a bit AND para retornar os bits ativos tanto no $ip quanto no inverso de $bitsDeRede - 1
//          O operador bit a bit NOT ativa os bits nao estao ativados e vice-versa
//			Compara o resultado com o endereco de rede provido
			if ((ip2long($ip) & ~($bitsDeRede - 1) ) == ip2long($rede)){
				return true;
			}
			return false;
		}

		
	}
	
	