<?php
	if(!$login->isLogado()){
		header("Location: ".PATH."");
	}elseif ($Carrinho->qtdProdutos() == 0) {
	  header("Location: ".PATH."");
	}elseif ($_SESSION['unepe'] == "0"){
			echo '<script>alert("Não foi possivel finalizar o pedido, a unepe não foi selecionada");location.href="'.PATH.'carrinho"</script>';
	}else{
		if(!isset($_SESSION['realizado'])){
			$strSQL = "INSERT INTO `tblmvmped` (id_prof, valor_total, unepe, status, criado) VALUES (?,?,?,0,NOW())";
			$stmt = BD::conn()->prepare($strSQL);
			$stmt->execute(array($usuarioLogado->id, $_SESSION['total_compra'],  $_SESSION['unepe']));
			$_SESSION['lastId'] = BD::conn()->lastInsertId();
			foreach($_SESSION['eFarm_produto'] as $id => $qtd){
				$strSQLdois = "INSERT INTO `tblmvmprodped` (id_pedido, id_produto, qtd, unepe) VALUES (?,?,?,?)";
				$stmtdois = BD::conn()->prepare($strSQLdois);
				$stmtdois->execute(array($_SESSION['lastId'], $id, $qtd,  $_SESSION['unepe']));

        $atualizar_qtds = BD::conn()->prepare("UPDATE `tblcdsprod` SET estoque = estoque-$qtd WHERE id = ?");
        $atualizar_qtds->execute(array($id));
			}
			$_SESSION['realizado'] = 1; //tratar depois, deve sumir para fazer inserção de pedidos
		}
	}
?>