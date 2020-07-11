<?php
include('funcoes.php');
include('conexao.php');

$SQL =  new InteracaoBD($conecta);
$requestHTTP = isset($_REQUEST['solicitacao']) ? $_REQUEST['solicitacao'] : null;

if($requestHTTP == 'consultarFiliais'){
  $SQL->getDadosBD('SELECT * FROM `Filial`');
}


if($requestHTTP == 'consultarUsuarios'){
  $SQL->getDadosBD('SELECT * FROM `Usuario`');
}

if($requestHTTP == 'consultarCliente'){
  $cpfCliente = isset($_REQUEST['cpfCliente']) ? $_REQUEST['cpfCliente'] : null;
  $SQL->getDadosBD("SELECT * FROM `Cliente` WHERE `CPF` like '%".$cpfCliente."%'");
}

if($requestHTTP == 'consultarEstoqueFilial'){
  $idFilial = isset($_REQUEST['idFilial']) ? $_REQUEST['idFilial'] : null;
  $sql = "SELECT
  A.`id`,
  `idFilial`,
  B.nome AS 'Filial',
  `idProduto`,
  C.produto AS 'Produto',
  C.codigoBarras,
  `Quantidade`
  FROM
  `Estoque` A
  INNER JOIN `Filial` B ON
  (A.idFilial = B.id)
  INNER JOIN `Produto` C ON
  (A.idProduto = C.id) WHERE A.`idFilial` = '$idFilial'";
  $SQL->getDadosBD($sql);

}


if($requestHTTP == 'consultarVendasFilial'){
  $idFilial = isset($_REQUEST['idFilial']) ? $_REQUEST['idFilial'] : null;
  $sql = "SELECT `id`, `idFilial`, `Total` FROM `PedidoEstoque` WHERE `idFilial` = '$idFilial'";
  $SQL->getDadosBD($sql);
}

if($requestHTTP == 'consultarClientesGeral'){
  $SQL->getDadosBD('SELECT * FROM `Cliente`');
}

if($requestHTTP == 'consultarProdutoVenda'){
  $codigoBarras = isset($_REQUEST['codigoBarras']) ? $_REQUEST['codigoBarras'] : null;
  $SQL->getDadosBD("SELECT * FROM `Produto` WHERE `codigoBarras` = '$codigoBarras'");
}

if($requestHTTP == 'consultarBarrasRelativo'){
  $codigoBarras = isset($_REQUEST['string']) ? $_REQUEST['string'] : null;
  $idFilial = isset($_REQUEST['idFilial']) ? $_REQUEST['idFilial'] : null;
  $sql = "SELECT
  A.`id`,
  `codigoBarras`,
  `Produto`,
  `valor`,
  `Descricao`,
  B.Quantidade,
  B.idProduto
  FROM
  `Produto` A
  INNER JOIN `Estoque` B ON
  (A.id = B.idProduto)
  WHERE
  `codigoBarras` LIKE '%".$codigoBarras."%' AND B.idFilial = '$idFilial'";
  $SQL->getDadosBD($sql);

}

if($requestHTTP == 'consultarProdutoRelativo'){
  $descricaoProduto = isset($_REQUEST['string']) ? $_REQUEST['string'] : null;
  $idFilial = isset($_REQUEST['idFilial']) ? $_REQUEST['idFilial'] : null;
  $sql = "SELECT
  A.`id`,
  `codigoBarras`,
  `Produto`,
  `valor`,
  `Descricao`,
  B.Quantidade,
  B.idProduto
  FROM
  `Produto` A
  INNER JOIN `Estoque` B ON
  (A.id = B.idProduto)
  WHERE
  `Produto` LIKE '%".$descricaoProduto."%' AND B.idFilial = '$idFilial'";
  $SQL->getDadosBD($sql);
}

if($requestHTTP == 'consultarProdutosInserirEstoque'){
  $sql = "SELECT DISTINCT `id`, `codigoBarras`, `Produto`, `valor`, `Descricao` FROM `Produto`";
  $SQL->getDadosBD($sql);
}

?>
