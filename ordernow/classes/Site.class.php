<?php
    class Site extends BD{
        // FUNÇÕES SITE//
        //RETORNA DIA, MES, ANO E HORA
        public function getData(){
            $data = getdate();
            $diaHoje = date('d');
            $array_meses = array(1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro");

            $horaAgora = date('H:i');
            $mesgetdate = $data['mon'];
            $anoAtual = date('Y');

            return 'Hoje, '.$diaHoje.' de '.$array_meses[$mesgetdate].' de '.$anoAtual.', ás '.$horaAgora.'';
        }

        /* CATEGORIA E SUBCATEGORIA */
        public function getMenu(){
            $pegar_categorias = "SELECT * FROM `tabela_categorias` ORDER BY id ASC";
            $executar = self::conn()->prepare($pegar_categorias);
            $executar->execute();
            if($executar->rowCount()==0){}else{
              while($categoria = $executar->fetchObject()){
                echo '<li class="main-nav-list">
						<a data-toggle="collapse" href="#'.$categoria->titulo.'" aria-expanded="false" aria-controls="'.$categoria->titulo.'">
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
        }

        //CATEGORIA PAGINA HOME
        public function getCategoriaHome(){
            $pegar_categorias = "SELECT * FROM `tabela_categorias` ORDER BY id ASC";
            $executar = self::conn()->prepare($pegar_categorias);
            $executar->execute();
            if($executar->rowCount()==0){}else{
              while($categoria = $executar->fetchObject()){
                echo '<li><a href="'.PATH.'loja/'.$categoria->slug.'">'.utf8_encode($categoria->titulo).'</a></li>';
              }
            }
        }

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

        //PRODUTOS HOME
        public function getProdutoHome($limit = false){
          if ($limit == false){
              $query = "SELECT * FROM `tabela_produtos` ORDER BY id DESC";
          }else{
              $query = "SELECT * FROM `tabela_produtos` ORDER BY id DESC LIMIT $limit";
          }
              return self::conn()->query($query);
        }

        //COLECOES HOME
        public function getColecoesHome($limit = false){
          if ($limit == false){
              $query = "SELECT * FROM `tabela_colecoes` ORDER BY id ASC";
          }else{
              $query = "SELECT * FROM `tabela_colecoes` ORDER BY id ASC LIMIT $limit";
          }
              return self::conn()->query($query);
        }

        //CATEGORIA SEARCH
        public function getCategoriaSearch(){
            $pegar_categorias = "SELECT * FROM `loja_categorias` ORDER BY id DESC";
            $executar = self::conn()->prepare($pegar_categorias);
            $executar->execute();
            if($executar->rowCount()==0){}else{
              while($categoria = $executar->fetchObject()){
                echo '<option value="'.$categoria->id.'">'.$categoria->titulo.'</option>';
              }
            }
        }

        //ATUALIZA VIEWS CATEGORIA
        public function atualizarViewCat($slug){
            $strSQL = "UPDATE `tabela_categorias` SET views = views+1 where slug = ?";
            $executar_view = self::conn()->prepare($strSQL);
            $executar_view->execute(array($slug));
        }// atualiza views da categoria

        //ATUALIZA VIEWS SUBCATEGORIA
        public function atualizarViewSub($slug){
            $strSQL = "UPDATE `tabela_subcategorias` SET views = views+1 where slug = ?";
            $executar_view = self::conn()->prepare($strSQL);
            $executar_view->execute(array($slug));
        }// atualiza views da subcategoria

        //ATUALIZA VIEWS PRODUTOS
        public function atualizarViewProd($slug){
            $strSQL = "UPDATE `tabela_produtos` SET views = views+1 where slug = ?";
            $executar_view = self::conn()->prepare($strSQL);
            $executar_view->execute(array($slug));
        }// atualiza views da Produtos

        //PRODUTOS MAIS VISUALIZADOS
        public function getProdView($limit = false){
          if ($limit == false){
              $query = "SELECT * FROM `tabela_produtos` ORDER BY views DESC";
          }else{
              $query = "SELECT * FROM `tabela_produtos` ORDER BY views DESC LIMIT $limit";
          }
              return self::conn()->query($query);
        }

        //QUANTIDADE DE REGISTROS
        public function getRegistros(){
            $regSQL = "SELECT ID FROM `tabela_produtos` ORDER BY ID DESC LIMIT 1";
            $executar_reg = self::conn()->prepare($regSQL);
            $numReg = $executar_reg->execute();
            return  $numReg;
        }

        //PAGINAS MENU TOP
        public function getPaginas(){
            $pegar_paginas = "SELECT * FROM `tabela_paginas` ORDER BY id ASC";
            $executar = self::conn()->prepare($pegar_paginas);
            $executar->execute();
            if($executar->rowCount()==0){}else{
              while($paginas = $executar->fetchObject()){
                echo '<li class="nav-item"><a class="nav-link" href="'.PATH.''.$paginas->slug.'">'.$paginas->titulo.'</a></li>';
              }
            }
        }

		//SUBPAGINAS MENU TOP
        public function getSubpaginas(){
            $pegar_paginas = "SELECT * FROM `tabela_subpaginas` ORDER BY id ASC";
            $executar = self::conn()->prepare($pegar_paginas);
            $executar->execute();
            if($executar->rowCount()==0){}else{
              while($paginas = $executar->fetchObject()){
                echo '<li class="nav-item"><a class="nav-link" href="'.PATH.''.$paginas->slug.'">'.$paginas->titulo.'</a></li>';
              }
            }
        }

    }
?>
