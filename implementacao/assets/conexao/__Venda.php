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

    $busca = "SELECT `Quantidade` FROM `Estoque` WHERE `idProduto` =  '$idProduto'";
    $retorno = $conecta->query($busca) or die (json_encode(array('mensagem'=>'erro', 'erro'=> $conecta->error)));
    while ($r = $retorno->fetch_assoc()) {
      $quantidadeEmEstoque = $r['Quantidade'];
      if(($quantidadeEmEstoque - $quantidadeProduto) >= 0 ){
        $decrementarQuantidade = "UPDATE `Estoque` SET `Quantidade` = `Quantidade` - $quantidadeProduto WHERE `idProduto` =  '$idProduto';";
        $conecta->query($decrementarQuantidade);
        $query = "INSERT INTO `ItensPedido`(`IdPedido`, `idProduto`, `Quantidade`) VALUES ('$idPedidoEstoque' , '$idProduto' , '$quantidadeProduto');";
        $SQL->setDadosBD($query);
      }else{
        echo json_encode(array('mensagem'=>'erro', 'erro'=> 'Estoque com quantidade inferior ao solicitado', 'quantidadeEstoque'=> $quantidadeEmEstoque));
      }
    }


  }

  if($requestHTTP == 'cancelarItensPedido'){
    $idItem = isset($_REQUEST['idItem']) ? $_REQUEST['idItem'] : null;


    $retornoCON = $conecta->query("SELECT * FROM `ItensPedido` WHERE `id` = '$idItem'");
    while ($r = $retornoCON->fetch_assoc()) {
      $quantidade = $r['Quantidade'];
      $idProduto  = $r['idProduto'];
      $status = $r['status'];


      if($status != 1){
        $query = "UPDATE `ItensPedido` SET `status`= '1' WHERE `id` = '$idItem'";
        if($conecta->query($query)){
          $query_ = "UPDATE `Estoque` SET `Quantidade` = `Quantidade` + $quantidade WHERE `idProduto` =  '$idProduto'";
          $SQL->setDadosBD($query_);
        }
      }else{
        echo json_encode(array('mensagem'=>'erro', 'erro'=> 'Item já foi cancelado'));
      }
    }
  }

  if($requestHTTP == 'finalizarVenda'){
    $idPedidoEstoque = isset($_REQUEST['idPedidoEstoque']) ? $_REQUEST['idPedidoEstoque'] : null;
    $formaPagamento = isset($_REQUEST['formaPagamento']) ? $_REQUEST['formaPagamento'] : null;
    $total = isset($_REQUEST['total']) ? $_REQUEST['total'] : null;

    $query = "UPDATE `ItensPedido` SET `status`= '2' WHERE `idProduto` = '$idPedidoEstoque' AND `status` <> 1;";
    if($SQL->setDadosBD($query)){
      $query_ = "UPDATE `PedidoEstoque` SET `idFormaPagamento`= '$formaPagamento',`Total`= '$total' WHERE `id` = '$idPedidoEstoque' ";
      $SQL->setDadosBD($query_);
    }


  }
}


?>
