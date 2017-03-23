<div class"col-sm-12 col-md-offset-2">
<h1>Add Order!</h1>
</div>
<div class"col-sm-12 col-md-offset-0">
This form is to add order 
</div>
	<?php
	if (isset($_POST['id']) && isset($_POST['date']) && isset($_POST['time'])) {
		//save info from $_post to local variables
		$carid = $_POST['id'];
		$customerid = $_SESSION['customer_id'];
		$date = $_POST['date'];
		$time = $_POST['time'];
		$conditions = 1;
		//creat SQL and execute qurty
		$sql_order= "INSERT INTO orders (customerid, carid, order_date, order_time, conditions) VALUES ('$customerid', '$carid', '$date', '$time', '$conditions')";
		mysql_query($sql_order);
		echo"<script type='text/javascript'>alert(''); location='index.php?page=order';</script>"; 
	}
	?>
	<div class"col-sm-12 col-md-offset-2">
		<?php
		$sql_orders = "SELECT car.id,car.plate,customer.name FROM customer INNER JOIN customercar ON customer.id = customercar.customerid INNER JOIN car ON customercar.carid = car.id WHERE customer.id='".$_SESSION['customer_id']."'";
		$result_orders = mysql_query($sql_orders);
		$row_orders = mysql_fetch_array($result_orders);
		?>
	</div>
		<div class"col-sm-12">
			Name:
			<?php echo $row_orders['name'];?>
		</div>
		<div class"col-sm-12 col-md-offset-2">
			<form method="post"> 
				Choose Car:
				<select name="id"> 
					<?php
					while ($row_orders = mysql_fetch_array($result_orders)){
					?>
					<option value="<?php echo $row_orders['id']; ?>"><?php echo $row_orders['plate']; ?></option> 
						<?php
					}
						?>
				</select> 
	    </div>
		<div class"col-sm-12">
			Date:
			<input type="date" name="date">
		</div>
		<div class"col-sm-12">
			Time:
			<input type="time" name="time">
		</div>
		<input type="submit" value="Submit" class="btn btn-primary">
		</form>