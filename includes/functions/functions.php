<?php



/*=====================================================================
=============         Get Categories FUNCTION V1.0     ================
=======================================================================*/
function getCategories()
{
	global $conn;
	$stmt = $conn->prepare("SELECT * FROM categories ORDER BY ID DESC");
	$stmt->execute();
	$cats = $stmt->fetchAll();
	return $cats;
}

/*=====================================================================
=============         Get Items FUNCTION V1.0     =====================
=======================================================================*/
function getItems($col,$val)
{
	global $conn;
	$stmt = $conn->prepare("SELECT * FROM items WHERE $col = ? ORDER BY ID DESC");
	$stmt->execute(array($val));
	$items = $stmt->fetchAll();
	return $items;
}

/*=====================================================================
=============    Check User Regestration Status FUNCTION   ============
=======================================================================*/

function checkUserReg($user)
{
	global $conn;
	$stmt = $conn->prepare("SELECT Username , RegStatus FROM users WHERE Username = ? AND RegStatus = 0");
	$stmt->execute(array($user));
	$reg_status = $stmt->rowCount();
	return $reg_status;
}

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














?>