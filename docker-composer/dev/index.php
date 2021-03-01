<?php
session_start();

require 'predis/autoload.php';

$bd_servername = "db";
$bd_username = "root";
$bd_password = "senha";
$bd_name = "banco";

if (isset($_GET['limpa'])){
  $_SESSION = array();
  $_GET = array();
  die("Sessão destruída.");
}

if (!isset($_SESSION['cd_cliente'])){
  $cd_cliente = rand(1,2001);
  $_SESSION['fl_valor'] = rand(1000,99999)/100;

  $conn = new mysqli($bd_servername, $bd_username, $bd_password, $bd_name);
  // Check connection
  if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM clientes WHERE cd_cliente='$cd_cliente'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "Código: " . $row["cd_cliente"]. " - Nome: " . $row["st_nome"]."<br>";
    
    $_SESSION['cd_sessao'] = bin2hex(random_bytes(22));
    $_SESSION['cd_cliente'] = $row["cd_cliente"];
    $_SESSION['st_nome'] = $row["st_nome"];

    $client_redis = new Predis\Client(array(
      'host' => '192.168.0.204',
      'port' => 6379,
      'password' => 'Redis2019!'
    ));

    $client_redis->hset($_SESSION['cd_sessao'], 'sessao', $_SESSION['cd_sessao']);
    $client_redis->hset($_SESSION['cd_sessao'], 'codigo', $_SESSION['cd_cliente']);
    $client_redis->hset($_SESSION['cd_sessao'], 'nome', $_SESSION['st_nome']);
    $client_redis->hset($_SESSION['cd_sessao'], 'valor', $_SESSION['fl_valor']);
  }
  else{
    echo "Sem resultado";
  }

  $cd_cliente = $_SESSION['cd_cliente'];
  $fl_valor = $_SESSION['fl_valor'];

  $sql_carrinho = "INSERT INTO carrinho (cd_cliente, fl_valor) VALUES ('$cd_cliente', '$fl_valor')";

  if ($conn->query($sql_carrinho) === TRUE) {
    echo "Valor total do carrinho: R$ $fl_valor";
    $cd_carrinho = $conn->insert_id;
    $client_redis->hset($_SESSION['cd_sessao'], 'codigo_carrinho', $cd_carrinho);
  } else {
    echo "Erro: " . $sql_carrinho . "<br>" . $conn->error;
  }
  $conn->close();
}
else{
  echo "Sessão: " . $_SESSION['cd_sessao'] . " - Código: ". $_SESSION["cd_cliente"]. " - Nome: ". $_SESSION["st_nome"]. "- Valor: R$ ". $_SESSION['fl_valor'].  "<br>";
}

?>
