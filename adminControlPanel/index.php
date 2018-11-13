<?php 
	session_start();  // START NEW SESSION OR RESUME EXISTING ONE
	$noNav= '';
	// print_r($_SESSION);
	//IF THERE IS EXISTING SESSION REDIRECT TO 'dashboard.php' -as i got-
	if(isset($_SESSION['Username'])){
		header('Location: dashboard.php');  //Redirecting to 'dashboard.php' 
	}

	include 'init.php';
	


	//Checking Whether User Is Comming From Post Request Or Not
	if ( $_SERVER['REQUEST_METHOD'] == 'POST'){

		//ASSIGNING DATA TO VARIABLES
		$username = $_POST['user'];
		$password = $_POST['pass'];
		$hashed_password = sha1($password);

		
		//CHEKING WHETHER THE ADMIN EXISTS IN THE DATABASE OR NOT
		//WE USE PREPARED STATEMENTS FOR DOING THAT
		$stmt = $conn->prepare("SELECT UserID , Username , Password FROM users WHERE Username = ? AND Password = ? AND GroupID = 1 LIMIT 1"); //limit 1 restricts that only one row to be returned as i got
		$stmt->execute(array($username , $hashed_password));
		$record = $stmt->fetch();  //'$record' is an Associative array
		$count = $stmt->rowCount();

		

		//If Count > 0 This Means That There Exists A Record Of That Name In The Data Base
		if ($count > 0){
			$_SESSION['Username'] = $username;  //Registering user name in the session as i got  
			$_SESSION['UserID'] = $record['UserID'];
			//Redirecting to 'dashboard.php' 
			header('Location: dashboard.php');
			exit(); 

		}
	}
	 ?>


	<form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method ="post">
		<h4 class="text-center">Admin Login</h4>
		
		<input class="form-control" type="text" name="user" placeholder="UserName" autocomplete="off" >
		<input class="form-control" type="password" name="pass" placeholder="Password" placeholder="Password" autocomplete="new-password">
		<input class="btn btn-block btn-primary" type="submit" value="login"> 
		
	</form>


	
<?php include $tpls."footer.inc"  ?>