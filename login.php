<?php 
	ob_start();
	session_start();  // START NEW SESSION OR RESUME EXISTING ONE
	//IF THERE IS EXISTING SESSION REDIRECT TO 'index.php' -as i got-
	if(isset($_SESSION['User'])){
		header('Location: index.php');  //Redirecting to 'index.php' 
	}

	include 'init.php';

	//Checking Whether User Is Comming From Post Request Or Not
	if ( $_SERVER['REQUEST_METHOD'] == 'POST'){

		if (isset($_POST['login'])) {
			//You are in the login form		

			//ASSIGNING DATA TO VARIABLES
			$user = $_POST['username'];
			$pass = $_POST['password'];
			$hashed_password = sha1($pass);
			
			//CHEKING WHETHER THE User EXISTS IN THE DATABASE OR NOT
			//WE USE PREPARED STATEMENTS FOR DOING THAT
			$stmt = $conn->prepare("SELECT UserID, Username , Password FROM users WHERE Username = ? AND Password = ?"); //limit 1 restricts that only one row to be returned as i got
			$stmt->execute(array($user , $hashed_password));
			$get_user = $stmt->fetch();		
			$count = $stmt->rowCount();		

			//If Count > 0 This Means That There Exists A Record Of That Name In The Data Base
			if ($count > 0){
				$_SESSION['User'] = $user;  //Registering user name in the session as i got
				$_SESSION['user_id'] = $get_user['UserID'];  //registering user id in the current session 			
				//Redirecting to 'index.php' 
				header('Location: index.php');
				exit();
			}
		}else{
			//You are in the registeration form
			//filtering and validating username Form field
			if(isset($_POST['username'])){				
				//filtering the input data
				$filtered_name = filter_var($_POST['username'],FILTER_SANITIZE_STRING);				
				//VALIDAING USERNAME TO BE MORE THAN 4 CHARS
				if(strlen($filtered_name) < 4){
					$formErrors[] = 'Name must be more than 4 characters';
				}
			}

			//filtering and validating email Form field
			if(isset($_POST['email'])){				
				//filtering the input data
				$filtered_email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);				
				//VALIDAING Email 
				if(filter_var($filtered_email,FILTER_VALIDATE_EMAIL) != true){
					$formErrors[] = 'Please ,Enter a valid email';
				}
				//Registering New User
				if(empty($form_errors))
				{
					//Check Element existence
					if(checkItems('Username','users',$_POST['username']) > 0)
					{
						// echo '<div class="container"><div class="alert alert-danger"> User Already Exists </div></div>';
						$formErrors[] = 'User Already Exists';
					}
					else
					{
						//Insert into database record
						$stmt = $conn->prepare("INSERT INTO users(Username , Password , Email , RegStatus ,Date)
												 VALUES (:username , :password ,:email ,:val, now())");
						$stmt->execute(array('username' => $_POST['username'] ,
											 'password' => sha1($_POST['password']), 
											 'email' => $_POST['email'],											 
											 'val'=> 0));
						echo '<div class="container"><div class="alert alert-success">'. $stmt->rowCount().' '.'Record Inserted Successfully'. '</div></div>';
					}					
					
				}
			}
		}
	}

 ?>


<div class="container login-page">
	<h1 class="text-center">
		<span data-log-sign="login" class="active">Login</span> | <span data-log-sign="signup">SignUp</span> 
	</h1>
	<!-- Login Form -->
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method ="post" class="login">
		<input type="text" class="form-control" name="username" autocomplete="off" placeholder="username" required="required">
		<input type="password" class="form-control" name="password" autocomplete="new-password" placeholder="password" required="required">
		<input type="submit" class="btn btn-primary btn-block" name="login" value="Login">
	</form>
	<!-- ***** -->

	<!-- SignUp Form -->
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method ="post" class="signup">
		<input type="text" class="form-control" name="username" autocomplete="off" placeholder="username" required="required">
		<input type="password" class="form-control" name="password" autocomplete="new-password" placeholder="password" required="required">
		<input type="email" class="form-control" name="email" placeholder="Enter Your Email" required="required">
		<input type="submit" class="btn btn-success btn-block" name="signup" value="SignUp">
	</form>
	<!-- *********** -->

	<!-- start from errors -->
	<div class="container">
		<p class="text-center">
			<?php
			if(!empty($formErrors)){
				foreach ($formErrors as $error) {
					echo '<div class="container"><div class="alert alert-danger">'.$error.'</div></div>';
				}
			}
				
			?>
		</p>
	</div>

	<!-- ***************** -->
	
</div>


<?php include $footer."footer.inc"; 
	  ob_end_flush();
	  ?>