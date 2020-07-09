<?php
/**
*
*/
class InteracaoBD
{
  public $query;
  public $resultadoJSON;
  public $conecta;
  public $ultimoID;

  function __construct($conexao)
  {
      $this->conecta = $conexao;
  }

  public function setDadosBD($query){
    $this->$query = $query;
    $this->conecta->query($this->$query) or die (json_encode(array('mensagem'=>'erro', 'erro'=>$this->conecta->error)));
    $this->ultimoID = $this->conecta->insert_id;
    echo json_encode(array('mensagem'=>'sucesso' , 'ID' => $this->ultimoID));
  }

  public function getDadosBD($query){
    $this->$query = $query;
    $array = array();
    $retornoCON = $this->conecta->query($this->$query) or die($this->conecta->error);
    while ($r = $retornoCON->fetch_assoc()) {
      $array [] = array_map('utf8_encode', $r);
    }
    echo json_encode($array);
  }
}



?>
