<?php class Login extends BD{
    private $prefixo;
    private $tabela;
    private $email;
    private $senha;

    public function __construct($pref, $table){
        $this->prefixo = $pref;
        $this->tabela  = $table;
    }

    public function setEmail($mail){
        $this->email = $mail;
    }

    private function getEmail(){
        return $this->email;
    }

    public function setSenha($pass){
        $this->senha = $pass;
    }

    public function getSenha(){
        return $this->senha;
    }

    private function validar(){
        $strSQL = "SELECT senha FROM `".$this->tabela."` WHERE email = ?";
        $stmt = self::conn()->prepare($strSQL);
        $stmt->execute(array($this->getEmail()));
        if($stmt->RowCount() > 0){
           $pegar_senha = $stmt->fetchObject();
           if(password_verify($this->getSenha(),$pegar_senha->senha)){
              $this->setSenha($pegar_senha->senha);
              return true;
           }else{
              return false;
           }
        }else{
           return false;
        }
    }

    public function logar(){
        if($this->validar()){
            $atualizar = self::conn()->prepare("UPDATE `".$this->tabela."` SET data = NOW() WHERE email = ? AND senha = ?");
            $atualizar->execute(array($this->getEmail(), $this->getSenha()));
            session_regenerate_id();
            $_SESSION[$this->prefixo.'emailLog'] = $this->getEmail();
            $_SESSION[$this->prefixo.'senhaLog'] = $this->getSenha();
            return true;
        }else{
           return false;
        }
    }

    public function isLogado(){
       if(isset($_SESSION[$this->prefixo.'emailLog'], $_SESSION[$this->prefixo.'senhaLog'])){
            return true;
       }else{
            return false;
       }
    }

    public function deslogar(){
        if($this->isLogado()){
            unset($_SESSION[$this->prefixo.'emailLog']);
            unset($_SESSION[$this->prefixo.'senhaLog']);
            session_regenerate_id();
            session_destroy();
            return true;
        }else{
            return false;
        }
    }
}
?>
