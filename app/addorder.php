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
		$conditions = 1;
		//creat SQL and execute qurty
		$sql_order= "INSERT INTO orders (customerid, carid, order_date, order_time, conditions) VALUES ('$customerid', '$carid', '$date', '$time', '$conditions')";		
		$sql_before = "SELECT count(id) FROM orders WHERE conditions='1'";
		$result_before = $mysql->query($sql_before);
		$mysql->query($sql_order); 
		$row_before = $mysql->fetch($result_before);
		echo"<script type='text/javascript'>alert('There have ".$row_before[0]." people before'); location='index.php?page=order';</script>"; 
	}
	?>
	<div class="col-sm-10 col-md-offset-2">
		<?php
		$sql_orders = "SELECT car.id,car.plate,customer.name FROM customer INNER JOIN customercar ON customer.id = customercar.customerid INNER JOIN car ON customercar.carid = car.id WHERE customer.id='".$_SESSION['customer_id']."'";
		$result_orders = $mysql->query($sql_orders);
		$row_orders = $mysql->fetch($result_orders);
		?>
	</div>
		<div class="col-sm-10 col-md-offset-2">
			Name:
			<?php echo $row_orders['name'];?>
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