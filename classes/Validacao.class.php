<?php
    class Validacao{
        private $dados;
        private $erro = array();

        //seta o valor de cada Campo
        public function set($valor, $nome){
            $this->dados = array("valor" => strip_tags(trim($valor)), "nome" => $nome);
            return $this;
        }

        //valida campos obrigatorios
        public function obrigatorio(){
            if(empty($this->dados['valor'])){
                $this->erro[] = sprintf("O campo %s é obrigatório.", $this->dados['nome']);
            }
            return $this;
        }

        //valida email valido
        public function isEmail(){
            if(!preg_match("/^[a-z0-9_\.\-]+@[a-z0-9_\.\-]+\.[a-z]{2,4}$/i", $this->dados['valor'])){
                $this->erro[] = sprintf("O campo %s só aceita emails válidos.", $this->dados['nome']);
            }
            return $this;
        }

        //demais campos
        public function validar(){
            if(count($this->erro) > 0){
                return false;
            }else{
                return true;
            }
        }

        //retorna os erros econtrados
        public function getErro(){
           return $this->erro;
        }
    }

?>
