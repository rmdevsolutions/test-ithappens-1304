$('#campoEntradaVendas').keydown(function(event)
{
    console.log(this);
    if ($(this).hasClass('quantidadeProdutoVendas'))
    {
        if (event.which == 13)
        { //F2
            cadastrar.quantidade(this.value)
            return false;
        }
    }
    else
    {
        if (event.which == 13)
        { //F2
            consultar.produto(this.value)
            return false;
        }
    }
})
$(document).keydown(function(event)
{
    if (event.which == 115)
    { // F4
        $('#modalSelecaoFormaPagamento').modal()
        return false;
    }
    else if (event.which == 113)
    { // F2
        $('#modalPesquisaAvancada').modal();
        return false;
    }
    else if (event.which == 114)
    { // F3
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
    quantidade: (quantidade) =>
    {
        $.getJSON('assets/conexao/__Venda.php',
        {
            solicitacao: 'insertItensPedido',
            idPedidoEstoque: getQuery('idPedidoEstoque'),
            quantidadeProduto: quantidade,
            idProduto: cadastrar.idProduto,
            idFilial: $('#idFilialPedidoEstoque').val(),
        }, function(e)
        {
            console.log(e);
            var resultadoArray = [];
            resultadoArray.push(e);
            console.log(resultadoArray);
            resultadoArray.forEach(function(e)
            {
                if (e.mensagem == 'sucesso')
                {
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
                }
                else
                {
                    console.log(e);
                    alert(e.erro + ' / Qnt Disponível: ' + e.quantidadeEstoque)
                    $('#informacaoInputProduto').text('Informe o codigo de barras:')
                    $('#campoEntradaVendas').removeClass('quantidadeProdutoVendas').addClass('codigoBarrasVendas').val('')
                }
            })
        });
    },
    finalizarVenda: () =>
    {
        $.getJSON('assets/conexao/__Venda.php',
        {
            solicitacao: 'finalizarVenda',
            idPedidoEstoque: getQuery('idPedidoEstoque'),
            formaPagamento: $('#selectFormaPagamento option:selected').val(),
            total: parseInt($('#subtotal').text())
        }, function(e)
        {
            console.log(e);
            if (e.mensagem == 'sucesso')
            {
                alert('venda realizada, retorne ao início')
                window.location.assign('index.php');
            }
            else
            {
                alert('Ocorreu um erro')
                console.log(e.erro);
            }
        })
    },
    cancelarItensPedido: (item) =>
    {
        var idItem = $('#item_' + Number(item).toString()).val();
        $.getJSON('assets/conexao/__Venda.php',
        {
            solicitacao: 'cancelarItensPedido',
            idItem: idItem
        }, function(e)
        {
            if (e.mensagem == 'sucesso')
            {
                $('#subtotal').text(parseInt($('#subtotal').text()) - parseInt($('#valorItem_' + Number(item).toString()).val()))
                $('.linha_' + idItem).addClass('itemCancelado');
                $('.modal').modal('hide');
            }
            else
            {
                alert('erro')
            }
        })
    }
};
var consultar = {
    produto: (codigoBarras) =>
    {
        $.getJSON('assets/conexao/__ConsultarDados.php',
        {
            solicitacao: 'consultarProdutoVenda',
            codigoBarras: codigoBarras
        }, function(e)
        {
            if (e.length == 0)
            {
                alert('Produto não localizado');
                $('#campoEntradaVendas').focus()
            }
            $.each(e, function(k, value)
            {
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
    inclusaoPesquisaAvancada: (codigoBarras, quantidade) =>
    {
        if (parseInt(quantidade) <= 0)
        {
            alert('Informe uma quantidade superior a 0')
            return
        }
        $.getJSON('assets/conexao/__ConsultarDados.php',
        {
            solicitacao: 'consultarProdutoVenda',
            codigoBarras: codigoBarras
        }, function(e)
        {
            if (e.length == 0)
            {
                alert('Produto não localizado');
                $('#campoEntradaVendas').focus()
            }
            $.each(e, function(k, value)
            {
                $('#ddlProdutoVenda').val(value.Produto)
                $('#informacaoInputProduto').text('Informe a quantidade para retirada de estoque')
                $('#campoEntradaVendas').removeClass('codigoBarrasVendas').addClass('quantidadeProdutoVendas').val('')
                cadastrar.idProduto = value.id;
                cadastrar.valorProduto = value.valor;
                cadastrar.descricao = value.Produto;
                cadastrar.barras = codigoBarras;
            })
            cadastrar.quantidade(quantidade);
            $('.modal').modal('hide')
        })
    },
    consultaAvancada: (idFilial, string) =>
    {
        let tipoConsulta = !isNaN(parseFloat(string)) && isFinite(string) ? 'consultarBarrasRelativo' : 'consultarProdutoRelativo';
        let dataSet = new Array();
        $.getJSON('assets/conexao/__ConsultarDados.php',
        {
            solicitacao: tipoConsulta,
            idFilial: idFilial,
            string: string
        }, function(ef)
        {
            console.log(ef);
            ef.forEach(function(e)
            {
                let input = `<input style="width: 70px;" type="number" value="0" class="form-control" id="adicionarProdutoPesquisaAvancada_${e.id}">`;
                let botao = `<button class="btn btn-success" onclick="consultar.inclusaoPesquisaAvancada('${e.codigoBarras}', $('#adicionarProdutoPesquisaAvancada_${e.id}').val())">+</button>`;
                dataSet.push([e.codigoBarras, e.Produto, e.Quantidade, input, botao]);
                console.log(e);
            })
            inserirDataTable(dataSet, '#consultaAvancadaTabela');
        })
    }
};
getQuery = (parametro) =>
{
    parametro = parametro.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + parametro + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(window.location.href);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}
var inserirDataTable = (dataSet, elemento, quantidade = 5) =>
{
    $(elemento).DataTable(
    {
        "aaData": dataSet,
        "destroy": true,
        "pages": 1,
        responsive: true,
        columnDefs: [
        {
            responsivePriority: 1,
            targets: -1
        },
        {
            responsivePriority: 2,
            targets: 0
        }],
        "lengthMenu": [
            [quantidade, quantidade + 10, quantidade + 20, quantidade + 100, 10000],
            [quantidade, quantidade + 10, quantidade + 20, quantidade + 100, 'TUDO']
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
