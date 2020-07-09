
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
});
