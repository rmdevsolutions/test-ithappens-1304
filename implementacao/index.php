<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/css/init.css">
  <link rel="stylesheet" href="assets/css/index.css">
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
          <span class="letreiro-header">CAIXA LIVRE</span>
        </div>
      </div>
    </div>
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-12 logo_center">
        <img class="logo_mateus" src="https://seeklogo.com/images/G/grupo-mateus-logo-77402B7BC9-seeklogo.com.png" alt="">
        <br><span>Pressione F2 para iniciar uma nova venda</span>
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-1">
            <div class="button-seletor elevacao">
              <img src="assets/imagens/estoque.png" alt="">
              <span>Estoque Filial(F3)</span>
            </div>
          </div>

          <div class="col-md-1">
            <div class="button-seletor elevacao">
              <img src="assets/imagens/finalizar.png" alt="">
              <span>Vendas(F4)</span>
            </div>
          </div>

          <div class="col-md-1">
            <div class="button-seletor elevacao">
              <img src="assets/imagens/mais.png" alt="">
              <span>Cliente(F6)</span>
            </div>
          </div>

          <div class="col-md-1">
            <div class="button-seletor elevacao">
              <img src="assets/imagens/mais.png" alt="">
              <span>Produtos(F7)</span>
            </div>
          </div>

          <div class="col-md-1">
            <div class="button-seletor elevacao">
              <img src="assets/imagens/mais.png" alt="">
              <span>Filiais(F7)</span>
            </div>
          </div>

          <div class="col-md-1">
            <div class="button-seletor elevacao">
              <img src="assets/imagens/mais.png" alt="">
              <span>Usuarios(F8)</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" tabindex="-1" role="dialog"  id="modalIniciarVenda" aria-labelledby="modalIniciarVenda" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Abertura de PDV</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="col-md-12">
              <div class="alert alert-danger" id="alertaErro" role="alert"></div>
            </div>
            <div class="col-md-12">
              <div class="alert alert-success" id="alertaSucesso" role="alert"></div>
            </div>
            <div class="col-md-12">
              <label for="recipient-name" class="col-form-label">Filial:</label>
              <select class="form-control filial obrigatorio" name="idFilial" id="idFilial" >

              </select>
            </div>
            <div class="col-md-12">
              <label for="message-text" class="col-form-label">Usuario:</label>
              <select class="form-control usuarios obrigatorio" name="idUsuario" id="idUsuario">

              </select>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="message-text" class="col-form-label">CPF Cliente:</label>
                <input type="text" class="form-control obrigatorio" name="cpfCliente" id="cpfCliente">
              </div>
              <div class="col-md-6">
                <label for="message-text" class="col-form-label">Nome</label>
                <input type="text" readonly class="form-control obrigatorio" name="nomeCliente" id="nomeCliente" value="">
              </div>
            </div>
            <div class="col-md-12">
              <label for="message-text" class="col-form-label">Observação Entrega:</label>
              <textarea name="observacaoEntrega" id="observacaoEntrega" class="form-control" rows="8" cols="80"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <div class="col-md-12 t-right" >
            <button onclick="cadastrar.pedidoEstoque()" type="button" class="btn btn-primary">Iniciar Venda</button>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" tabindex="-1" role="dialog"  id="modalControleEstoque" aria-labelledby="modalControleEstoque" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Controle de Estoque</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Filial:</label>
              <select class="form-control filial" id="filialEstoqueID" onchange="consultar.estoqueFilial(this.value)">
                <option value=""></option>
              </select>
            </div>

            <table id="estoqueFilial" class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">COD</th>
                  <th scope="col">Produto</th>
                  <th scope="col">Quantidade</th>
                  <th scope="col">Ações</th>
                </tr>
              </thead>

            </table>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Adicionar Produto</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" tabindex="-1" role="dialog"  id="modalVendasRealizadas" aria-labelledby="modalVendasRealizadas" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Controle de Vendas</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Filial:</label>
              <select class="form-control filial" id="filialVendasID" onchange="consultar.vendasFilial(this.value)">
                <option value=""></option>
              </select>
            </div>

            <table id="vendasFilial" class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Ordem de Saída</th>
                  <th scope="col">Total</th>
                  <th scope="col">Ações</th>
                </tr>
              </thead>

            </table>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Inserir Clientes -->
  <div class="modal fade" tabindex="-1" role="dialog"  id="modalInserirClientes" aria-labelledby="modalInserirClientes" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Cadastro de Cliente</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row" style="margin-bottom: 70px">
            <div class="col-md-4">
              <label for="recipient-name" class="col-form-label">CPF</label>
              <input type="text" class="form-control" name="cpfClienteCadastro" id="cpfClienteCadastro" value="">
            </div>
            <div class="col-md-5">
              <label for="nomeClienteCadastro" class="col-form-label">Nome</label>
              <input type="text" class="form-control" name="nomeClienteCadastro" id="nomeClienteCadastro" value="">
            </div>
            <div class="col-md-3" style="margin-top:37px">
              <button onclick="cadastrar.cliente($('#cpfClienteCadastro').val(), $('#nomeClienteCadastro').val() , true )" type="button" class="btn btn-primary">Adicionar Cliente</button>
            </div>
          </div>
          <table id="clientesCadastrados" class="table table-hover">
            <thead>
              <tr>
                <th scope="col">COD</th>
                <th scope="col">Nome</th>
                <th scope="col">CPF</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Inserir Clientes -->
  <div class="modal fade" tabindex="-1" role="dialog"  id="modalInserirProdutos" aria-labelledby="modalInserirProdutos" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Cadastro de Produtos</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row" >
            <div class="col-md-6">
              <label for="recipient-name" class="col-form-label">Codigo de Barras</label>
              <input type="text" class="form-control" name="cpfClienteCadastro" id="cpfClienteCadastro" value="">
            </div>
            <div class="col-md-6">
              <label for="nomeClienteCadastro" class="col-form-label">Produto</label>
              <input type="text" class="form-control" name="nomeClienteCadastro" id="nomeClienteCadastro" value="">
            </div>
          </div>
          <div class="row" >
            <div class="col-md-6">
              <label for="recipient-name" class="col-form-label">Descrição</label>
              <input type="text" class="form-control" name="cpfClienteCadastro" id="cpfClienteCadastro" value="">
            </div>
            <div class="col-md-6">
              <label for="nomeClienteCadastro" class="col-form-label">Valor</label>
              <input type="text" class="form-control" name="nomeClienteCadastro" id="nomeClienteCadastro" value="">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Adicionar Produto</button>
        </div>
      </div>
    </div>
  </div>

  <footer>
    <div class="barra-info">
      <div class="container lh-30">
        <span class="span-info">Operador:</span><span class="mr-30">Raimundo Martins</span>

        <span class="span-info">Filial:</span><span class="mr-30">Filial 01 - Cohama / Slz-MA</span>

        <span class="span-info">Horário:</span><span id="horarioAtual" class="mr-30"></span>
      </div>
    </div>
  </footer>

  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
  <script src="assets/js/index.js"></script>

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

    consultar.geral('consultarFiliais','Nome','.filial')
    consultar.geral('consultarUsuarios','Nome','.usuarios')
    consultar.todosClientes();



  })
</script>
</body>
</html>
