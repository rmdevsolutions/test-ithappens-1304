<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/css/init.css">
  <link rel="stylesheet" href="assets/css/venda.css">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;400;600;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
  <title></title>
</head>
<body>

  <nav>
    <div class="header elevacao">
      <div class="row h-100">
        <div class="col-md-4">
          <div class="">
            <img class="logo" src="assets/imagens/logo.png" alt="">
          </div>
        </div>
        <div class="col-md-8">
          <span class="letreiro-header">Pedido de Compra Nº <span id="idPedidoEstoque_">17</span></span>
        </div>
      </div>
    </div>
  </nav>

  <section>
    <div class="comandos">
      <div class="row">
        <div class="col-md-8"></div>
        <div class="col-md-1">
          <div onclick="$('#modalPesquisaAvancada').modal()" class="button-seletor elevacao">
            <img src="assets/imagens/pesquisar.png" alt="">
            <span>Localizar(F2)</span>
          </div>
        </div>

        <div class="col-md-1">
          <div onclick="$('#modalCancelamentodeItem').modal();" class="button-seletor elevacao">
            <img src="assets/imagens/cancelar.png" alt="">
            <span>Cancelar(F3)</span>
          </div>
        </div>

        <div class="col-md-1">
          <div onclick="$('#modalSelecaoFormaPagamento').modal()" class="button-seletor elevacao">
            <img src="assets/imagens/finalizar.png" alt="">
            <span>Finalizar(F4)</span>
          </div>
        </div>
      </div>
    </div>

    <div class="cumpoFiscal">
      <div class="cupom elevacao">
        <span class="tituloCupom">CUPOM FISCAL</span>
        <div class="row" style="margin-top:100px">
          <div class="col-md-12">
            <table>
              <thead>
                <th>Item</th>
                <th>Codigo</th>
                <th>Descrição</th>
              </thead>
              <thead style="text-align: center;border-bottom:2px black solid">
                <th>Quantidade</th>
                <th>x Valor unitário</th>
                <th>Valor (R$)</th>
              </thead>

              <tbody id="tCupom">
                <!-- <tr class="tr_superior">
                <td>01</td>
                <td>85487474</td>
                <td>Arroz Tipo 1</td>
              </tr>
              <tr class="tr_abaixo">
              <td>25</td>
              <td>3.5</td>
              <td>R$ 25.58</td>
            </tr> -->
          </tbody>

        </table>
      </div>

    </div>
  </div>
</div>

<div class="descritivo">
  <div class="row">
    <div class="col-md-6"></div>
    <div class="col-md-5">
      <label for="">Produto/Codigo:</label>
      <input type="text" readonly class="form-control" name="ddlProdutoVenda"  id="ddlProdutoVenda" value="">
    </div>
  </div>

  <div class="row mt-30">
    <div class="col-md-6"></div>
    <div class="col-md-5">
      <label for="">Quantidade:</label>
      <input type="text" readonly class="form-control" name="ddlQuantidadeProdutoVenda" id="ddlQuantidadeProdutoVenda" value="">
    </div>
  </div>
  <div class="row ">
    <div class="col-md-7"></div>
    <div class="col-md-3">
      <div class="position-subtotal">
        <span>Total</span>
        <div class="button-total elevacao">
          <span>R$ </span> <span id="subtotal">0</span>
        </div>
      </div>
    </div>
  </div>


</div>

<div class="codigoBarras">
  <label id="informacaoInputProduto" style="margin-left:75px" for="">Informe o codigo de barras:</label>
  <div class="barras">
    <input type="text" id="campoEntradaVendas" class="form-control input-barras codigoBarrasVendas" name="" value="">
  </div>
</div>



</section>


<footer>
  <div class="barra-info">
    <div class="container lh-30">
      <span class="span-info">Operador:</span><span class="mr-30"> <?php echo $_SESSION['__OPERADOR__']; ?> </span>

      <span class="span-info">Filial:</span><span class="mr-30"><?php echo $_SESSION['__FILIAL__']; ?></span>
      <input type="hidden" name="idFilialPedidoEstoque" id="idFilialPedidoEstoque" value=" <?php echo $_SESSION['__IDFILIAL__']; ?> ">

      <span class="span-info">Horário:</span><span id="horarioAtual" class="mr-30"></span>
    </div>
  </div>
</footer>


<!-- Modal de Selecao de Forma de Pagamento -->

<div class="modal fade" tabindex="-1" role="dialog" id="modalSelecaoFormaPagamento" aria-labelledby="modalSelecaoFormaPagamento" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cadastro de Produtos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <label for="">Forma de Pagamento</label>
            <select class="form-control" id="selectFormaPagamento" name="selectFormaPagamento">
              <option value="1">À Vista</option>
              <option value="2">Boleto</option>
              <option value="3">Cartão de Crédito</option>
            </select>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" onclick="cadastrar.finalizarVenda()" class="btn btn-primary">Finalizar Venda</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="modalCancelamentodeItem" aria-labelledby="modalCancelamentodeItem" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cancelamento de Itens</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <label for="">Qual Item será cancelado?</label>
            <input type="text" class="form-control" name="itemCancelamento" id="itemCancelamento" value="">
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" onclick="cadastrar.cancelarItensPedido($('#itemCancelamento').val())" class="btn btn-primary">Cancelar Item</button>
      </div>
    </div>
  </div>
</div>


<!-- modal de Pesquisa Avançada -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalPesquisaAvancada" aria-labelledby="modalPesquisaAvancada" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pesquisa Avançada</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <label for="">Pesquise por Codigo de barras ou Descrição do Produto</label>
            <input onkeydown="consultar.consultaAvancada( $('#idFilialPedidoEstoque').val(),this.value)" type="text" class="form-control" name="itemPesquisaAvancada" id="itemPesquisaAvancada" value="">
          </div>
        </div>
        <div class="row" style="margin-top:70px">
          <div class="col-md-12">
            <table  id="consultaAvancadaTabela" class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">COD</th>
                  <th scope="col">Produto</th>
                  <th scope="col">Qnt</th>
                  <th scope="col">Qnt Pedido</th>
                  <th scope="col">Ações</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/js/vendas.js"></script>
<script type="text/javascript">
$(document).ready(function(){

  horario=()=>{
    setInterval(function(){
      let data = new Date();
      $('#horarioAtual').text(data.getHours() +':'+data.getMinutes() +':'+data.getSeconds())
      // console.log(data.getHours() +':'+data.getMinutes() +':'+data.getSeconds());
    },1000);
  }
  horario();
  $('#idPedidoEstoque_').text(getQuery('idPedidoEstoque'));

})
</script>
</body>
</html>
