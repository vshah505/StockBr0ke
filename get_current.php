<?php

function get_quote(array $quotes = array())
{
	$url = 'https://api.tradier.com/v1/markets/quotes';
	
	$symbols = "";
	foreach ($quotes as $value)
	{
		$symbols = $symbols . "," . $value; 
	}
	$symbols = substr($symbols, 1);

	$params = array('symbols' => $symbols);
	$url .= '?' . http_build_query($params);

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer YZtE5zbjX7GGBgDMJvVzo0vhTfnt'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$response = curl_exec($ch);
	curl_close($ch);
	$xml = simplexml_load_string($response);
	//$json = json_encode($xml);
	return $xml;
}

function get_assets()
{
	$con=mysqli_connect("localhost","root","1234","stocks");
	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	try{
		$query = "SELECT name,count FROM stocks";
		$result = mysqli_query($con, $query, MYSQLI_USE_RESULT);
		$rows = array();
		while($r = $result->fetch_assoc()) {
		    $rows[] = $r;
		}
		$stocks = $rows;
		
		$query = "SELECT SUM(balance) as balance FROM account";
		$result = mysqli_query($con, $query, MYSQLI_USE_RESULT);
		$rows = array();
		while($r = $result->fetch_assoc()) {
		    $rows[] = $r;
		}
		$balance = $rows;

		return array('stocks' => $stocks, 'balance' => $balance);
	}
	catch(Exception $e)
	{
		echo $e;
	}
	mysqli_close($con);
}

$response = get_quote(array('AAPL', 'GOOG', 'INTC'));
$assets = get_assets();


echo json_encode(array($response, $assets));

?>