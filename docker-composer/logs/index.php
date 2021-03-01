<?

function get_url($request_url) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $request_url);
  curl_setopt($ch, CURLOPT_USERPWD, "admin:admin");
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $response = curl_exec($ch);
  curl_close($ch);

return $response;
}

$request_url = "http://192.168.0.11:logs/api/search/universal/keyword?query=*&keyword=2%20weeks%20ago&fields=message%2C%20timestamp&decorate=true";
//$request_url = "http://192.168.0.204:9000/api/search/universal/absolute?query=*&from=2020-09-01T00%3A00%3A00.000Z&to=2020-09-11T23%3A59%3A59.000Z&fields=timestamp%2C%20message&sort=timestamp%3Aasc&decorate=true";

$response = get_url($request_url);
echo $response; die;

?>
