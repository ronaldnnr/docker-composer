<?php
session_start();

/*
   *    CARINHO DE COMPRAS
   *
   *   Autor: Ronald Silva
   *   Data Versão: 15/10/2020
   *   Data Atualização: 15/10/2020
   */




require 'predis/autoload.php';
 /******** CONFIGURAÇÃO DO BANCO DE DADOS ***************/

   $VGhost= "db";     // Host do banco de dados
   $VGuser = "root";     // Usuário do banco de dados
   $VGpassword = "senha";    // Senha do banco de dados
   $VGBanco = "banco";      // Nome do banco de dados






// Destruir a sessão caso seja informada via GET (O parametro limpa)
if (isset($_GET['apagarTudo'])){
  $_SESSION = array();
  $_GET = array();
  die("Sessão destruída.");
}

if (!isset($_SESSION['cod_cliente'])){
  $cod_cliente = rand(1,51);
  $_SESSION['valor'] = rand (1000,15)/100; 
// rand(1000,99999)/100;

  $conn = new mysqli($VGhost, $VGuser, $VGpassword, $VGBanco);
  // Check connection
  if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
  }
	   // ************ Carregar dados do cliente da session ************

  $sql = "SELECT * FROM clientes WHERE cod_cliente='$cod_cliente'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "Código: " . $row["cod_cliente"]. " - Nome: " . $row["nome"].    "<br>";

    $_SESSION['cod_sessao'] = bin2hex(random_bytes(5));
    $_SESSION['cod_cliente'] = $row["cod_cliente"];
    $_SESSION['nome'] = $row["nome"];
    //$_SESSION['produto'] = $row["produto"];


    $client_redis = new Predis\Client(array(
      'host' => '192.168.0.11',
      'port' => 6379,
      'password' => 'Redis2019!'
    ));

 /*  Caso encontre mais de um registro na consulta irá retornar os dados
		   * neste caso é interessante só encontrar um registro e fazer a validação 
		   * uma validação também mesmo se na modelagem do banco possua validacao nos campos chaves
		   * este comentario vale para o bloco da linha 54 a
		   */


    $client_redis->hset($_SESSION['cod_sessao'], 'sessao', $_SESSION['cod_sessao']);
    $client_redis->hset($_SESSION['cod_sessao'], 'codigo', $_SESSION['cod_cliente']);
    $client_redis->hset($_SESSION['cod_sessao'], 'nome', $_SESSION['nome']);
    $client_redis->hset($_SESSION['cod_sessao'], 'valor', $_SESSION['valor']);
    //$client_redis->hset($_SESSION['cod_sessao'], 'produto', $_SESSION['produto']);

  }
  else{
    echo "Sem resultado";
  }

  $cod_cliente = $_SESSION['cod_cliente'];
  $valor = $_SESSION['valor'];
  //$produto = $_SESSION['produto'];

  $sql_carrinho = "INSERT INTO carrinho (cod_cliente, valor, produto) VALUES ('$cod_cliente', '$valor')";

  if ($conn->query($sql_carrinho) === TRUE) {
    echo "Valor total da compra: R$ $valor";
    $cod_carrinho = $conn->insert_id;
    $client_redis->hset($_SESSION['cod_sessao'], 'codigo_carrinho', $cod_carrinho);
    $client_redis->hset($_SESSION['produto'], 'codigo_carrinho', $produto);

  } else { // Caso o comando SQL seja montado de forma errada
    echo "Erro: " . $sql_carrinho . "<br>" . $conn->error;
  }
  $conn->close();
}
else{

  echo "Sessão: " . $_SESSION['cod_sessao'] . " - Código: ". $_SESSION["cod_cliente"]. " - Nome: ". $_SESSION["nome"]. "- Valor: R$ ". $_SESSION['valor'].  "<br>";

}


?>
