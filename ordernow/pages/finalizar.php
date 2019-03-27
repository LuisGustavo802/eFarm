<?php
	if(!$login->isLogado()){
		header("Location: ".PATH."");
	}elseif ($Carrinho->qtdProdutos() == 0) {
	    header("Location: ".PATH."");
	}else{
		if(!isset($_SESSION['realizado'])){
			$strSQL = "INSERT INTO `tabela_pedidos` (id_cliente, valor_total, status, criado, modificado) VALUES (?,?,0,NOW(),NOW())";
			$stmt = BD::conn()->prepare($strSQL);
			$stmt->execute(array($usuarioLogado->id_cliente, $_SESSION['total_compra']));
			$_SESSION['lastId'] = BD::conn()->lastInsertId();

			foreach($_SESSION['ordernow_produto'] as $id => $qtd){
				$strSQLdois = "INSERT INTO `tabela_produtos_pedidos` (id_pedido, id_produto, qtd) VALUES (?,?,?)";
				$stmtdois = BD::conn()->prepare($strSQLdois);
				$stmtdois->execute(array($_SESSION['lastId'], $id, $qtd));
			}

			$_SESSION['realizado'] = 1;
		}
	}