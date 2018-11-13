<?php
	include 'adminControlPanel/connect.php';
	//Routes (pathes)
	$js = 'layout/js/';  		                        //fornt javascript path
	$css = 'layout/css/'; 	                            //front css path
	$tpls = 'includes/templates/';	                    //front templates path
	$func = 'includes/functions/';                      //front functions path
	$footer = 'includes/templates/';                    //footer path from admin
	$langs = 'adminControlPanel/includes/languages/';   //languages path from admin


	// Important includes
	include $func."functions.php";
	include $langs."english.php";	
	// include $tpls."header.inc" ;
	include $tpls."Navbar.inc";      //this is the front navbar and its header also
	
	



?>
