<?php

function insert($input)
{
	// connect
	$m = new MongoClient();

	// select a database
	$db = $m->stockDB;

	// select a collection (analogous to a relational database's table)
	$collection = $db->APPL_hist;

	$input = json_decode($input);

	foreach($input->day as $val)
	{
		try{
			$collection->insert($val);	
		}
		catch(Exception $e){}
		
	}
}
?>