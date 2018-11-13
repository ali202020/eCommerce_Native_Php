<?php
	ob_start();
	session_start();  // START NEW SESSION OR RESUME EXISTING ONE
	include 'init.php';
	if(isset($_SESSION['User'])){
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {			
			
			//Initialize Form errors
			$formErrors     = array();
			//Obtainiing post data
			$item_name      = filter_var($_POST['item_name'],FILTER_SANITIZE_STRING);
			$description    = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
			$price          = filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
			$origin_country = filter_var($_POST['origin_country'],FILTER_SANITIZE_STRING);
			$category       = filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
			$status         = filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
			//Validaing data against errors
			if(strlen($item_name) < 4){ $formErrors[] ='Item Name Must Be More Than 4 Characters';}
			if(strlen($description) < 10){ $formErrors[] ='Item Description Must Be More Than 10 Characters';}
			if(strlen($origin_country) < 2){ $formErrors[] ='Item Country Must Be More Than 2 Characters';}			
			if(empty($price)){ $formErrors[] ='Item Price Must Not Be Empty';}
			// if(empty($category)){}
			// if(empty($category)){}
			
			//Storing Data in the Database Only If No error Was Found
			if(empty($formErrors))
			{						
				//Insert into database record
				$stmt = $conn->prepare("INSERT INTO items(Name , Description , Price , Country_made , Status ,Add_Date,User_ID,Category_ID)
										 VALUES (:item_name , :description ,:price , :origin_country , :status, now() , :member , :category )");
				$stmt->execute(array('item_name' => $item_name ,
									 'description' => $description , 
									 'price' => $price,
									 'origin_country' => $origin_country,
									 'status' => $status,
									 'member' => $_SESSION['user_id'],
									 'category' => $category
									 ));
				echo '<div class="container"><div class="alert alert-success">'. $stmt->rowCount().' '.'Item Inserted Successfully'. '</div></div>';
			}else{
				echo '<div class="container"><div class="alert alert-danger">'.'Failed to insert item'. '</div></div>';
			}				

		}
?>

<h1 class="text-center">Create New Ad</h1>


<div class="create-ad block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				Ad				
			</div>
			<div class="panel-body">
				<div class="row">
					<!-- start ad creation form -->
					<div class="col-md-8">
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="form-horizontal">						
							<div class="form-group form-group-lg">
								<label for="item_name" class="col-sm-2 control-label"> 
								 Item Name</label>
								<div class="col-sm-10 col-md-10">
									<input data-live="name-preview" type="text" name="item_name" class="form-control live-update" placeholder="Item Name" required="required">				
								</div>
							</div>

							<div class="form-group form-group-lg">
								<label for="description-" class="col-sm-2 control-label"> 
								 Description</label>
								<div class="col-sm-10 col-md-10">
									<input data-live="description-preview" type="text" name="description" class="form-control live-update" placeholder="Item description" required="required">				
								</div>
							</div>

							<div class="form-group form-group-lg">
								<label for="price" class="col-sm-2 control-label"> 
								 Price</label>
								<div class="col-sm-10 col-md-10">
									<input data-live="price-preview" type="text" name="price" class="form-control live-update" placeholder="Item price" required="required">				
								</div>
							</div>

							<div class="form-group form-group-lg">
								<label for="origin_country" class="col-sm-2 control-label"> 
								 Origin Country</label>
								<div class="col-sm-10 col-md-10">
									<input type="text" name="origin_country" class="form-control" placeholder="Origin Country" required="required">				
								</div>
							</div>

							<div class="form-group form-group-lg">
								<label for="status" class="col-sm-2 control-label"> 
								Status</label>							 
								<div class="col-sm-10 col-md-10">
									<select name="status" class="form-control" required="required">
										
										<option value="1"> new </option>
										<option value="2"> good </option>
										<option value="3"> semi-good </option>									
									</select>				
								</div>
							</div>						

							<div class="form-group form-group-lg">
								<label for="category" class="col-sm-2 control-label"> 
								category</label>							 
								<div class="col-sm-10 col-md-10">
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
									<input type="submit" value="Create Ad" class="btn btn-primary btn-lg" >				
								</div>
							</div>
						</form>						
					</div>
					<!-- End ad creation form -->

					<!--start Ad show panel -->
					<div class="col-md-4">
						<div class='thumbnail item-box'>
							<span class='price-tag'>
								$<span id="price-preview">0</span>
							</span>
							<img class='image-responsive' src='https://imgplaceholder.com/420x320'/>
							<div class='caption'>
								<h3 id="name-preview">name</h3>
								<p id="description-preview">description</p>
							</div>
						</div>						
					</div>
					<!-- End ad show panel	 -->
				</div>
				<!-- Start looping through errors -->
					<?php					
						if(!empty($formErrors)){
							foreach ($formErrors as $error) {
								echo '<div class="container"><div class="alert alert-danger" style="max-width:1080px">'.$error.'</div></div>';
							}
						}						
					?>
					<!-- end looping through errors -->				
			</div>
		</div>
	</div>
</div>

<?php 

}else{
	header('Location: login.php');
	exit();
}

include $footer."footer.inc" ;
ob_end_flush();
 ?> 
