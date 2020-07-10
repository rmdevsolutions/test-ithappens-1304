
$('#campoEntradaVendas').keydown(function(event) {
  console.log(this);
  if($(this).hasClass('quantidadeProdutoVendas')){
    if(event.which == 13) { //F2
      cadastrar.quantidade(this.value)
      return false;
    }
  }else{
    if(event.which == 13) { //F2
      consultar.produto(this.value)
      return false;
    }
  }
})



var cadastrar = {
  idProduto: undefined,
  valorProduto: undefined,
  quantidade: (quantidade)=>{
    $.getJSON('assets/conexao/__Venda.php' , {solicitacao: 'insertItensPedido' , idPedidoEstoque: getQuery('idPedidoEstoque') , quantidadeProduto: quantidade , idProduto : cadastrar.idProduto} , function(e){
      console.log(e);
      var resultadoArray = [];
      resultadoArray.push(e);
      console.log(resultadoArray);
      resultadoArray.forEach(function(e){
        if(e.mensagem == 'sucesso'){
          $('#ddlQuantidadeProdutoVenda').val(quantidade)
          $('#subtotal').text(parseInt($('#subtotal').text()) + (quantidade * cadastrar.valorProduto))
          $('#informacaoInputProduto').text('Informe o codigo de barras:')
          $('#campoEntradaVendas').removeClass('quantidadeProdutoVendas').addClass('codigoBarrasVendas').val('')
          console.log(e);
        }else{
          console.log(e);
          alert(e.erro + ' / Qnt Disponível: '+e.quantidadeEstoque)
          $('#informacaoInputProduto').text('Informe o codigo de barras:')
          $('#campoEntradaVendas').removeClass('quantidadeProdutoVendas').addClass('codigoBarrasVendas').val('')
        }
      })
    });
  },
};

var consultar = {
  produto:(codigoBarras)=>{
    $.getJSON('assets/conexao/__ConsultarDados.php' , {solicitacao: 'consultarProdutoVenda' , codigoBarras: codigoBarras} , function(e){
      if(e.length == 0){
        alert('Produto não localizado');
        $('#campoEntradaVendas').focus()
      }
      $.each(e, function(k, value){
        $('#ddlProdutoVenda').val(value.Produto)
        $('#informacaoInputProduto').text('Informe a quantidade para retirada de estoque')
        $('#campoEntradaVendas').removeClass('codigoBarrasVendas').addClass('quantidadeProdutoVendas').val('')
        cadastrar.idProduto = value.id;
        cadastrar.valorProduto = value.valor;

      })
    })
  },


};

getQuery = (parametro)=> {
  parametro = parametro.replace(/[\[\]]/g, '\\$&');
  var regex = new RegExp('[?&]' + parametro + '(=([^&#]*)|&|#|$)'),
  results = regex.exec(window.location.href);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, ' '));
}
