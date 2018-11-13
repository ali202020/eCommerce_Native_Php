<?php
	/*=========================================================
	======= 			   MANAGING Items     =================
	======= HERE YOU CAN ADD | EDIT | DELETE ...etc Items
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
				$stmt = $conn->prepare("SELECT items.*, categories.Name AS Category_name , users.Username FROM items INNER JOIN categories ON categories.ID = items.Category_ID INNER JOIN users ON users.UserID = items.User_ID");
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
								<td>Item Name</td>
								<td>Description</td>
								<td>Price</td>								
								<td>Orgin Country</td>
								<td>Status</td>
								<td>Date</td>
								<td>Category</td>
								<td>Member</td>
								<td>Manage</td>
								
							</tr>
							<?php 
							foreach($rows as $row)
							{
								echo '<tr>';
								echo '<td>'.$row['ID'].'</td>';
								echo '<td>'.$row['Name'].'</td>';
								echo '<td>'.$row['Description'].'</td>';
								echo '<td>'.$row['Price'].'</td>';
								echo '<td>'.$row['Country_made'].'</td>';
								echo '<td>'.$row['Status'].'</td>';
								echo '<td>'.$row['Add_Date'].'</td>';
								echo '<td>'.$row['Category_name'].'</td>';
								echo '<td>'.$row['Username'].'</td>';
								echo '<td>'.
										'<a href="items.php?get=Edit&id='.$row['ID'].'"'.'class="btn btn-success btn-sm"><i class="fa fa-edit"></i>Edit</a>
							      		<a href="items.php?get=Delete&id='.$row['ID'].'"'.'class="btn btn-danger btn-sm confirm"><i class="fa fa-close"></i>Delete</a>';	

								echo '</td>';								
								echo '</tr>';

							}
							?>
							
							
						</table>
						
					</div>
					<a href="items.php?get=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Item </a>


				</div>


				



				<?php				
				break;
			case 'Edit':

				//Checking Whether Userid isset and numeric
				if(isset($_GET['id']) && is_numeric($_GET['id'])){
					$item_id =intval($_GET['id']);
					$stmt = $conn->prepare('SELECT * FROM items WHERE ID = ? LIMIT 1');
					$stmt->execute(array($item_id));
					$record = $stmt->fetch();					 
					$count = $stmt->rowCount();
					if($count > 0)
					{
						$record_user_id = $record['User_ID'];
						$record_category_id = $record['Category_ID'];
						//Record exists in the database , So show Edit Form ?>						
						<h1 class="text-center">Edit Item</h1>
						<div class="container">
							<form action="items.php?get=Update" method="POST" class="form-horizontal">
								<input type="hidden" name="Item_id" value="<?php echo $item_id; ?>">
								<div class="form-group form-group-lg">
									<label for="item_name" class="col-sm-2 control-label"> 
									 Item Name</label>
									<div class="col-sm-10 col-md-4">
										<input type="text" name="item_name" class="form-control" value="<?php echo $record['Name'];?>" required="required">				
									</div>
								</div>

								<div class="form-group form-group-lg">
									<label for="description" class="col-sm-2 control-label"> 
									 Description</label>
									<div class="col-sm-10 col-md-4">
										<input type="text" name="description" class="form-control" value="<?php echo $record['Description'];?>" required="required">				
									</div>
								</div>

								<div class="form-group form-group-lg">
									<label for="price" class="col-sm-2 control-label"> 
									 Price</label>
									<div class="col-sm-10 col-md-4">
										<input type="text" name="price" class="form-control" value="<?php echo $record['Price'];?>" required="required">				
									</div>
								</div>

								<div class="form-group form-group-lg">
									<label for="origin_country" class="col-sm-2 control-label"> 
									 Origin Country</label>
									<div class="col-sm-10 col-md-4">
										<input type="text" name="origin_country" class="form-control" value="<?php echo $record['Country_made'];?>" required="required">				
									</div>
								</div>

								<div class="form-group form-group-lg">
									<label for="status" class="col-sm-2 control-label"> 
									Status</label>							 
									<div class="col-sm-10 col-md-4">
										<select name="status" class="form-control" required="required">
											
											<option value="1" <?php if($record['Status'] == 1){echo 'selected';}?> > new </option>
											<option value="2" <?php if($record['Status'] == 2){echo 'selected';}?> > good </option>
											<option value="3" <?php if($record['Status'] == 3){echo 'selected';}?> > semi-good </option>									
										</select>				
									</div>
								</div>

								<div class="form-group form-group-lg">
									<label for="member" class="col-sm-2 control-label"> 
									Member</label>							 
									<div class="col-sm-10 col-md-4">
										<select name="member" class="form-control" required="required">
											<?php
												$stmt = $conn->prepare("SELECT * FROM users");
												$stmt->execute();
												$records = $stmt->fetchAll();
												foreach ($records as $record) {
													echo '<option value="'.$record['UserID'].'"';
													if($record_user_id == $record['UserID']){echo 'selected';}
													echo '>';
													echo $record['Username'];
													echo '</option>';											
												}										
											?>
																				
										</select>				
									</div>
								</div>


								<div class="form-group form-group-lg">
									<label for="category" class="col-sm-2 control-label"> 
									category</label>							 
									<div class="col-sm-10 col-md-4">
										<select name="category" class="form-control" required="required">
											<?php
												$stmt = $conn->prepare("SELECT * FROM categories");
												$stmt->execute();
												$records = $stmt->fetchAll();
												foreach ($records as $record) {											

													echo '<option value="'.$record['ID'].'"';
													if($record_category_id == $record['ID']){echo 'selected';}
													echo '>';
													echo $record['Name'];
													echo '</option>';												
												}										
											?>																		
										</select>
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
				<h1 class="text-center">Add Item</h1>
				<div class="container">
					<form action="items.php?get=Insert" method="POST" class="form-horizontal">
						
						<div class="form-group form-group-lg">
							<label for="item_name" class="col-sm-2 control-label"> 
							 Item Name</label>
							<div class="col-sm-10 col-md-4">
								<input type="text" name="item_name" class="form-control" placeholder="Item Name" required="required">				
							</div>
						</div>

						<div class="form-group form-group-lg">
							<label for="description" class="col-sm-2 control-label"> 
							 Description</label>
							<div class="col-sm-10 col-md-4">
								<input type="text" name="description" class="form-control" placeholder="Item description" required="required">				
							</div>
						</div>

						<div class="form-group form-group-lg">
							<label for="price" class="col-sm-2 control-label"> 
							 Price</label>
							<div class="col-sm-10 col-md-4">
								<input type="text" name="price" class="form-control" placeholder="Item price" required="required">				
							</div>
						</div>

						<div class="form-group form-group-lg">
							<label for="origin_country" class="col-sm-2 control-label"> 
							 Origin Country</label>
							<div class="col-sm-10 col-md-4">
								<input type="text" name="origin_country" class="form-control" placeholder="Origin Country" required="required">				
							</div>
						</div>

						<div class="form-group form-group-lg">
							<label for="status" class="col-sm-2 control-label"> 
							Status</label>							 
							<div class="col-sm-10 col-md-4">
								<select name="status" class="form-control" required="required">
									
									<option value="1"> new </option>
									<option value="2"> good </option>
									<option value="3"> semi-good </option>									
								</select>				
							</div>
						</div>

						<div class="form-group form-group-lg">
							<label for="member" class="col-sm-2 control-label"> 
							Member</label>							 
							<div class="col-sm-10 col-md-4">
								<select name="member" class="form-control" required="required">
									<?php
										$stmt = $conn->prepare("SELECT * FROM users");
										$stmt->execute();
										$records = $stmt->fetchAll();
										foreach ($records as $record) {
											echo '<option value="'.$record['UserID'].'">';
											echo $record['Username'];
											echo '</option>';											
										}										
									?>
																		
								</select>				
							</div>
						</div>


						<div class="form-group form-group-lg">
							<label for="category" class="col-sm-2 control-label"> 
							category</label>							 
							<div class="col-sm-10 col-md-4">
								<select name="category" class="form-control" required="required">
									<?php
										$stmt = $conn->prepare("SELECT * FROM categories");
										$stmt->execute();
										$records = $stmt->fetchAll();
										foreach ($records as $record) {
											echo '<option value="'.$record['ID'].'">';
											echo $record['Name'];
											echo '</option>';											
										}										
									?>																		
								</select>
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
				echo '<h1 class="text-center">Edit Item</h1>';
				//checking Request
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					
					//fetching Form data
					$item_id = $_POST['Item_id'];					
					$item_name = $_POST['item_name'];
					$description = $_POST['description'];
					$price = $_POST['price'];					
					$origin_country = $_POST['origin_country'];
					$status = $_POST['status'];
					$member = $_POST['member'];
					$category = $_POST['category'];	
					

					/*-----------------
					//Validating Data
					------------------*/
					//firstly:create errors array
					$form_errors = array();
					if(empty($item_name)){$form_errors[] = '<div class="alert alert-danger" role="alert"> item_name Cannot Be empty</div>';} 
					if(empty($description)){$form_errors[] = '<div class="alert alert-danger" role="alert"> description Cannot Be empty</div>';} 
					if(empty($price)){$form_errors[] = '<div class="alert alert-danger" role="alert"> Price Cannot Be empty</div>';}					
					if(empty($origin_country)){$form_errors[] = '<div class="alert alert-danger" role="alert"> origin_country Cannot Be empty</div>';}
					if($status === 0){$form_errors[] = '<div class="alert alert-danger" role="alert"> status Cannot Be empty</div>';}
					if($member === 0){$form_errors[] = '<div class="alert alert-danger" role="alert"> member Cannot Be empty</div>';}
					if($category === 0){$form_errors[] = '<div class="alert alert-danger" role="alert"> category Cannot Be empty</div>';}
					
					// print_r($form_errors);
					foreach ($form_errors as $error) {
						echo $error;						
					}
					

					//Updating Database Only If No error Was Found
					if(empty($form_errors))
					{
						//Updating database record
						$stmt = $conn->prepare("UPDATE items SET Name = ?,Description = ?,Price = ?,Country_made = ? , Status = ?, User_ID = ? ,Category_ID = ? WHERE ID = ?");
						$stmt->execute(array(
											$item_name,
											$description,
											$price,
											$origin_country,
											$status,
											$member,
											$category,
											$item_id
											));
						echo '<div class="alert alert-success">'. $stmt->rowCount().' '.'Record Updated Successfully'. '</div>';	
						
					}				

				}else
				{
					echo "This Page Cannot Be Browsed Directly";
				}



				break;			

			case 'Insert':
				

				//Insert page				
				echo '<h1 class="text-center">Insert Item</h1>';
				//checking Request
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					//fetching Form data					
					$item_name = $_POST['item_name'];
					$description = $_POST['description'];
					$price = $_POST['price'];					
					$origin_country = $_POST['origin_country'];
					$status = $_POST['status'];
					$member = $_POST['member'];
					$category = $_POST['category'];					
					
					

					/*-----------------
					//Validating Data
					------------------*/
					//firstly:create errors array
					$form_errors = array();
					if(empty($item_name)){$form_errors[] = '<div class="alert alert-danger" role="alert"> item_name Cannot Be empty</div>';} 
					if(empty($description)){$form_errors[] = '<div class="alert alert-danger" role="alert"> description Cannot Be empty</div>';} 
					if(empty($price)){$form_errors[] = '<div class="alert alert-danger" role="alert"> Price Cannot Be empty</div>';}					
					if(empty($origin_country)){$form_errors[] = '<div class="alert alert-danger" role="alert"> origin_country Cannot Be empty</div>';}
					if($status === 0){$form_errors[] = '<div class="alert alert-danger" role="alert"> status Cannot Be empty</div>';}
					if($member === 0){$form_errors[] = '<div class="alert alert-danger" role="alert"> member Cannot Be empty</div>';}
					if($category === 0){$form_errors[] = '<div class="alert alert-danger" role="alert"> category Cannot Be empty</div>';}
					
					// print_r($form_errors);
					foreach ($form_errors as $error) {
						echo $error;						
					}
					

					//Updating Database Only If No error Was Found
					if(empty($form_errors))
					{						
						//Insert into database record
						$stmt = $conn->prepare("INSERT INTO items(Name , Description , Price , Country_made , Status ,Add_Date,User_ID,Category_ID)
												 VALUES (:item_name , :description ,:price , :origin_country , :status, now() , :member , :category )");
						$stmt->execute(array('item_name' => $item_name ,
											 'description' => $description , 
											 'price' => $price,
											 'origin_country' => $origin_country,
											 'status' => $status,
											 'member' => $member,
											 'category' => $category
											 ));
						echo '<div class="alert alert-success">'. $stmt->rowCount().' '.'Record Inserted Successfully'. '</div>';											
						
					}				

				}else
				{
					echo "This Page Cannot Be Browsed Directly";
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
						$stmt = $conn->prepare('SELECT * FROM items WHERE ID = :item_id LIMIT 1');
						$stmt->bindParam(':item_id',$id);
						$stmt->execute();
						$record = $stmt->fetch();
						$check = checkItems('ID','items',$id);
						if ($stmt->rowCount() > 0) {
							$stmt = $conn->prepare('DELETE FROM items WHERE ID = :item_id LIMIT 1');
							$stmt->bindParam(':item_id',$id);
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