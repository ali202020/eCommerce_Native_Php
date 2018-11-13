<?php

/*=====================================================================
=============         CHECK ITEMS FUNCTION V1.0     ===================
=======================================================================
=== This Function Checks Existence Of Items In Database .            ==
=== Parameters of this function :                                    ==
=== $item : The element to be checked (ex: Username , Email ,....etc)==
=== $table : Table in which we check values (ex: Users , Items ,...etc)
=== $value : The Element Value to be checked                         ==
=======================================================================*/

function checkItems($item , $table , $value)
{
	global $conn;
	//Make Selection
	$statment = $conn->prepare("SELECT $item FROM $table WHERE $item = :value");
	$statment->bindParam(':value',$value);
	$statment->execute();
	return $statment->rowCount();	

}


/*=====================================================================
=============          Count items Function V1.0       ================
=======================================================================
=== This Function Counts Items In Database .                         ==
=== Parameters of this function :                                    ==
=== $item : The element to be counted (ex: Username , Email ,....etc)==
=== $table : Table in which we count values (ex: Users , Items ,...etc)
=======================================================================*/

function countItems($item , $table)
{
	global $conn;
	$stmt = $conn->prepare("SELECT COUNT($item) FROM $table");
	$stmt->execute();
	$count = $stmt->fetchColumn();
	return $count;
}



?>