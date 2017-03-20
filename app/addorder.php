<div class"col-sm-12 col-md-offset-2">
<h1>Add Order!</h1>
</div>
<div class"col-sm-12 col-md-offset-0">
This form is to add order 
</div>
	<?php
	if (isset($_GET['id'])){
		$customer_id = $_GET['id'];
	}
	if (isset($_POST['carid']) && isset($_POST['time'])) {
		//save info from $_post to local variables
		$carid = $_POST['carid'];
		$time = $_POST['time'];
		$condition = '1';
		//creat SQL and execute qurty
		$sql = "UPDATE orders SET customerid = '$customer_id', link = '$menu_link', orders = '$menu_orders' WHERE id = '$menu_id'";
		echo"<script type='text/javascript'>alert('Update a Success'); location='home2.php?page=checkmenu';</script>"; 
		$result = mysql_query($sql) or die(mysql_error());
	}
	?>
	<div class"col-sm-12 col-md-offset-2">
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
	</div>
    	<?php 
			}
		}
		?>
		<div class"col-sm-12 col-md-offset-2">
			<form action="" method="get"> 
				<label>car</label> 
				<select name=""> 
					<option value="0">1234</option> 
					<option value="1">2345</option>
					<option value="1">3456</option> 
				</select> 
			</form>
	    </div>