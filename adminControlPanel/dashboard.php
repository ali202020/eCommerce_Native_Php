<?php 

	
	session_start();  // START NEW SESSION OR RESUME EXISTING ONE
	
	
	//IF THERE IS EXISTING SESSION REDIRECT TO 'dashboard.php' -as i got-
	if(isset($_SESSION['Username'])){
		echo 'Welcome' .' '. $_SESSION['Username'];
		include 'init.php';	
		
	}else{
		// echo 'you are not authorized to navigate to this page';
		//redirect to login page
		header('Location:index.php');
		exit();
	}

?>



<!-- START MAIN DASHBOARD CONTENT -->
<h1 class="text-center"> Dashboard </h1>
<div class="container text-center statistics-parent ">
	<div class="row">

		<div class="col-md-3">
			<div class="statistics stats-members">
				Total Members 
				<span> <a href="members.php"><?php echo countItems('UserID','users');?></a></span>				
			</div>			
		</div>


		<div class="col-md-3">
			<div class="statistics stats-pending">
				Pending Memebers
				<span><a href="members.php?get=Manage&members=Pending"><?php echo checkItems('RegStatus','users',0);?></a></span>				
			</div>			
		</div>


		<div class="col-md-3">
			<div class="statistics stats-items">
				Total Items
				<span><a href="items.php?get=Manage"><?php echo countItems('ID','items');?></a></span>				
			</div>			
		</div>


		<div class="col-md-3">
			<div class="statistics stats-comments">
				Total Comments
				<span><a href="comments.php?get=Manage"><?php echo countItems('c_ID','comments');?></a></span>				
			</div>			
		</div>


	</div>	
</div>




<div class="container parent-latest">
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-users"></i> Latest Users					
				</div>
				<div class="panel-body">
					tesssst 					
				</div>				
			</div>			
		</div>

		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-tag"></i> Latest Items					
				</div>
				<div class="panel-body">
					tessssssst					
				</div>
			</div>
		</div>		
	</div>	
</div>




<!-- End Main Dashboard -->



<?php
	include $tpls."footer.inc";
?>


