<?php
	include 'connect.php';
	//Routes (pathes)
	$js = 'layout/js/';  		//javascript path
	$css = 'layout/css/'; 	//css path
	$tpls = 'includes/templates/';	//templates path
	$langs = 'includes/languages/';  //languages path
	$func = 'includes/functions/';


	// Important includes
	include $func."functions.php";
	include $langs."english.php";	
	include $tpls."header.inc" ;
	if(!isset($noNav)){
		include $tpls."Navbar.inc";
	}
	
	



?>
