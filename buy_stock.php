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
	$json = json_encode($xml);
	return $json;
}

function insert_stock_buy($input)
{
	$con=mysqli_connect("localhost","root","1234","stocks");
	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	try{
		$query = "UPDATE stocks SET count=count+" . $input[1] . " WHERE name = '" . $input[0] . "'";
		mysqli_query($con, $query);
		$stock = get_quote(array($input[0]));
		echo $stock;
		$stock = json_decode($stock);
		$value = $stock->quote;
		$value = $value->ask;
		$query = "UPDATE account SET balance = balance + " . -25*floatval($value) . " WHERE name = 'acc1'";
		echo $query;
		mysqli_query($con, $query);
	}
	catch(Exception $e)
	{
		echo $e;
	}
	mysqli_close($con);
}


function buy_stock($symbol)
{
	/*
	$url = 'https://api.tradier.com/v1/markets/accounts/?????/orders';
	
	$data = array(
		"class" => "equity",
		"symbol" => $symbol,
		"duration" => "day",
		"side" => "buy",
		"quantity" => "25",
		"type" => "market")
	$params = '';

	array('symbol' => $symbol);
	$url .= '?' . http_build_query($params);

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer YZtE5zbjX7GGBgDMJvVzo0vhTfnt'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, count($data));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

	$response = curl_exec($ch);
	curl_close($ch);
	*/

	insert_stock_buy(array($symbol, 25));
}

function insert_stock_sell($input)
{
	$con=mysqli_connect("localhost","root","1234","stocks");
	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	try{
		$query = "UPDATE stocks SET count=count+" . $input[1] . " WHERE name = '" . $input[0] . "'";
		mysqli_query($con, $query);
		$stock = get_quote(array($input[0]));
		echo $stock;
		$stock = json_decode($stock);
		$value = $stock->quote;
		$value = $value->ask;
		$query = "UPDATE account SET balance = balance + " . 25*floatval($value) . " WHERE name = 'acc1'";
		echo $query;
		mysqli_query($con, $query);
	}
	catch(Exception $e)
	{
		echo $e;
	}
	mysqli_close($con);
}

function sell_stock($symbol)
{
	/*
	$url = 'https://api.tradier.com/v1/markets/accounts/?????/orders';
	
	$data = array(
		"class" => "equity",
		"symbol" => $symbol,
		"duration" => "day",
		"side" => "sell",
		"quantity" => "25",
		"type" => "market")
	$params = '';

	array('symbol' => $symbol);
	$url .= '?' . http_build_query($params);

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer YZtE5zbjX7GGBgDMJvVzo0vhTfnt'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, count($data));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

	$response = curl_exec($ch);
	curl_close($ch);
	*/
	insert_stock_sell(array($symbol, -25));
}

?>