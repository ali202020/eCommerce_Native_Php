<?php
	/*=========================================================
	======= 			MANAGING Categories       =============
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
				$stmt = $conn->prepare("SELECT * FROM categories");
				$stmt->execute();
				$rows = $stmt->fetchAll();
				?>

				<h1 class="text-center"> Manage Categories</h1>
				<div class="container categories">
					<div class="panel default-panel">
						<div class="panel-heading category-panel-heading">
							<h4><i class="fa fa-edit"></i> Manage Categories</h4>
							<a href="categories.php?get=Add" class="btn btn-success add-category"><i class="fa fa-plus"></i> Add New Category</a>
							<hr class="panel-heading-hr">
						</div>					
						<div class="panel-body">
							<?php 
							foreach($rows as $row)
							{
								echo '<div class="category">';
									echo '<div class="hidden-btns">';
										echo '<a href="categories.php?get=Edit&id='.$row['ID'].'"class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>';
										echo '<a href="categories.php?get=Delete&id='.$row['ID'].'"class="btn btn-xs btn-danger confirm"><i class="fa fa-close"></i> Delete</a>';										 
									echo '</div>';							
									echo '<h3>'.$row['Name'].'</h3>';
									echo '<p>';
									 	if($row['Description'] == ''){ echo 'This Cateory Has No Description';}else{echo $row['Description'];} 
									echo '</p>';
									if($row['Visibility'] == 0){echo '<span class="vis">Hidden</span>';}
									if($row['Allow_Comment'] == 0){echo '<span class="comm">Comments Disabled</span>';}
									if($row['Allow_Ads'] == 0){echo '<span class="ad">Ads Disabled</span>';}								
									
									
								echo '</div>';	
								echo '<hr>';


							}
							?>							
						</div>
					</div>
					
				</div>

				



				<?php				
				break;
			case 'Edit':

				//Checking Whether Userid isset and numeric
				if(isset($_GET['id']) && is_numeric($_GET['id'])){
					$category_id =intval($_GET['id']);
					$stmt = $conn->prepare('SELECT * FROM categories WHERE ID = ? LIMIT 1');
					$stmt->execute(array($category_id));
					$record = $stmt->fetch();
					$count = $stmt->rowCount();
					if($count > 0)
					{
						//Record exists in the database , So show Edit Form ?>
						<!-- Update page --> 						
						<h1 class="text-center">Edit Category</h1>
						<div class="container">
							<form action="categories.php?get=Update" method="POST" class="form-horizontal">
								<input type="hidden" name="category_id" value="<?php echo $category_id;?>">								
								<div class="form-group form-group-lg">
									<label for="category_name" class="col-sm-2 control-label"> 
									Category name</label>
									<div class="col-sm-10 col-md-4">
										<input type="text" name="category_name" class="form-control" value="<?php echo $record['Name'];?>" autocomplete="off">				
									</div>
								</div>

								<div class="form-group form-group-lg">
									<label for="description" class="col-sm-2 control-label"> 
									Description</label>
									<div class="col-sm-10 col-md-4">
										<input type="text" name="description" class="form-control" value="<?php echo $record['Description'];?>" >		
									</div>
								</div>

								<div class="form-group form-group-lg">
									<label for="ordering" class="col-sm-2 control-label"> 
									Order</label>
									<div class="col-sm-10 col-md-4">										
										<input type="text" name="ordering" class="form-control" value="<?php echo $record['Ordering'];?>">				
									</div>
								</div>

								<div class="form-group form-group-lg">
									<label for="visibility" class="col-sm-2 control-label"> 
									Visibility</label>
									<div class="col-sm-10 col-md-4">
										<div>
											<input type="radio" name="visibility" value="1" <?php if($record['Visibility'] == 1) {echo 'checked';}?> />	
											<label for="visibility">Yes</label>						
										</div>
										<div>
											<input type="radio" name="visibility" value="0" <?php if($record['Visibility'] == 0) {echo 'checked';}?>>
											<label for="visibility">No</label>								
										</div>						
													
									</div>
								</div>

								<div class="form-group form-group-lg">
									<label for="permit_comments" class="col-sm-2 control-label"> 
									Allow Comments</label>
									<div class="col-sm-10 col-md-4">
										<div class="radios">
											<input type="radio" name="permit_comments" value="1" <?php if($record['Allow_Comment'] == 1) {echo 'checked';}?>/>
											<label for="permit_comments">Yes</label>									
										</div>
										<div>
											<input type="radio" name="permit_comments" value="0" <?php if($record['Allow_Comment'] == 0) {echo 'checked';}?>>
											<label for="permit_comments">No</label>									
										</div>
													
									</div>
								</div>

								<div class="form-group form-group-lg">
									<label for="permit_ads" class="col-sm-2 control-label"> 
									Allow Ads</label>
									<div class="col-sm-10 col-md-4">
										<div>
											<input type="radio" name="permit_ads" value="1" <?php if($record['Allow_Ads'] == 1) {echo 'checked';}?>/>
											<label for="permit_ads">Yes</label>									
										</div>
										<div>
											<input type="radio" name="permit_ads" value="0" <?php if($record['Allow_Ads'] == 0) {echo 'checked';}?>>
											<label for="permit_ads">No</label>									
										</div>					
													
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
				<h1 class="text-center">Add Category</h1>
				<div class="container">
					<form action="categories.php?get=Insert" method="POST" class="form-horizontal">
						
						<div class="form-group form-group-lg">
							<label for="category_name" class="col-sm-2 control-label"> 
							Category name</label>
							<div class="col-sm-10 col-md-4">
								<input type="text" name="category_name" class="form-control" placeholder="Category Name" autocomplete="off" required="required">				
							</div>
						</div>

						<div class="form-group form-group-lg">
							<label for="description" class="col-sm-2 control-label"> 
							Description</label>
							<div class="col-sm-10 col-md-4">
								<input type="text" name="description" class="form-control" placeholder="Enter Description" >				
							</div>
						</div>

						<div class="form-group form-group-lg">
							<label for="ordering" class="col-sm-2 control-label"> 
							Order</label>
							<div class="col-sm-10 col-md-4">										
								<input type="text" name="ordering" class="form-control" placeholder="Enter Category Order">				
							</div>
						</div>

						<div class="form-group form-group-lg">
							<label for="visibility" class="col-sm-2 control-label"> 
							Visibility</label>
							<div class="col-sm-10 col-md-4">
								<div>
									<input type="radio" name="visibility" value="1" checked/>	
									<label for="visibility">Yes</label>						
								</div>
								<div>
									<input type="radio" name="visibility" value="0">
									<label for="visibility">No</label>								
								</div>						
											
							</div>
						</div>

						<div class="form-group form-group-lg">
							<label for="permit_comments" class="col-sm-2 control-label"> 
							Allow Comments</label>
							<div class="col-sm-10 col-md-4">
								<div class="radios">
									<input type="radio" name="permit_comments" value="1" checked/>
									<label for="permit_comments">Yes</label>									
								</div>
								<div>
									<input type="radio" name="permit_comments" value="0">
									<label for="permit_comments">No</label>									
								</div>
											
							</div>
						</div>

						<div class="form-group form-group-lg">
							<label for="permit_ads" class="col-sm-2 control-label"> 
							Allow Ads</label>
							<div class="col-sm-10 col-md-4">
								<div>
									<input type="radio" name="permit_ads" value="1" checked/>
									<label for="permit_ads">Yes</label>									
								</div>
								<div>
									<input type="radio" name="permit_ads" value="0">
									<label for="permit_ads">No</label>									
								</div>					
											
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
					$category_id = $_POST['category_id'];
					$category_name = $_POST['category_name'];
					$description = $_POST['description'];
					$ordering = $_POST['ordering'];	
					$visibility = $_POST['visibility'];	
					$permit_comments = $_POST['permit_comments'];	
					$permit_ads = $_POST['permit_ads'];				
					

					//Updating Database Only If No error Was Found
					if(!empty($category_name))
					{
						//Updating database record
						$stmt = $conn->prepare("UPDATE categories SET Name = ?,Description = ?,Ordering = ?,Visibility = ?,Allow_Comment = ?,Allow_Ads = ? WHERE ID = ?");
						$stmt->execute(array($category_name , $description , $ordering, $visibility , $permit_comments , $permit_ads , $category_id));
						echo '<div class="alert alert-success">'. $stmt->rowCount().' '.'Record Updated Successfully'. '</div>';	
						
					}
					else
					{ 
						echo '<div class="alert alert-danger" role="alert"> Category Name Cannot Be empty</div>';

					}				

				}
				else
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
				echo '<h1 class="text-center">Insert Category</h1>';
				//checking Request
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					//fetching Form data					
					$category_name   = $_POST['category_name'];
					$description     = $_POST['description'];
					$ordering        = $_POST['ordering'];											
					$visibility      = $_POST['visibility'];
					$permit_comments = $_POST['permit_comments'];
					$permit_ads      = $_POST['permit_ads'];				
					

					//Validating and Updating Database Only If No error Was Found
					if(!empty($category_name))
					{
						//Check Element existence
						if(checkItems('Name','categories',$category_name) > 0)
						{
							echo '<div class="alert alert-danger"> Category Already Exists </div>';

						}
						else
						{
							//Insert into database record
							$stmt = $conn->prepare("INSERT INTO categories(Name , Description , Ordering , Visibility , Allow_Comment, Allow_Ads)
													 VALUES (:category_name , :description ,:ordering , :visibility , :permit_comments, :permit_ads)");
							$stmt->execute(array('category_name' => $category_name ,
												 'description' => $description , 
												 'ordering' => $ordering,
												 'visibility' => $visibility,
												 'permit_comments'=> $permit_comments,
												 'permit_ads' => $permit_ads));
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
			echo '<h1 class="text-center">Delete Category</h1>';
			echo '<div class="container">';
					if(isset($_GET['id']) && is_numeric($_GET['id']))
					{
						//Obtaining The Record From The Database
						$id = intval($_GET['id']);  //store the id
						$stmt = $conn->prepare('SELECT * FROM categories WHERE ID = :category_id LIMIT 1');
						$stmt->bindParam(':category_id',$id);
						$stmt->execute();
						$record = $stmt->fetch();
						//$check = checItem('ID','categories',$id);
						if ($stmt->rowCount() > 0) {
							$stmt = $conn->prepare('DELETE FROM categories WHERE ID = :category_id LIMIT 1');
							$stmt->bindParam(':category_id',$id);
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