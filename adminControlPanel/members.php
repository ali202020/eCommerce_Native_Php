<?php
	/*===============================================
	======= 			MANAGING MEMBERS
	======= HERE YOU CAN ADD | EDIT | DELETE MEMBERS
	=================================================
	*/
	session_start();  // START NEW SESSION OR RESUME EXISTING ONE

	//IF THERE IS EXISTING SESSION REDIRECT TO 'dashboard.php' -as i got-
	if(isset($_SESSION['Username'])){
		echo 'Welcome' .' '. $_SESSION['Username'];
		include 'init.php';

		//START THE CONTENT OF THE PAGE
		if(isset($_GET['get']))
		{
			$get = $_GET['get']; 

		}else{
			$get = 'Manage';
		}

		switch ($get) {
			case 'Manage':
				//Pending Members
				$pending_sub_query  = '';
				if(isset($_GET['members']) && $_GET['members'] == 'Pending'){

					$pending_sub_query = 'AND RegStatus = 0';

				}
				//Manage page
				$stmt = $conn->prepare("SELECT * FROM users WHERE GroupID != 1 $pending_sub_query"); //WE MAKE EXCEPTION FOR USERS OF GROUPID = 1 BECAUSE THEY ARE THE ADMINS OF THE SYSTEM
				$stmt->execute();
				$rows = $stmt->fetchAll();
				?>

				<h1 class="text-center"> Manage Users</h1>

				<!-- Add link -->
				<div class="container">
					<div class="table-responsive">
						<table class="main-table text-center table table-borderd">
							<tr>
								<td>#ID</td>
								<td>User name</td>
								<td>Email</td>
								<td>Full Name</td>								
								<td>Registerd Date</td>
								<td>Control</td>

							</tr>
							<?php 
							foreach($rows as $row)
							{
								echo '<tr>';
								echo '<td>'.$row['UserID'].'</td>';
								echo '<td>'.$row['Username'].'</td>';
								echo '<td>'.$row['Email'].'</td>';
								echo '<td>'.$row['FullName'].'</td>';
								echo '<td>'.$row['Date'].'</td>';
								echo '<td>'.
										'<a href="members.php?get=Edit&id='.$row['UserID'].'"'.'class="btn btn-success btn-sm"><i class="fa fa-edit"></i>Edit</a>
							      		<a href="members.php?get=Delete&id='.$row['UserID'].'"'.'class="btn btn-danger btn-sm confirm"><i class="fa fa-close"></i>Delete</a>';
				      					if($row['RegStatus'] == 0)
				      					{
		      								echo '<a href="members.php?get=Activate&id='.$row['UserID'].'"'.'class="btn btn-primary btn-sm activate"><i class="fa fa-info"></i>Activate</a>';

				      					}

								echo '</td>';								
								echo '</tr>';

							}
							?>
							
							
						</table>
						
					</div>
					<a href="members.php?get=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Member </a>


				</div>




				<?php				
				break;
			case 'Edit':

				//Checking Whether Userid isset and numeric
				if(isset($_GET['id']) && is_numeric($_GET['id'])){
					$userid = $_GET['id'];
					$stmt = $conn->prepare('SELECT * FROM users WHERE UserID = ? LIMIT 1');
					$stmt->execute(array($userid));
					$record = $stmt->fetch();
					$count = $stmt->rowCount();
					if($count > 0)
					{
						//Record exists in the database , So show Edit Form ?>
						<!-- Update page --> 
						<h1 class="text-center">Edit User</h1>
						<div class="container">
							<form action="members.php?get=Update" method="POST" class="form-horizontal">
								<input type="hidden" name="userid" value="<?php echo $record['UserID'];?>">
								<div class="form-group form-group-lg">
									<label for="username" class="col-sm-2 control-label"> 
									Username</label>
									<div class="col-sm-10 col-md-4">
										<input type="text" name="username" class="form-control"  value="<?php echo $record['Username']?>" autocomplete="off" required="required">				
									</div>
								</div>

								<div class="form-group form-group-lg">
									<label for="username" class="col-sm-2 control-label"> 
									Email</label>
									<div class="col-sm-10 col-md-4">
										<input type="email" name="email" value="<?php echo $record['Email'];?>" class="form-control" required="required" >				
									</div>
								</div>

								<div class="form-group form-group-lg">
									<label for="username" class="col-sm-2 control-label"> 
									Password</label>
									<div class="col-sm-10 col-md-4">
										<input type="hidden" name="old_password" value="<?php echo $record['Password'];?>" >
										<input type="password" name="new_password" class="form-control" autocomplete="new-password" placeholder="Leave Blank If You won't Change" >				
									</div>
								</div>

								<div class="form-group form-group-lg">
									<label for="username" class="col-sm-2 control-label"> 
									Full Name</label>
									<div class="col-sm-10 col-md-4">
										<input type="text" name="full" value="<?php echo $record['FullName'];?>" class="form-control" required="required">				
									</div>
								</div>

								<div class="form-group form-group-lg">
									
									<div class="col-sm-offset-2 col-sm-10">
										<input type="submit" value="Save" class="btn btn-primary btn-lg" >				
									</div>
								</div>

							</form>
							
						</div>
					<?php
					}else
					{
						echo 'No Record Found With ID :'.' '.$_GET['id'];
					}
				}else
				{
					echo 'Invalid Query';

				}				
				break;



				

			case 'Add':
				//Add users
			?>
				<!-- Add page --> 
				<h1 class="text-center">Add User</h1>
				<div class="container">
					<form action="members.php?get=Insert" method="POST" class="form-horizontal">
						
						<div class="form-group form-group-lg">
							<label for="username" class="col-sm-2 control-label"> 
							Username</label>
							<div class="col-sm-10 col-md-4">
								<input type="text" name="username" class="form-control" autocomplete="off" required="required">				
							</div>
						</div>

						<div class="form-group form-group-lg">
							<label for="username" class="col-sm-2 control-label"> 
							Email</label>
							<div class="col-sm-10 col-md-4">
								<input type="email" name="email" class="form-control" required="required" >				
							</div>
						</div>

						<div class="form-group form-group-lg">
							<label for="username" class="col-sm-2 control-label"> 
							Password</label>
							<div class="col-sm-10 col-md-4">										
								<input type="password" name="new_password" class="form-control" autocomplete="new-password">				
							</div>
						</div>

						<div class="form-group form-group-lg">
							<label for="username" class="col-sm-2 control-label"> 
							Full Name</label>
							<div class="col-sm-10 col-md-4">
								<input type="text" name="full" class="form-control" required="required">				
							</div>
						</div>

						<div class="form-group form-group-lg">
							
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Save" class="btn btn-primary btn-lg" >				
							</div>
						</div>

					</form>
					
				</div>
				<?php

				break;

			case 'Update':
				//Update page				
				echo '<h1 class="text-center">Edit User</h1>';
				//checking Request
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					//fetching Form data
					$userid = $_POST['userid'];
					$username = $_POST['username'];
					$email = $_POST['email'];					
					$password = '';
					if (empty($_POST['new_password'])) {
						$password = $_POST['old_password'];
					}else
					{
						$password = sha1($_POST['new_password']);
					}
					
					$full = $_POST['full'];
					

					/*-----------------
					//Validating Data
					------------------*/
					//firstly:create errors array
					$form_errors = array();
					if(empty($username)){$form_errors[] = '<div class="alert alert-danger" role="alert"> Username Cannot Be empty</div>';} 
					if(empty($email)){$form_errors[] = '<div class="alert alert-danger" role="alert"> Email Cannot Be empty</div>';} 
					if(empty($full)){$form_errors[] = '<div class="alert alert-danger" role="alert"> FullName Cannot Be empty</div>';} 
					// print_r($form_errors);
					foreach ($form_errors as $error) {
						echo $error;						
					}
					

					//Updating Database Only If No error Was Found
					if(empty($form_errors))
					{
						//Updating database record
						$stmt = $conn->prepare("UPDATE users SET Username = ?,Password = ?,Email = ?,FullName = ? WHERE UserID = ?");
						$stmt->execute(array($username , $password , $email, $full , $userid));
						echo '<div class="alert alert-success">'. $stmt->rowCount().' '.'Record Updated Successfully'. '</div>';	
						
					}				

				}else
				{
					echo "This Page Cannot Be Browsed Directly";
				}



				break;

			case 'Activate':
				if(isset($_GET['id']) && is_numeric($_GET['id']))
				{
					//Registering Id
					$userid = $_GET['id'];
					//Update 'RegStatus' in the database
					$stmt = $conn->prepare("UPDATE users SET RegStatus = :reg_stat WHERE UserID = :userid");
					$stmt->execute(array(
									'reg_stat' => 1 , 
									'userid'=> $userid
										));
					echo '<div class="alert alert-success">'. $stmt->rowCount().' '.'Record Updated Successfully'. '</div>';


				}


				break;			

			case 'Insert':
				

				//Insert page				
				echo '<h1 class="text-center">Insert User</h1>';
				//checking Request
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					//fetching Form data					
					$username = $_POST['username'];
					$email = $_POST['email'];
					$visible_pass = $_POST['new_password'];					
					$password = sha1($_POST['new_password']);					
					$full = $_POST['full'];
					

					/*-----------------
					//Validating Data
					------------------*/
					//firstly:create errors array
					$form_errors = array();
					if(empty($username)){$form_errors[] = '<div class="alert alert-danger" role="alert"> Username Cannot Be empty</div>';} 
					if(empty($email)){$form_errors[] = '<div class="alert alert-danger" role="alert"> Email Cannot Be empty</div>';} 
					if(empty($visible_pass)){$form_errors[] = '<div class="alert alert-danger" role="alert"> Password Cannot Be empty</div>';}
					if(empty($full)){$form_errors[] = '<div class="alert alert-danger" role="alert"> FullName Cannot Be empty</div>';} 
					// print_r($form_errors);
					foreach ($form_errors as $error) {
						echo $error;						
					}
					

					//Updating Database Only If No error Was Found
					if(empty($form_errors))
					{
						//Check Element existence
						if(checkItems('Username','users',$username) > 0)
						{
							echo '<div class="alert alert-danger"> User Already Exists </div>';

						}
						else
						{
							//Insert into database record
							$stmt = $conn->prepare("INSERT INTO users(Username , Password , Email , FullName , RegStatus ,Date)
													 VALUES (:username , :password ,:email , :fullname , :val, now())");
							$stmt->execute(array('username' => $username ,
												 'password' => $password , 
												 'email' => $email,
												 'fullname' => $full,
												 'val'=> 1));
							echo '<div class="alert alert-success">'. $stmt->rowCount().' '.'Record Inserted Successfully'. '</div>';
						}					
						
					}				

				}else
				{
					echo "This Page Cannot Be Browsed Directly";
				}

				break;

			case 'Delete':
				//Delete page 				
				//Check The Validation Of the Id routing parameter
			echo '<h1 class="text-center">Delete User</h1>';
			echo '<div class="container">';
					if(isset($_GET['id']) && is_numeric($_GET['id']))
					{
						//Obtaining The Record From The Database
						$id = $_GET['id'];  //store the id
						$stmt = $conn->prepare('SELECT * FROM users WHERE UserID = :userid LIMIT 1');
						$stmt->bindParam(':userid',$id);
						$stmt->execute();
						$record = $stmt->fetch();
						if ($stmt->rowCount() > 0) {
							$stmt = $conn->prepare('DELETE FROM users WHERE UserID = :userid LIMIT 1');
							$stmt->bindParam(':userid',$id);
							$stmt->execute();
							echo '<div class="alert alert-danger">Record Deleted Successfully </div>';
							
						}else{
							echo '<div class="alert alert-danger">Failed To Delete Record </div>';
						}

					}else{
						echo '<div class="alert alert-danger">Invalid User ID</div>';
					}
			echo "</div>";

				break;
			
			default:
				echo 'Invalid';
				break;
		}
		



		include $tpls."footer.inc";	
		
	}else{
		// echo 'you are not authorized to navigate to this page';
		//redirect to login page
		header('Location:index.php');
		exit();
	}








?>