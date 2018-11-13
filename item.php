<?php
	ob_start();
	session_start();  // START NEW SESSION OR RESUME EXISTING ONE
	include 'init.php';	
	//obtaining item details from data base through the following steps
	$item_id = isset($_GET['item_id']) &&is_numeric($_GET['item_id']) ? intval($_GET['item_id']) : 0;
	$stmt = $conn->prepare("SELECT items.*, categories.Name AS cat_name , users.Username 
							FROM items
							INNER JOIN categories 
							ON categories.ID = items.Category_ID
							INNER JOIN users
							ON users.UserID = items.User_ID
							WHERE items.ID = ?");
	$stmt->execute(array($item_id));
	$count = $stmt->rowCount();
	if($count > 0){
		//ad exists 
		$item = $stmt->fetch(); 

?>

<h1 class="text-center"><?php echo $item['Name']; ?></h1>

<div class="container">
	<div class="row">
		<div class="col-md-3">
			<img class='image-responsive' src='https://imgplaceholder.com/250x250'/>
		</div>
		<div class="col-md-9 item-info">
			<h2>Item Name :<?php echo $item['Name']; ?></h2>
			<p>Description : <?php echo $item['Description']; ?></p>
			<ul>				
				<li><i class = "fa fa-calendar fa-fw"></i><span>Added Date</span>:<?php echo $item['Add_Date']; ?></li>
				<li><i class = "fa fa-money fa-fw"></i><span>Price</span>: $<?php echo $item['Price'];?></li>
				<li><i class = "fa fa-building fa-fw"></i><span>Made In</span>:<?php echo $item['Country_made']; ?></li>
				<li><i class = "fa fa-tags fa-fw"></i><span>Category</span>: <a href="categories.php?pageid=<?php echo $item['Category_ID']; ?>">
				 <?php echo $item['cat_name']; ?>				 	
				 </a>
				</li>
				<li><i class = "fa fa-user fa-fw"></i><span>Added By</span>: <a href="">
					<?php echo $item['Username']; ?>					
				</a>
				</li>
			</ul>
			<h2></h2>
			<p></p>
			<span></span>
			<div></div> 
			<div></div>
			<div></div>
			<div></div>
			
		</div>
	</div>
</div>	

<!-- <div class="latest-comments block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				My Latest Comments				
			</div>
			<div class="panel-body">
				
			</div>
		</div>
	</div>
</div> -->

<?php 

	}
	else
	{
		//add doesont exist exist
		echo '<div class="container"><div class="alert alert-danger">'.'There Is No Such Ad'.'</div></div>';
	}
include $footer."footer.inc" ;
ob_end_flush();
 ?> 
