<?php
	ob_start();
	session_start();  // START NEW SESSION OR RESUME EXISTING ONE
	include 'init.php';
	if(isset($_SESSION['User'])){
		//obtaining user information		
		$userInfo = $conn->prepare("SELECT * FROM users WHERE Username = ?");
		$userInfo->execute(array($_SESSION['User']));
		$info = $userInfo->fetch();	

?>

<h1 class="text-center">My Profile</h1>	

<div class="information block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				My Information				
			</div>
			<div class="panel-body">
				<ul>
					<li><i class="fa fa-unlock-alt fa-fw"></i><span>Name</span>: <?php echo $info['Username'];?></li>
					<li><i class="fa fa-envelope fa-fw"></i><span>Email</span>: <?php echo $info['Email'];?></li>
					<li><i class="fa fa-user fa-fw"></i><span>Full Name</span>: <?php echo $info['FullName'];?> </li>
					<li><i class="fa fa-calendar fa-fw"></i><span>Registered Date</span>: <?php echo $info['Date'];?> </li>
					<li><i class="fa fa-tags fa-fw"></i><span>Fav Category</span>: </li>
					
				</ul>
				
			</div>
		</div>
	</div>
</div>	

<div class="ads block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				My ADS				
			</div>
			<div class="panel-body">
				<?php
				$items = getItems('User_ID',$info['UserID']);
				if(!empty($items))
				{
					foreach ($items as $item) {
					echo "<div class='col col-md-3 col-sm-6'>";
						echo "<div class='thumbnail item-box'>";
							echo "<span class='price-tag'>"."$".$item['Price']."</span>";
							echo "<img class='image-responsive' src='https://imgplaceholder.com/420x320'/>";
							echo "<div class='caption'>";
								echo "<h3><a href='item.php?item_id=".$item['ID']."'>".$item['Name']."</a></h3>";
								echo "<h4>".$item['Description']."</h4>";
								echo "<h6>".$item['Add_Date']."</h6>";
							echo "</div>";
						echo "</div>";
					echo "</div>";					
					}

				}else{
					echo 'There is no Ads to show';
					echo "<a href='newad.php'>Create New Ad</a>";
				}
				?>
				
			</div>
		</div>
	</div>
</div>


<div class="latest-comments block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				My Latest Comments				
			</div>
			<div class="panel-body">
				
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
