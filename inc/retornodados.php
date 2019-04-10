<?php
    require_once "../classes/Site.class.php";
    $Site = new Site();
    if( $status->getValue() == 3){
        include_once "../config.php";
        require_once "../classes/BD.class.php";
        BD::conn();
        $sql = "UPDATE `tblcdsped` SET status = '1' modificado = NOW() WHERE id = ?";
        $executarSql = BD::conn()->prepare($sql);
        $executarSql->execute(array($idPedido)); //tratar id
        $pegar_id_cliente = BD::conn()->prepare("SELECT id FROM `tblcdsped` WHERE id = ?");
        $pegar_id_cliente->execute(array($idPedido));
        $fetchCliente = $pegar_id_cliente->fetchObject();
        $pegar_dados_cliente = BD::conn()->prepare("SELECT nome, email FROM `tblcdsprof` WHERE id = ?");
        $pegar_dados_cliente->execute(array($fetchCliente->id));
        $dadosCliente = $pegar_dados_cliente->fetchObject();
        //manda email para o cliente
        $msg = 'Teste de envio';
        $destino = $dadosCliente->email;
        $site->Sendmail('info produto', $msg, 'efarm.utfpr@gmail.com', 'eFarm', $destino, $dadosCliente->nome);

    }
?>
