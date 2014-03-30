<?php

include "buy_stock.php";

$home = '/var/www/machine_learn/neural2/';

//$command1 = 'python ' . $home . 'neural.py';
//$output1 = shell_exec($command1);

$result = get_quote(array("AAPL"));
$result = json_decode($result);
$value = floatval($result->quote->ask) + mt_rand()/mt_getrandmax()*10;

$command2 = 'python ' . $home . 'test.py ' . $value;
$predict = shell_exec($command2);

$command3 = 'python ' . $home . 'decide.py ' . $value . ' ' . $predict;

$decide = shell_exec($command3);
$decide = intval($decide);

echo json_encode($decide);

if($decide == 1)
{
	buy_stock("AAPL");
}
if($decide == -1)
{
	sell_stock("AAPL");
}

?>
