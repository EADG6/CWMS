<div class="col-sm-8 col-sm-offset-2">
<h1>Add Order!</h1>
</div>
<div class="col-sm-8 col-sm-offset-2">
This form is to add order 
</div>
	<?php
	if (isset($_POST['id'])){
		//save info from $_post to local variables
		$carid = $_POST['id'];
		$customerid = $_SESSION['customer_id'];
		$date = $_POST['date'];
		$time = $_POST['time'];
		//creat SQL and execute qurty
		$num_pending = $mysql->oneQuery("SELECT COUNT(ID) FROM orders WHERE status < 4");
		$sql_order= "INSERT INTO orders (cus_id,Date,Time,status,rate) VALUES ('$customerid','$date','$time','1','')";	
		$mysql->query($sql_order); 		
		$order_id = mysql_insert_id();
		$mysql->query("INSERT INTO order_service(car_id,order_id,) VALUES('$carid','$order_id','.implode(',',$services).')");
        $sqlstr = "insert into 表(rol) values(".implode(',',$rol).")";
		echo"<script type='text/javascript'>alert('There have ".$num_pending." people before'); location='index.php?page=order';</script>"; 
	}
	?>
	<div class="col-sm-10 col-md-offset-2">
		<?php
		$sql_orders = "SELECT c.*,cu.username FROM car AS c INNER JOIN customer AS cu ON c.cus_id=cu.id WHERE cus_id ='".$_SESSION['customer_id']."'";
		$result_orders = $mysql->query($sql_orders);
		$row_orders = $mysql->fetch($result_orders);
		?>
	</div>
		<div class="col-sm-10 col-md-offset-2">
			Name:
			<?php echo $row_orders['username'];?>
		</div>
		<div class="col-sm-10 col-md-offset-2">
			<form method="post"> 
				Choose Car:
				<select name="id"> 
					<?php
					while ($row_orders = $mysql->fetch($result_orders)){
					?>
					<option value="<?php echo $row_orders['id']; ?>"><?php echo $row_orders['plate']; ?></option> 
						<?php
					}
						?>
				</select> 
	    </div>
		<div class="col-sm-5 col-md-offset-2">
			Choose Services:
		</div>
			<div class="col-sm-10 col-md-offset-2">
				Wax:
				<input type="checkbox" name="services[]" value="Wax">
			</div>
			<div class="col-sm-10 col-md-offset-2">
				Polishing:
				<input type="checkbox" name="services[]" value="Polishing">
			</div>
			<div class="col-sm-10 col-md-offset-2">
				Wash Big Car:
				<input type="checkbox" name="services[]" value="Big Car Washing">
			</div>
            <div class="col-sm-10 col-md-offset-2">
				Fine Wash Big Car:
				<input type="checkbox" name="services[]" value="Fine Big Car Washing">
			</div>
			<div class="col-sm-10 col-md-offset-2">
				Wash Small Car:
				<input type="checkbox" name="services[]" value="Small Car Washing">
			</div>
            <div class="col-sm-10 col-md-offset-2">
				Fine Wash Small Car:
				<input type="checkbox" name="services[]" value="Fine Small Car Washing">
			</div>
		<div class="col-sm-10 col-md-offset-2">
			Date:
			<input type="date" name="date">
		</div>
		<div class="col-sm-10 col-md-offset-2">
			Time:
			<input type="time" name="time">
		</div>
		<div class="col-sm-10 col-md-offset-2">
			<input type="submit" value="Submit" class="btn btn-primary">
		</div>
		</form>
