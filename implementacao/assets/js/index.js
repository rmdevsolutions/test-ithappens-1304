
$(document).keydown(function(event) {
  if(event.which == 113) { //F2
    $('#modalIniciarVenda').modal()
    return false;
  }
  else if(event.which == 114) { //F3
    $('#modalControleEstoque').modal()
    return false;
  }
  else if(event.which == 115) { //F4
    $('#modalVendasRealizadas').modal()
    return false;
  }
  else if(event.which == 117){ //F6
    $('#modalInserirClientes').modal()
    return false;
  }

  else if(event.which == 118){ //F7
    $('#modalInserirProdutos').modal()
    return false;
  }
});

$('#cpfCliente').keydown(function(event) {
  if(event.which == 13) { //ENTER
    consultar.cliente($('#cpfCliente').val());
    return false;
  }
})

$('#nomeCliente').keydown(function(event) {
  if(event.which == 13) { //ENTER
    cadastrar.cliente($('#cpfCliente').val(), $('#nomeCliente').val());
    return false;
  }
})

var cadastrar = {
  url: 'assets/conexao/__CadastrarDados.php',
  cpfCliente: undefined,
  nomeCliente: undefined,
  idCliente: undefined,
  idFilial: undefined,
  idUsuario: undefined,
  observacaoEntrega: undefined,
  cliente:(cpf,nome , cadastroView = false)=>{
    $.ajax({
      type: 'GET',
      dataType: 'JSON',
      data: {cpfCliente: cpf , nomeCliente: nome , solicitacao: 'cadastrarCliente'},
      url: cadastrar.url,
      success: (e)=>{
        if(e.mensagem == 'sucesso'){
          if(cadastroView == false){
            mensagemSucesso('Cliente cadastrado com sucesso, prossiga com a venda')
            $('#cpfCliente, #nomeCliente').attr('readonly', true)
            cadastrar.cpfCliente = cpf;
            cadastrar.nomeCliente = nome;
            cadastrar.idCliente = e.ID;
          }else{
            alert('Cliente cadastrado');
            consultar.todosClientes()
          }
        }else{
          alert('Cliente já encontra-se na base')
        }
      },
      error: (e)=>{
        mensagemErro('Não foi possível incluir o novo cliente')
      }
    })
  },

  pedidoEstoque:()=>{

    var obrigatorio = document.querySelectorAll('.obrigatorio');
    var contadorErro = 0;
    obrigatorio.forEach((item, i) => {
      if(item.type =="text"){
        if(item.value == ""){
          contadorErro ++
          $(item).addClass('comErro').removeClass('semErro');
        }else{
          $(item).addClass('semErro').removeClass('comErro');
        }
      }else{
        if($('#'+item.id + ' option:selected').val() == 'null'){
          contadorErro ++
          $(item).addClass('comErro').removeClass('semErro');
        }else{
          $(item).addClass('semErro').removeClass('comErro');
        }
      }
    });

    if(contadorErro > 0){
      mensagemErro('Preencha os campos obrigatórios');
      return
    }


    console.log('passou');
    $.ajax({
      type: 'GET',
      dataType: 'JSON',
      data: {
        idCliente: cadastrar.idCliente ,
        idFilial: $('#idFilial option:selected').val() ,
        idUsuario: $('#idUsuario option:selected').val() ,
        observacaoEntrega: $('#observacaoEntrega').val(),
        solicitacao: 'cadastrarPedidoEstoque',
      },
      url: cadastrar.url,
      success: (e)=>{
        if(e.mensagem == 'sucesso'){
          mensagemSucesso('Pedido de Estoque nº ' + e.ID + ' criado para o cliente '+cadastrar.nomeCliente)
          window.location.assign('venda.php?idPedidoEstoque='+e.ID)
        }
      },
      error: (e)=>{
        mensagemErro('Não foi possível iniciar a venda')
      }
    })
  }
}

var consultar = {

  geral: (solicitacao, exibicao, classeSelect)=>{
    $.getJSON('assets/conexao/__ConsultarDados.php?solicitacao='+solicitacao, function(e){
      $(classeSelect).empty();
      $(classeSelect).append('<option value="null">Selecione</option>');
      $.each(e, function(k,valor){
        $(classeSelect).append("<option value='" + valor.id + "'>" + valor[exibicao] + "</option>");
      })
    })
  },

  cliente: (cpf)=>{
    let retorno = new Array();
    $.getJSON('assets/conexao/__ConsultarDados.php?solicitacao=consultarCliente', {cpfCliente: cpf} , function(e){
      if(e.length > 0){
        $('#nomeCliente').val(e[0].Nome)
        cadastrar.cpfCliente = cpf;
        cadastrar.nomeCliente = e[0].Nome;
        cadastrar.idCliente = e[0].id;
      }else{
        mensagemErro('Cliente não cadastrado, informe um nome para continuar');
        $('#nomeCliente').removeAttr('readonly').focus();
      }
    })
  },

  estoqueFilial:(idFilial)=>{
    $.getJSON('assets/conexao/__ConsultarDados.php?solicitacao=consultarEstoqueFilial', {idFilial: idFilial} , function(data){
      let dataSet = [];
      $.each(data, function(k,e){
        dataSet.push([e.codigoBarras , e.Produto , e.Quantidade , '<>'])
      })
      inserirDataTable(dataSet, '#estoqueFilial')
    })
  },

  vendasFilial:(idFilial)=>{
    $.getJSON('assets/conexao/__ConsultarDados.php?solicitacao=consultarVendasFilial', {idFilial: idFilial} , function(data){
      let dataSet = [];
      $.each(data, function(k,e){
        dataSet.push([e.id , e.Total , '<>'])
      })
      inserirDataTable(dataSet, '#vendasFilial')
    })
  },

  todosClientes:()=>{
    $.getJSON('assets/conexao/__ConsultarDados.php?solicitacao=consultarClientesGeral', function(data){
      let dataSet = [];
      $.each(data, function(k,e){
        dataSet.push([e.id , e.Nome , e.CPF ])
      })
      inserirDataTable(dataSet, '#clientesCadastrados')
    })
  },

}


var mensagemErro = (mensagem)=>{
  $('#alertaErro').text(mensagem);
  $('#alertaSucesso').css('display','none');
  $('#alertaErro').css('display','block');
}

var mensagemSucesso = (mensagem)=>{
  $('#alertaSucesso').text(mensagem);
  $('#alertaErro').css('display','none');
  $('#alertaSucesso').css('display','block');
}

var inserirDataTable = (dataSet, elemento , quantidade = 5)=>{
  $(elemento).DataTable(
    {
      "aaData": dataSet,
      "destroy": true,
      "pages": 1,

      responsive: true,
      columnDefs: [
        { responsivePriority: 1, targets: -1 },
        { responsivePriority: 2, targets: 0 }
      ],
      "lengthMenu": [
        [quantidade, quantidade + 10, quantidade + 20 , quantidade + 100, 10000],
        [quantidade, quantidade + 10 , quantidade + 20, quantidade + 100, 'TUDO']
      ],
      "language":
      {
        "lengthMenu": "Exibir _MENU_ itens por página",
        "zeroRecords": "Não encontrado",
        "info": "Exibindo pagina _PAGE_ de _PAGES_",
        "infoEmpty": "Sem registros",
        "infoFiltered": "(filtrado de _MAX_ registros)"
      }
    });
  }
