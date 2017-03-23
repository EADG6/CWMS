   <?php
   if (isset($_GET['id'])){
   	$id =$_GET['id'];
   	//delete the menu
   	$result = mysql_query("DELETE FROM orders WHERE id = $id");
   		echo"<script type='text/javascript'>alert('Menu Delete Now'); location='index.php?page=order';</script>"; 
   }
	if ($_SESSION['customer_id'] == 0 ){
		unset($_SESSION['customer_id']);
		session_destroy();
		echo "<script>alert('Please Login First');location.href='login.php'</script>";
	}
    ?>
<div class="container">
        <hr>
        <div class="row">
            <div class="col-sm-12 col-md-offset-0">
                <h1>ORDERS</h1>
				<hr>
			</div>
				<h1><a href="index.php?page=addorder">Add New Order</a></h1>
				
				<table class="zebra">
					<thead>
						<tr>
				       	 	<th>#</th>        
							<th>Name</th>
							<th>Phone</th>
							<th>Plate</th>
							<th>Date</th>
							<th>Time</th>
							<th>Condition</th>
							<th>Delete</th>
						<tr>
					</thead>
						<?php
					$sql_orders = "SELECT customer.name, customer.phone, car.plate, car.color, car.type, orders.id, orders.order_time, orders.order_date, orders.conditions FROM customer INNER JOIN orders ON customer.id=orders.customerid INNER JOIN car ON car.id=orders.carid WHERE customer.id='".$_SESSION['customer_id']."'"; 
					$result_orders = mysql_query($sql_orders);
					while ($row_orders = mysql_fetch_array($result_orders)){
						?>							       
		            <tr>
					 <td><?php echo $row_orders['id']; ?></td>
		             <td><?php echo $row_orders['name']; ?></td>
					 <td><?php echo $row_orders['phone']; ?></td>
		   	         <td><?php echo $row_orders['plate']; ?></td>
					 <td><?php echo $row_orders['order_date']; ?></td>
					 <td><?php echo $row_orders['order_time']; ?></td>
					 <td><?php echo $row_orders['conditions']; ?></td>
					 <td><?php
						 if ($row_orders['conditions']<=1){
						 	?>
							<a href ="javascript:if(confirm('Are You Sure to Delete?'))location='index.php?page=order&id=<?php echo $row_orders['id']?>'">Delete </a>
						<?php
						 }else{
							 echo"Order In Use";
						}
							?>
						</td>
					 </tr>
		 				<?php
		 			}
		 				?>
				</table>
        		</div>
    	</div>
