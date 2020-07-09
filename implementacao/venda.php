<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/css/init.css">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;400;600;700;900&display=swap" rel="stylesheet">
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

  <section>
    <div class="comandos">
      <div class="row">
        <div class="col-md-8"></div>
        <div class="col-md-1">
          <div class="button-seletor elevacao">
            <img src="assets/imagens/pesquisar.png" alt="">
            <span>Localizar(F2)</span>
          </div>
        </div>

        <div class="col-md-1">
          <div class="button-seletor elevacao">
            <img src="assets/imagens/cancelar.png" alt="">
            <span>Cancelar(F3)</span>
          </div>
        </div>

        <div class="col-md-1">
          <div class="button-seletor elevacao">
            <img src="assets/imagens/finalizar.png" alt="">
            <span>Finalizar(F4)</span>
          </div>
        </div>
      </div>
    </div>

    <div class="cumpoFiscal">
      <div class="cupom elevacao">

      </div>
    </div>

    <div class="descritivo">
      <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-5">
          <label for="">Produto/Codigo:</label>
          <input type="text" class="form-control" name="" value="">
        </div>
      </div>

      <div class="row mt-30">
        <div class="col-md-6"></div>
        <div class="col-md-5">
          <label for="">Quantidade:</label>
          <input type="text" class="form-control" name="" value="">
        </div>
      </div>
      <div class="row ">
        <div class="col-md-7"></div>
        <div class="col-md-3">
          <div class="position-subtotal">
            <span>Total</span>
            <div class="button-total ">
            </div>


          </div>
        </div>
      </div>


    </div>

    <div class="codigoBarras">
      <div class="barras">
        <input type="text" class="form-control input-barras" name="" value="">
      </div>
    </div>



  </section>


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

  <script type="text/javascript">
  $(document).ready(function(){

    horario=()=>{
      setInterval(function(){
        let data = new Date();
        $('#horarioAtual').text(data.getHours() +':'+data.getMinutes() +':'+data.getSeconds())
        console.log(data.getHours() +':'+data.getMinutes() +':'+data.getSeconds());
      },1000);
    }
    horario();

  })
</script>
</body>
</html>
