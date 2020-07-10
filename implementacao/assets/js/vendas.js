
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

$(document).keydown(function(event){
  if(event.which == 115){ // F4
    $('#modalSelecaoFormaPagamento').modal()
    return false;
  }
  else if(event.which == 114){
    $('#modalCancelamentodeItem').modal();
    return false;
  }
})


let contador = 0;
var cadastrar = {
  idProduto: undefined,
  valorProduto: undefined,
  barras: undefined,
  descricao: undefined,
  quantidade: (quantidade)=>{
    $.getJSON('assets/conexao/__Venda.php' , {solicitacao: 'insertItensPedido' , idPedidoEstoque: getQuery('idPedidoEstoque') , quantidadeProduto: quantidade , idProduto : cadastrar.idProduto} , function(e){
      console.log(e);
      var resultadoArray = [];
      resultadoArray.push(e);
      console.log(resultadoArray);
      resultadoArray.forEach(function(e){
        if(e.mensagem == 'sucesso'){
          contador++
          $('#ddlQuantidadeProdutoVenda').val(quantidade)
          $('#subtotal').text(parseInt($('#subtotal').text()) + (quantidade * cadastrar.valorProduto))
          $('#informacaoInputProduto').text('Informe o codigo de barras:')
          $('#campoEntradaVendas').removeClass('quantidadeProdutoVendas').addClass('codigoBarrasVendas').val('')

          $('#tCupom').append(`
            <tr class="tr_superior linha_${e.ID}">
            <td>${contador.toString.length == 1 ? '0'+contador : contador}</td>
            <td>${cadastrar.barras}</td>
            <td>${cadastrar.descricao}</td>
            <td> <input type="hidden" value="${e.ID}" id="item_${contador}" </td>
            </tr>
            <tr class="tr_abaixo linha_${e.ID}">
            <td>${quantidade}</td>
            <td>${cadastrar.valorProduto}</td>
            <td>R$ ${cadastrar.valorProduto * quantidade}</td>
            <td> <input type="hidden" value="${cadastrar.valorProduto * quantidade}" id="valorItem_${contador}" </td>
            </tr>
            `);
          }else{
            console.log(e);
            alert(e.erro + ' / Qnt Disponível: '+e.quantidadeEstoque)
            $('#informacaoInputProduto').text('Informe o codigo de barras:')
            $('#campoEntradaVendas').removeClass('quantidadeProdutoVendas').addClass('codigoBarrasVendas').val('')
          }
        })
      });
    },
    finalizarVenda:()=>{
      $.getJSON('assets/conexao/__Venda.php', {
        solicitacao: 'finalizarVenda',
        idPedidoEstoque: getQuery('idPedidoEstoque') ,
        formaPagamento : $('#selectFormaPagamento option:selected').val(),
        total: parseInt($('#subtotal').text())
      }, function(e){
        console.log(e);
        if(e.mensagem=='sucesso'){
          alert('venda realizada, retorne ao início')
          window.location.assign('index.php');
        }else{
          alert('Ocorreu um erro')
          console.log(e.erro);
        }
      })
    },
    cancelarItensPedido:(item)=>{
      var idItem = $('#item_' + Number(item).toString()).val();
      $.getJSON('assets/conexao/__Venda.php', { solicitacao:'cancelarItensPedido' , idItem: idItem} , function(e){
        if(e.mensagem == 'sucesso'){
          $('#subtotal').text(parseInt($('#subtotal').text()) - parseInt($('#valorItem_' + Number(item).toString()).val()))
          $('.linha_'+idItem).addClass('itemCancelado');
          $('.modal').modal('hide');
        }else{
          alert('erro')
        }
      })
    }
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
          cadastrar.descricao = value.Produto;
          cadastrar.barras = codigoBarras;
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
