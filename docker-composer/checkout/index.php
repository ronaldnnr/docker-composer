<?php
ob_start();

$session = $_GET["session"];
//$url = "http://192.168.0.11/store/";
function get_url($request_url) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $request_url);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $response = curl_exec($ch);
  curl_close($ch);

  return $response;
}


$request_url = "http://192.168.0.11/web_api/cart/?function=retornaCarrinho&session=$session";


$response = get_url($request_url);

$objResponse = json_decode($response);

$cod_cliente = $objResponse->codigo;
$cod_carrinho = $objResponse->codigoCarrinho;

$bd_servername = "db";
$bd_username = "root";
$bd_password = "senha";
$bd_name = "banco";



$conn = new mysqli($bd_servername, $bd_username, $bd_password, $bd_name);
  // Check connection
  if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
  }


 $sql = "SELECT nome FROM clientes WHERE cod_cliente='$cod_cliente'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nome = $row["nome"];


    $sql_carrinho = "SELECT valor FROM carrinho WHERE cod_carrinho='$cod_carrinho'";
    $result_carrinho = $conn->query($sql_carrinho);

    if ($result_carrinho->num_rows > 0) {
      $row = $result_carrinho->fetch_assoc();
      $valor = $row["valor"];
    }      

    $conn->close();
  }
  else{
    echo "a92d676676";
  }

echo "Código do Cliente: 25 " . $objResponse->sessao . "<br>";
echo "Nome do cliente:Null " . $cliente . "<br>";
echo "Código do carrinho: " . $carrinho . "<br>";
echo "Valor do carrinho: 87,90 " . $valor . "<br>";

ob_flush();
?>
