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
    $quantidadeEmListaPedido = 0;

    $sql = "SELECT * FROM `ItensPedido` WHERE `idProduto` = '$idProduto' AND `status` = 0";
    $sqlProdutoQuantidade = $conecta->query($sql) or die (json_encode(array('mensagem'=>'erro', 'erro'=> $conecta->error)));
    if($sqlProdutoQuantidade->num_rows >0){
      while ($r = $sqlProdutoQuantidade->fetch_assoc()) {
        $quantidadeInseridaProduto = $r['Quantidade'];
        $quantidadeEmListaPedido = $quantidadeInseridaProduto + $quantidadeProduto;
      }
    }


    $busca = "SELECT `Quantidade` FROM `Estoque` WHERE `idProduto` =  '$idProduto'";
    $retorno = $conecta->query($busca) or die (json_encode(array('mensagem'=>'erro', 'erro'=> $conecta->error)));
    if($retorno->num_rows == 0){
      echo json_encode(array('mensagem'=>'erro', 'erro'=> 'Produto não encontra-se no Estoque', 'quantidadeEstoque'=> 0));
      exit();
    }


    while ($r = $retorno->fetch_assoc()) {
      $quantidadeEmEstoque = $r['Quantidade'];
      if(($quantidadeEmEstoque - $quantidadeEmListaPedido) >= 0 ){
        $query = "INSERT INTO `ItensPedido`(`IdPedido`, `idProduto`, `Quantidade`) VALUES ('$idPedidoEstoque' , '$idProduto' , '$quantidadeProduto')
        ON DUPLICATE KEY UPDATE Quantidade = Quantidade + $quantidadeProduto;";
        $SQL->setDadosBD($query);
      }else{
        echo json_encode(array('mensagem'=>'erro', 'erro'=> 'Estoque com quantidade inferior ao solicitado', 'quantidadeEstoque'=> ($quantidadeEmEstoque - $quantidadeEmListaPedido + $quantidadeProduto)));
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
        $SQL->setDadosBD($query);
      }else{
        echo json_encode(array('mensagem'=>'erro', 'erro'=> 'Item já foi cancelado'));
      }
    }
  }

  if($requestHTTP == 'finalizarVenda'){
    $idPedidoEstoque = isset($_REQUEST['idPedidoEstoque']) ? $_REQUEST['idPedidoEstoque'] : null;
    $formaPagamento = isset($_REQUEST['formaPagamento']) ? $_REQUEST['formaPagamento'] : null;
    $total = isset($_REQUEST['total']) ? $_REQUEST['total'] : null;

    $itensRetiradaEstoque = array();
    $retornoCON = $conecta->query("SELECT * FROM `ItensPedido` WHERE `IdPedido` = '$idPedidoEstoque' AND `status` = 0");
    if($retornoCON->num_rows > 0){
      while ($r = $retornoCON->fetch_assoc()) {
        $quantidade = $r['Quantidade'];
        $idProduto = $r['idProduto'];
        $id = $r['id'];
        $query_ = "UPDATE `Estoque` SET `Quantidade` = `Quantidade` - $quantidade WHERE `idProduto` =  '$idProduto'";
        if($conecta->query($query_)){
          $query = "UPDATE `ItensPedido` SET `status`= '2' WHERE `id` = '$id';";
          $conecta->query($query) or die (json_encode(array('mensagem'=>'erro', 'erro'=> $conecta->error)));
        }
      }
      $query_ = "UPDATE `PedidoEstoque` SET `idFormaPagamento`= '$formaPagamento',`Total`= '$total' WHERE `id` = '$idPedidoEstoque' ";
      $SQL->setDadosBD($query_);
    }
  }
}


?>
