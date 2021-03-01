<?php
session_start();
require 'api.php';

if ($_GET['function'] == "retornaCarrinho"){
  echo retornaCarrinho($_GET['session']);
}
else{
  $cd_sessao = $_SESSION["cd_sessao"];
  echo retornaCarrinho($cd_sessao);
}
?>
