
<?php
	/*=========================================================
	======= 			 MANAGING Categories          =========
	======= HERE YOU CAN ADD | EDIT | DELETE ...etc Categories
	===========================================================
	*/
	ob_start();
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
				//Manage page
				//$stmt = $conn->prepare("SELECT * FROM items"); //WE MAKE EXCEPTION FOR USERS OF GROUPID = 1 BECAUSE THEY ARE THE ADMINS OF THE SYSTEM
				$stmt = $conn->prepare("SELECT comments.* , items.Name AS item_name , users.Username FROM comments INNER JOIN items ON items.ID = comments.item_id INNER JOIN users ON users.UserID = comments.user_id");
				$stmt->execute();
				$rows = $stmt->fetchAll();
				?>

				<h1 class="text-center"> Manage Items</h1>

				<!-- Add link -->
				<div class="container">
					<div class="table-responsive">
						<table class="main-table text-center table table-borderd">
							<tr>
								<td>#ID</td>
								<td>Comment</td>
								<td>Date</td>
								<td>Member Name</td>							
								<td>Item Name</td>								
								<td>Manage</td>
								
							</tr>
							<?php 
							foreach($rows as $row)
							{
								echo '<tr>';
								echo '<td>'.$row['c_ID'].'</td>';
								echo '<td>'.$row['comment'].'</td>';
								echo '<td>'.$row['date'].'</td>';				
								echo '<td>'.$row['Username'].'</td>';
								echo '<td>'.$row['item_name'].'</td>';								
								echo '<td>'.
										'<a href="comments.php?get=Edit&id='.$row['c_ID'].'"'.'class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Edit</a>
							      		<a href="comments.php?get=Delete&id='.$row['c_ID'].'"'.'class="btn btn-danger btn-sm confirm"><i class="fa fa-close"></i> Delete</a>';
							      		if($row['status'] == 0)
				      					{
		      								echo '<a href="comments.php?get=Approve&id='.$row['c_ID'].'"'.'class="btn btn-primary btn-sm activate"><i class="fa fa-info"></i> Activate</a>';

				      					}

								echo '</td>';								
								echo '</tr>';
							}
							?>
							
							
						</table>
						
					</div>					
				</div>
				<?php				
				break;

			case 'Edit':
				//Checking Whether Userid isset and numeric
				if(isset($_GET['id']) && is_numeric($_GET['id'])){
					$c_id =intval($_GET['id']);
					// $stmt = $conn->prepare('SELECT comments.* , items.Name AS item_name , users.Username AS user_name
					// 						FROM comments 
					// 						INNER JOIN items ON items.ID = comments.item_id 
					// 						INNER JOIN users ON users.UserID = comments.user_id');
					$stmt = $conn->prepare("SELECT * FROM comments WHERE c_ID = ?");
					$stmt->execute(array($c_id));
					$record = $stmt->fetch();					 
					$count = $stmt->rowCount();
					if($count > 0)
					{

						//Record exists in the database , So show Edit Form ?>						
						<h1 class="text-center">Edit Comment</h1>
						<div class="container">
							<form action="comments.php?get=Update" method="POST" class="form-horizontal">
								<input type="hidden" name="c_id" value="<?php echo $c_id; ?>">
								<div class="form-group form-group-lg">
									<label for="comment" class="col-sm-2 control-label"> 
									 Comment</label>
									<div class="col-sm-10 col-md-4">
										<textarea name="comment" id="" cols="30" rows="10" class="form-control" required="required"><?php echo $record['comment'];?></textarea>		
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



				
				?>			
				<?php			

			case 'Update':
				//Update page				
				echo '<h1 class="text-center">Edit Item</h1>';
				//checking Request
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					
					//fetching Form data
					$c_id = $_POST['c_id'];					
					$comment = $_POST['comment'];				

					/*-----------------
					//Validating Data
					------------------*/

					//Updating Database Only If No error Was Found
					if(!empty($comment))
					{
						//Updating database record
						$stmt = $conn->prepare("UPDATE comments SET comment = ? WHERE c_ID = ?");
						$stmt->execute(array(
											$comment,
											$c_id											
											));
						echo '<div class="alert alert-success">'. $stmt->rowCount().' '.'Record Updated Successfully'. '</div>';	
						
					}				

				}else
				{
					echo "This Page Cannot Be Browsed Directly";
				}

				break;	


			case 'Approve':
				if(isset($_GET['id']) && is_numeric($_GET['id']))
				{
					//Registering Id
					$c_id = $_GET['id'];
					//Update 'RegStatus' in the database
					$stmt = $conn->prepare("UPDATE comments SET status = :stat WHERE c_ID = :c_id");
					$stmt->execute(array(
									'stat' => 1 , 
									'c_id'=> $c_id
										));
					echo '<div class="alert alert-success">'. $stmt->rowCount().' '.'Record Updated Successfully'. '</div>';
				}
				break;			

			case 'Delete':
				//Delete page 				
				//Check The Validation Of the Id routing parameter
			echo '<h1 class="text-center">Delete Item</h1>';
			echo '<div class="container">';
					if(isset($_GET['id']) && is_numeric($_GET['id']))
					{
						//Obtaining The Record From The Database
						$id = intval($_GET['id']);  //store the id
						$stmt = $conn->prepare('SELECT * FROM comments WHERE c_ID = :comment_id LIMIT 1');
						$stmt->bindParam(':comment_id',$id);
						$stmt->execute();
						$record = $stmt->fetch();
						$check = checkItems('c_ID','comments',$id);
						if ($stmt->rowCount() > 0) {
							$stmt = $conn->prepare('DELETE FROM comments WHERE c_ID = :comment_id LIMIT 1');
							$stmt->bindParam(':comment_id',$id);
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


ob_end_flush();








?>