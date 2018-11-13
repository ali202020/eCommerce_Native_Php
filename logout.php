<?php

session_start(); //START THE SESSION
session_unset(); //UNSET THE SESSION
session_destroy(); //DESTROY THE SESSION
header('Location: index.php'); //REDIRECTING USER
exit();



?>