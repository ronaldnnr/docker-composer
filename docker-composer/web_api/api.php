<?
require 'predis/autoload.php';
function retornaCarrinho($sessao){
    $client = new Predis\Client(array(
      'host' => '192.168.0.11',
      'port' => 6379,
      'password' => 'Redis2019!'
    ));
    $objSessao = new stdClass();
    $objSessao->sessao = $sessao;
    $objSessao->codigo = $client->hget($sessao,'codigo');
    $jsonOutput = json_encode($objSessao);
    return $jsonOutput;
  }
