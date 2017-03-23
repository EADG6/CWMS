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
		$sql_orders = "SELECT customer.name, customer.phone, car.plate, car.color, car.type, orders.id, orders.time, orders.conditions FROM customer INNER JOIN orders ON customer.id=orders.customerid INNER JOIN car ON car.id=orders.carid WHERE customer.id='".$_SESSION['customer_id']."'"; 
		$result_orders = mysql_query($sql_orders);
		$row_orders = mysql_fetch_array($result_orders);
		?>
						</form>
	</div>
		<div class"col-sm-12">
			Name:
			<?php echo $row_orders['name']; ?>
		</div>
		<div class"col-sm-12">
			Phone:
			<?php echo $row_orders['phone']; ?>
		</div>
		<div class"col-sm-12 col-md-offset-2">
			<form action="" method="get"> 
				Choose Car:
				<select name=""> 
					<?php
					$num = 0;
					while ($row_orders = mysql_fetch_array($result_orders)){
						$num ++;
					?>
					<option value="<?php echo $num; ?>"><?php echo $row_orders['plate']; ?></option> 
						<?php
					}
						?>
				</select> 
			</form>
	    </div>
		<div class"col-sm-12">
			Time:
			<input type="datetime"／>
		</div>