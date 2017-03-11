<h1>Add Order!</h1><br/>This form is to add order <br/><br/>
	<?php
	if (isset($_GET['id'])){
		$customer_id = $_GET['id'];
	}
	if (isset($_POST['menu_name']) && isset($_POST['menu_link']) && isset($_POST['menu_orders'])) {
		//save info from $_post to local variables
		$menu_name = $_POST['menu_name'];
		$menu_link = $_POST['menu_link'];
		$menu_orders = $_POST['menu_orders'];
	
		if($menu_name == "")  
		{    
		// check vaule
		     echo"<script type='text/javascript'>alert('Write Name');location='home2.php?page=updatem&id=$menu_id'; </script>";            
		}  
		elseif($menu_link == "")  
		{  
  
		// check vaule
		    echo"<script type='text/javascript'>alert('Write Link');location='home2.php?page=updatem&id=$menu_id'; </script>";  
      
		}  
		elseif($menu_orders == "")  
		{  
  
		// check vaule
		    echo"<script type='text/javascript'>alert('Write Orders');location='home2.php?page=updatem&id=$menu_id'; </script>";  
      
		} 
		else  
		//creat SQL and execute qurty
		$sql = "UPDATE menu SET name = '$menu_name', link = '$menu_link', orders = '$menu_orders' WHERE id = '$menu_id'";
		echo"<script type='text/javascript'>alert('Update a Success'); location='home2.php?page=checkmenu';</script>"; 
		$result = mysql_query($sql) or die(mysql_error());
	}
	?>
						<form method="post">
		<?php
		if (isset($_GET['id'])){
			$id =$_GET['id'];
			$result = mysql_query("SELECT id,name,link,orders  FROM menu WHERE id = $id");
			//select information from database
			while ($row = mysql_fetch_array($result)) {
		?>
							<label for="name">Menu Name</label>
	    					<input type="text" name="menu_name" class="form-control" placeholder="<?php echo $row{'name'}; ?>"><br/><br/>
							
						</form>
    	<?php 
			}
		}
		?>
					</div>
				</div>
			</div>
		</div>