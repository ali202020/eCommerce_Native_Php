<?php
?>


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
      <a class="navbar-brand" href="../index.php">Home page</a>
    </div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">        
        <li><a href="categories.php">Categories</a></li>      
      </ul>
      <ul class="nav navbar-nav">        
        <li><a href="<?php echo 'members.php?get=Manage';?>">Manage Members</a></li>      
      </ul>
      <ul class="nav navbar-nav">        
        <li><a href="<?php echo 'items.php?get=Manage';?>">Manage Items</a></li>      
      </ul>
      <ul class="nav navbar-nav">        
        <li><a href="<?php echo 'comments.php?get=Manage';?>">Manage Comments</a></li>      
      </ul>
      <ul class="nav navbar-nav">        
        <li><a href="#">#</a></li>      
      </ul>
      
      <ul class="nav navbar-nav navbar-right">
        
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Ali <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="../index.php">Visit Shop</a></li>
            <li><a href="members.php?get=Edit&id=<?php echo $_SESSION['UserID'];?>">Edit Profile</a></li>
            <li><a href="#">Settings</a></li>            
            <li role="separator" class="divider"></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>




