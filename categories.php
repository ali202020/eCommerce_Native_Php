<?php 
	ob_start();
	session_start();  // START NEW SESSION OR RESUME EXISTING ONE
	include 'init.php'; ?>



<div class="container">	
	<div class="row">
	<?php 


		$items = getItems('Category_ID',$_GET['pageid']);
		foreach ($items as $item) {
			echo "<div class='col col-md-3 col-sm-6'>";
				echo "<div class='thumbnail item-box'>";
					echo "<span class='price-tag'>".'$'.$item['Price']."</span>";
					echo "<img class='image-responsive' src='https://imgplaceholder.com/420x320'/>";
					echo "<div class='caption'>";
						echo "<h3><a href='item.php?item_id=".$item['ID']."'>".$item['Name']."</a></h3>";
						echo "<p>".$item['Description']."</p>";
						echo "<h6>".$item['Add_Date']."</h6>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
			
		}
	 ?>
	 </div>

</div>













<?php include $footer."footer.inc";
	  ob_end_flush() ?>