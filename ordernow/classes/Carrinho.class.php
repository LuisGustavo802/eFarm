<?php class Carrinho{
    private $pref = 'ordernow_';

    private function existe($id){
       if(!isset($_SESSION[$this->pref.'produto'])){
          $_SESSION[$this->pref.'produto'] = array();
       }

       if(!isset($_SESSION[$this->pref.'produto'][$id])){
          return false;
       }else{
          return true;
       }
    }//verifica a existencia do produto e da session como um array

    public function verificaAdiciona($id){
         if(!$this->existe($id)){
            $_SESSION[$this->pref.'produto'][$id] = 1;
         }else{
            $_SESSION[$this->pref.'produto'][$id] += 1;
         }
    }//verifica e adiciona mais um produto no carrinho

    private function prodExiste($id){
       if(isset($_SESSION[$this->pref.'produto'][$id])){
          return true;
       }else{
          return false;
       }
    }//verifica se o produto existe

    public function deletarProduto($id){
       if(!$this->prodExiste($id)){
          return false;
       }else{
          unset($_SESSION[$this->pref.'produto'][$id]);
          return true;
        }
    }//deleta produto do carrinho de compras

    public function isArray($post){
        if(is_array($post)){
           return true;
        }else{
           return false;
        }
    }//verifica se o post passado por parametro é ou não um array

    public function atualizarQuantidades($post){
        if($this->isArray($post)){
            foreach($post as $id => $qtd){
                $id = (int)$id;
                $qtd = (int)$qtd;

                if ($qtd != ''){
                    $_SESSION[$this->pref.'produto'][$id] = $qtd;
                }else{
                    unset($_SESSION[$this->pref.'produto'][$id]);
                }
            }
            return true;
        }else{
            return false;
        }//se não for um array
    }//deleta ou atualiza quantidades referentes a um produto no nosso carrinho de compras

    public function qtdProdutos(){
        return count($_SESSION[$this->pref.'produto']);
    }//retorna quantidade do Carrinho

	function calculaFrete($cod_servico, $cep_origem, $cep_destino, $peso, $altura='2', $largura='11', $comprimento='16', $valor_declarado='19.50'){
			# Código dos Serviços dos Correios
			# 41106 Pac sem contrato
			# 40010 Sedex sem contrato
			# 40045 Sedex a cobrar, sem contrato
			# 40215 Sedex 10, sem contrato
	
			$correios = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?"."nCdEmpresa=&sDsSenha=&sCepOrigem=".$cep_origem."&sCepDestino=".$cep_destino."&nVlPeso=".$peso."&nCdFormato=1&nVlComprimento=".$comprimento."&nVlAltura=".$altura."&nVlLargura=".$largura."&sCdMaoPropria=n"."&nVlValorDeclarado=".$valor_declarado."&sCdAvisoRecebimento=n"."&nCdServico=".$cod_servico."&nVlDiametro=0&StrRetorno=xml";
							$xml = simplexml_load_file($correios);
							if($xml->cServico->Erro == '0')
								return $xml->cServico->Valor;
							else
								return false;
			}

   }

 ?>
