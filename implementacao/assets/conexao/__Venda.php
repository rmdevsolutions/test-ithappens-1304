<?php
include('funcoes.php');
include('conexao.php');

$SQL =  new InteracaoBD($conecta);


if($_SERVER['REQUEST_METHOD'] == 'GET'){
  $requestHTTP = isset($_REQUEST['solicitacao']) ? $_REQUEST['solicitacao'] : null;


  if($requestHTTP == 'initPedidoEstoque'){
    $idFilial = isset($_REQUEST['idFilial']) ?  $_REQUEST['idFilial'] : null;
    $idCliente = isset($_REQUEST['idCliente']) ?  $_REQUEST['idCliente'] : null;
    $idUsuario = isset($_REQUEST['idUsuario']) ?  $_REQUEST['idUsuario'] : null;


    $query = "INSERT INTO `PedidoEstoque`(`idFilial`, `idCliente`, `idUsuario`) VALUES ('$idFilial' , '$idCliente' , '$idUsuario')";
    $SQL->setDadosBD($query);
  }


  if($requestHTTP == 'insertItensPedido'){
    $idPedidoEstoque = isset($_REQUEST['idPedidoEstoque']) ? $_REQUEST['idPedidoEstoque'] : null;
    $idProduto = isset($_REQUEST['idProduto']) ? $_REQUEST['idProduto'] : null;
    $quantidadeProduto = isset($_REQUEST['quantidadeProduto']) ? $_REQUEST['quantidadeProduto'] : null;

    $query = "INSERT INTO `ItensPedido`(`IdPedido`, `idProduto`, `Quantidade`) VALUES ('$idPedidoEstoque' , '$idProduto' , '$quantidadeProduto')";
    $SQL->setDadosBD($query);
  }

  if($requestHTTP == 'cancelarItensPedido'){
    $idItem = isset($_REQUEST['idItem']) ? $_REQUEST['idItem'] : null;

    $query = "UPDATE `ItensPedido` SET `status`= '1' WHERE `id` = '$idItem'";
    $SQL->setDadosBD($query);
  }

  if($requestHTTP == 'finalizarVenda'){
    $idItem = isset($_REQUEST['idItem']) ? $_REQUEST['idItem'] : null;

    $query = "UPDATE `ItensPedido` SET `status`= '1' WHERE `id` = '$idItem'";
    $SQL->setDadosBD($query);
  }
}


?>
