<?php
include ('funcoes.php');
include ('conexao.php');
session_start();
$conecta->set_charset('utf8');

$SQL = new InteracaoBD($conecta);
$requestHTTP = isset($_REQUEST['solicitacao']) ? $_REQUEST['solicitacao'] : null;

if ($requestHTTP == 'cadastrarCliente')
{
    $cpfCliente = isset($_REQUEST['cpfCliente']) ? $_REQUEST['cpfCliente'] : null;
    $nomeCliente = isset($_REQUEST['nomeCliente']) ? $_REQUEST['nomeCliente'] : null;

    $SQL->setDadosBD("INSERT INTO `Cliente`(`CPF`, `Nome`) VALUES ('$cpfCliente', '$nomeCliente')");
}

if ($requestHTTP == 'cadastrarPedidoEstoque')
{
    $idCliente = isset($_REQUEST['idCliente']) ? $_REQUEST['idCliente'] : null;
    $idFilial = isset($_REQUEST['idFilial']) ? $_REQUEST['idFilial'] : null;
    $idUsuario = isset($_REQUEST['idUsuario']) ? $_REQUEST['idUsuario'] : null;
    $nomeOperador = isset($_REQUEST['nomeOperador']) ? $_REQUEST['nomeOperador'] : null;
    $nomeFilial = isset($_REQUEST['nomeFilial']) ? $_REQUEST['nomeFilial'] : null;
    $observacaoEntrega = isset($_REQUEST['observacaoEntrega']) ? $_REQUEST['observacaoEntrega'] : null;

    $_SESSION['__OPERADOR__'] = $nomeOperador;
    $_SESSION['__IDFILIAL__'] = $idFilial;
    $_SESSION['__FILIAL__'] = $nomeFilial;

    $SQL->setDadosBD("INSERT INTO `PedidoEstoque`(`idFilial`, `idCliente`, `idUsuario`, `obersavacaoEntrega`) VALUES ('$idFilial', '$idCliente' , '$idUsuario', '$observacaoEntrega')");

}

if ($requestHTTP == 'adicionarQuantidadeProdutoEstoqueFilial')
{
    $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
    $quantidade = isset($_REQUEST['quantidade']) ? $_REQUEST['quantidade'] : null;

    $sql = "UPDATE `Estoque` SET `Quantidade`= `Quantidade` + $quantidade WHERE `id` = '$id'";
    $SQL->setDadosBD($sql);
}

if ($requestHTTP == 'incluirProdutoEmEstoqueFilial')
{
    $id = isset($_REQUEST['idProduto']) ? $_REQUEST['idProduto'] : null;
    $quantidade = isset($_REQUEST['quantidade']) ? $_REQUEST['quantidade'] : null;
    $idFilial = isset($_REQUEST['idFilial']) ? $_REQUEST['idFilial'] : null;

    $sql = "INSERT INTO `Estoque`(`idFilial`, `idProduto`, `Quantidade`) VALUES ('$idFilial' , '$id' , '$quantidade') ON DUPLICATE KEY UPDATE `Quantidade` = `Quantidade`+ $quantidade";
    $SQL->setDadosBD($sql);
}

if ($requestHTTP == 'cadastrarProduto')
{
    $codigoProduto = isset($_REQUEST['codigoProduto']) ? $_REQUEST['codigoProduto'] : null;
    $nomeProduto = isset($_REQUEST['nomeProduto']) ? $_REQUEST['nomeProduto'] : null;
    $valorProduto = isset($_REQUEST['valorProduto']) ? $_REQUEST['valorProduto'] : null;
    $descricaoProduto = isset($_REQUEST['descricaoProduto']) ? $_REQUEST['descricaoProduto'] : null;

    $sql = "INSERT INTO `Produto`(`codigoBarras`, `Produto`, `valor`, `Descricao`) VALUES ('$codigoProduto' , '$nomeProduto' , '$valorProduto' , '$descricaoProduto')";
    $SQL->setDadosBD($sql);

}

if ($requestHTTP == 'cadastrarUsuario')
{
    $nomeUsuario = isset($_REQUEST['nomeUsuario']) ? $_REQUEST['nomeUsuario'] : null;
    $sql = "INSERT INTO `Usuario`(`Nome`, `idFilial`) VALUES ('$nomeUsuario' , 1)";
    $SQL->setDadosBD($sql);
}
