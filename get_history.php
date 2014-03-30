<?php

include_once "insert_ticker.php";

if (!function_exists('get_history'))
{
	function get_history($symbol)
	{
	        $url = 'https://api.tradier.com/v1/markets/history';
	        $params = array('symbol' => $symbol);
	        $url .= '?' . http_build_query($params);
	        
		$ch = curl_init($url);
	        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer YZtE5zbjX7GGBgDMJvVzo0vhTfnt'));
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	        $response = curl_exec($ch);
	        curl_close($ch);
	        return $response;
	}
}

$response = get_history('AAPL');
$xml = simplexml_load_string($response);
$json = json_encode($xml);
insert($json);

echo $json;

?>