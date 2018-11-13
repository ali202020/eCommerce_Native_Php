<?php

	$dsn = 'mysql:host=localhost;dbname=shop';
	$user = 'root';
	$pass = '';
	$options = array(
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
	);

	try
	{
		$conn = new PDO($dsn,$user,$pass,$options);
		$conn->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
		// echo 'You Successfully Connected To The Database';

	}
	catch(PDOException $e)
	{
		echo 'Failed To Connect'. $e->getMessage();

	}




?>