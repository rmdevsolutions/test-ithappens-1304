<?php
include('funcoes.php');
include('conexao.php');

$SQL =  new InteracaoBD($conecta);
$requestHTTP = isset($_REQUEST['solicitacao']) ? $_REQUEST['solicitacao'] : null;

if($requestHTTP == 'cadastrarCliente'){
  $cpfCliente = isset($_REQUEST['cpfCliente']) ? $_REQUEST['cpfCliente'] : null;
  $nomeCliente = isset($_REQUEST['nomeCliente']) ? $_REQUEST['nomeCliente'] : null;

  $SQL->setDadosBD("INSERT INTO `Cliente`(`CPF`, `Nome`) VALUES ('$cpfCliente', '$nomeCliente')");
}

if($requestHTTP == 'cadastrarPedidoEstoque'){
  $idCliente = isset($_REQUEST['idCliente']) ? $_REQUEST['idCliente'] : null;
  $idFilial = isset($_REQUEST['idFilial']) ? $_REQUEST['idFilial'] : null;
  $idUsuario = isset($_REQUEST['idUsuario']) ? $_REQUEST['idUsuario'] : null;
  $observacaoEntrega = isset($_REQUEST['observacaoEntrega']) ? $_REQUEST['observacaoEntrega'] : null;

  $SQL->setDadosBD("INSERT INTO `PedidoEstoque`(`idFilial`, `idCliente`, `idUsuario`, `obersavacaoEntrega`) VALUES ('$idFilial', '$idCliente' , '$idUsuario', '$observacaoEntrega')");


}
