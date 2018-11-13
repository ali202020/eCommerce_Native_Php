<?php?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title> Admin Panel </title>		
		<link rel="stylesheet" href="<?php echo $css ;?>font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo $css ;?>bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo $css ;?>front.css">

	</head>
	<body>		
		<div class="upper-bar">	
			<div class="container">
				<?php

				if(isset($_SESSION['User']))
				{ ?>
				<img src="https://imgplaceholder.com/120x120" alt="" class="img-circle">
				<div class="btn-group">					
					<span class="btn dropdown-toggle" data-toggle="dropdown">						
						<?php echo $_SESSION['User']; ?>
						<span class="caret"></span>
					</span>					
					<ul class="dropdown-menu">
				      <li><a class="dropdown-item" href="myprofile.php">My Profile</a></li>
				      <li><a class="dropdown-item" href="newad.php">Create New Ad</a></li>
				      <li><a class="dropdown-item" href="logout.php">LogOut</a></li>
				    </ul>
					
				</div>
				
						<!-- 
						
						$user_reg_status = checkUserReg($_SESSION['User']);
						if($user_reg_status == 0){
							//user not activated by admin

						}else{
							//user activated by admin
						} -->
				<?php }else{?>
				
				<a href="login.php">
					<span class="pull-right">
						Login/SignUp						
					</span>
				</a>
				<?php }?>			
			</div>			
		</div>

		<nav class="navbar navbar-inverse">
		  <div class="container">

		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="index.php">Home page</a>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav navbar-right"> 
		      <?php
		      $cats = getCategories();
		      foreach($cats as $cat){					
					echo "<li>";				
					echo "<a href='categories.php?pageid=".$cat['ID']."'>";
					echo $cat['Name'];
					echo "</a>";
					echo "</li>";
				}           
		       ?>    
		      </ul>	     
		    </div><!-- /.navbar-collapse -->
	      </div>
	  	</nav>