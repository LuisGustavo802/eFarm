<?php
    class Site extends BD{

      private $conexao;

      //PRODUTOS
      public function getProdutoHome($inicio = false, $maximo = false){
        if (($inicio == false) AND ($maximo == false)){
            $query = "SELECT * FROM `tblcdsprod` ORDER BY id DESC";
        }else{
            $query = "SELECT * FROM `tblcdsprod` ORDER BY id DESC LIMIT $inicio, $maximo";
        }
            return self::conn()->query($query);
      }

      //CATEGORIA TOP
      public function getMenuCategoriaTop(){
          $pegar_categorias = "SELECT * FROM `tblcdscat` ORDER BY id DESC";
          $executar = self::conn()->prepare($pegar_categorias);
          $executar->execute();
          if($executar->rowCount()==0){}else{
            while($categoria = $executar->fetchObject()){
              echo '<li><a href="'.PATH.'loja/'.$categoria->slug.'">'.utf8_encode($categoria->titulo).'</a></li>';
            }
          }
      }

      //CATEGORIA LOJA
      public function getMenuCategoriaLoja(){
          $pegar_categorias = "SELECT * FROM `tblcdscat` ORDER BY id DESC";
          $executar = self::conn()->prepare($pegar_categorias);
          $executar->execute();
          if($executar->rowCount()==0){}else{
            while($categoria = $executar->fetchObject()){
              echo '<li class="nav-item"><a href="'.PATH.'loja/'.$categoria->slug.'">'.utf8_encode($categoria->titulo).'</a></li>';
            }
          }
      }

      //QUANTIDADE DE REGISTROS LOJA
      public function getRegistros(){
          $regSQL = "SELECT ID FROM `tblcdsprod` ORDER BY ID DESC LIMIT 1";
          $executar_reg = self::conn()->prepare($regSQL);
          $numReg = $executar_reg->execute();
          return  $numReg;
      }

      //PAGINAS MENU TOP
      public function getPaginas(){
          $pegar_paginas = "SELECT * FROM `tblcdspag` ORDER BY id ASC";
          $executar = self::conn()->prepare($pegar_paginas);
          $executar->execute();
          if($executar->rowCount()==0){}else{
            while($paginas = $executar->fetchObject()){
              echo '<li class="nav-item"><a class="nav-link" href="'.PATH.''.$paginas->slug.'">'.$paginas->titulo.'</a></li>';
            }
          }
      }

      //INSERIR
      public function inserir($tabela, $dados){
           $pegarCampos = array_keys($dados);
           $contarCampos = count($pegarCampos);
           $pegarValores = array_values($dados);
           $contarValores = count($pegarValores);

           $sql = "INSERT INTO $tabela (";
             if($contarCampos == $contarValores){
                 foreach($pegarCampos as $campo){
                     $sql .= $campo.', ';
                 }
                 $sql  = substr_replace($sql, ")", -2, 1);
                 $sql .= "VALUES (";

                 for($i = 0; $i < $contarValores; $i++){
                     $sql .= "?, ";
                     $i;
                 }

                  $sql  = substr_replace($sql, ")", -2, 1);
             }else{
              return false;
           }

           try{
              $inserir = self::conn()->prepare($sql);
              if($inserir->execute($pegarValores)){
                  return true;
              }else{
                  return false;
              }
           }catch(PDOException $e){
              return false;
           }
       }

       //seleção dinamica de todos pedidos
       public function selecionarPedidos($tabela, $dados, $condicao = false, $order = false){
            $pegarValores = implode(',', $dados);
            $contarValores = array($pegarValores);
            $contarValores = count($contarValores);

            if($condicao == false){
               if($contarValores > 0){
                  if($order != false){
                     $sql = "SELECT $pegarValores FROM $tabela ORDER BY $order";
                  }else{
                     $sql = "SELECT $pegarValores FROM $tabela";
                  }
                  $this->conexao = self::conn()->prepare($sql);
                  $this->conexao->execute();
                  return $this->conexao;
               }
            }else{
                  //existe condição para selecionar
                  $pegarCondCampos = array_keys($condicao);
                  $contarCondCampos = count($pegarCondCampos);
                  $pegarCondValores = array_values($condicao);

                  $sql = "SELECT $pegarValores FROM $tabela WHERE";
                  foreach($pegarCondCampos as $campoCondicao){
                      $sql .= $campoCondicao." = ? AND ";
                  }
                  $sql = substr_replace($sql, "", -5, 5);

                  foreach($pegarCondValores as $condValores){
                      $dadosExec[] = $condValores;
                  }
                  if($order){ //se for verdadeiro
                      $sql .= "ORDER BY $order";
                  }
                  $this->conexao = self::conn()->prepare($sql);
                  $this->conexao->execute($dadosExec);
                  return $this->conexao;
            }
       }

       //seleção dinamica todos os pedidos
       public function selecionar($tabela, $dados, $condicao = false, $order = false, $sts){
            $pegarValores = implode(',', $dados);
            $contarValores = array($pegarValores);
            $contarValores = count($contarValores);

            if($condicao == false){
               if($contarValores > 0){
                  if($order != false){
                     $sql = "SELECT $pegarValores FROM $tabela WHERE `status` = $sts ORDER BY $order";
                  }else{
                     $sql = "SELECT $pegarValores FROM $tabela";
                  }
                  $this->conexao = self::conn()->prepare($sql);
                  $this->conexao->execute();
                  return $this->conexao;
               }
            }else{
                  //existe condição para selecionar
                  $pegarCondCampos = array_keys($condicao);
                  $contarCondCampos = count($pegarCondCampos);
                  $pegarCondValores = array_values($condicao);

                  $sql = "SELECT $pegarValores FROM $tabela WHERE";
                  foreach($pegarCondCampos as $campoCondicao){
                      $sql .= $campoCondicao." = ? AND ";
                  }
                  $sql = substr_replace($sql, "", -5, 5);

                  foreach($pegarCondValores as $condValores){
                      $dadosExec[] = $condValores;
                  }
                  if($order){ //se for verdadeiro
                      $sql .= "ORDER BY $order";
                  }
                  $this->conexao = self::conn()->prepare($sql);
                  $this->conexao->execute($dadosExec);
                  return $this->conexao;
            }
       }

       public function Listar(){
            $lista = $this->conexao->fetchAll();
            return $lista;
       }

       //metodo para envio de email phpmailer
       public function sendMail($subject, $msg, $from, $nomefrom, $destino, $nomedestino){
            require_once "mailer/PHPMailer.php";
            $mail = new PHPMailer();//instancia a classe phpmailer

            $email->isSMTP();//habilita envio smtp
            $email->SMTPAuth = true;//autencia o envio smtp
            $mail->Host = 'ordernow.com';
            $mail->Port = '25'; //ver porta conforme hospedagem

            //começar envio de Email
            $mail->Username = 'ordernow.utfpr@gmail.com';
            $mail->Password = 'orderorderorder';

            $mail->From = $from;//email de quem envia
            $mail->FromName = $namefrom;//nome de quem envia

            $email->isHTML(true);//seta que é html o Email
            $email->Subject = utf8_decode($subject);
            $email->Body = utf8_decode($msg);//corpo da mensagem
            $email->addAddress($destino, utf8_decode($nomedestino));//seta o destino do email

            if($mail->Send()){
               return true;
            }else{
               return false;
            }

       }

       function upload($tmp, $name, $nome, $larguraP, $pasta){
          $ext = explode('.',$name);
          $file_extension = end($ext);

          if($file_extension == 'jpg' || $file_extension == 'JPG' || $file_extension == 'jpeg' || $file_extension == 'JPEG'){
              $img = imagecreatefromjpeg($tmp);
          }elseif ($file_extension == 'png') {
              $img = imagecreatefrompng($tmp);
          }elseif ($file_extension == 'gif'){
              $img = imagecreatefromgif($tmp);
          }
          list($larg, $alt) = getimagesize($tmp);
          $x = $larg;
          $y = $alt;
          $largura = ($x>$larguraP) ? $larguraP : $x;
          $altura = ($largura*$y)/$x;

          if($altura>$larguraP){
              $altura = $larguraP;
              $largura = ($largura*$x)/$y;
          }

          $nova = imagecreatetruecolor($largura, $altura);
          imagecopyresampled($nova, $img, 0,0,0,0, $largura, $altura, $x, $y);

          imagejpeg($nova, $pasta.$nome);
          imagedestroy($img);
          imagedestroy($nova);
          return (file_exists($pasta.$nome)) ? true : false;

       }

        /* CATEGORIA E SUBCATEGORIA
        public function getMenu(){
            $pegar_categorias = "SELECT * FROM `tabela_categorias` ORDER BY id ASC";
            $executar = self::conn()->prepare($pegar_categorias);
            $executar->execute();
            if($executar->rowCount()==0){}else{
              while($categoria = $executar->fetchObject()){
                echo '<li class="main-nav-list">
						<a data-toggle="collapse" href="'.$categoria->titulo.'" aria-expanded="false" aria-controls="'.$categoria->titulo.'">
							<span class="lnr lnr-arrow-right" href="'.PATH.'loja/'.$categoria->slug.'"></span>'.utf8_encode($categoria->titulo).'</a>';

                $pegar_subcategorias = "SELECT * FROM `tabela_subcategorias` WHERE id_cat = ?";
                $executar_sub = self::conn()->prepare($pegar_subcategorias);
                $executar_sub->execute(array($categoria->id));
                if($executar_sub->rowCount()==0){
					echo '</li>';
				}else{
                    echo '<ul class="collapse" id="'.$categoria->titulo.'" data-toggle="collapse" aria-expanded="false" aria-controls="'.$categoria->titulo.'">
							<a id="categoria" href="'.PATH.'loja/'.$categoria->slug.'">
								<span id="categoria" href="'.PATH.'loja/'.$categoria->slug.'"></span>'.utf8_encode($categoria->titulo).'</a>';

					while($subcategoria = $executar_sub->fetchObject()){
                        echo '<li  class="main-nav-list child"><a href="'.PATH.'loja/'.$categoria->slug.'/'.$subcategoria->slug.'">'.$subcategoria->titulo.'</a></li>';
                    }
                    echo '</ul></li>';
                  }
                }
            }
        }*/

      /*  //SUBCATEGORIA HOME
        public function getSubcategoriaHome(){
            $pegar_categorias = "SELECT * FROM `tabela_subcategorias` ORDER BY id DESC";
            $executar = self::conn()->prepare($pegar_categorias);
            $executar->execute();
            if($executar->rowCount()==0){}else{
              while($subcategoria = $executar->fetchObject()){
                echo '<li><a href="'.PATH.'loja/'.$subcategoria->cat_slug.'/'.$subcategoria->slug.'">'.$subcategoria->titulo.'</a></li>';
              }
            }
        } Se for feito um dia para subcategoria, criar novo campo na tabela com slug de categoria*/

    }
?>
