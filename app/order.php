   <?php
   if (isset($_GET['id'])){
   	$id =$_GET['id'];
   	//delete the menu
   	$result = $mysql->query("DELETE FROM orders WHERE id = $id");
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
				       	 	<th>Order ID</th>        
							<th>Plate</th>
							<th>Time</th>
							<th>Rate</th>
							<th>Comment</th>
							<th>Status</th>
							<th>Delete</th>
						<tr>
					</thead>
						<?php
					$sql_orders = "SELECT o.id,c.plate,CONCAT(Date,' ',Time) AS time,o.status,o.rate FROM orders AS o INNER JOIN order_service AS os ON o.id=os.order_id INNER JOIN car AS c ON c.id=os.car_id WHERE o.cus_id='".$_SESSION['customer_id']."'"; 
					$result_orders = $mysql->query($sql_orders);
					while ($row_orders = $mysql->fetch($result_orders)){
						?>							       
		            <tr>
					 <td><?php echo $row_orders['id']; ?></td>
		             <td><?php echo $row_orders['plate']; ?></td>
		             <td><?php echo $row_orders['time']; ?></td>
		             <td><?php echo $row_orders['rate']; ?></td>
					 <td>
						 <?php
						 	if (isset($_POST['name'])){
								$feedback = $_POST['name'];
								$sql_feedback= "INSERT INTO orders (feedback) VALUES ('$feedback')";
								$mysql->query($sql_feedback); 
							}
						 ?>
						 <form method="post"> 
						 	<script type="text/javascript">
						 		function disp_prompt(){
    						 	   var name = prompt("Write down your","");
						 	  }
  						 	</script>
						 	 <input type="button" onClick="disp_prompt()" value="Feedback" class="btn btn-primary"/>
						 </form>
					 </td>
					 
					 <td>
						<?php 
						switch($row_orders['status']){
							case 1: echo 'Pending';break;
							case 2: echo 'On Going';break;
							case 3: echo 'Done but Unpaid';break;
							case 4: echo 'Paid';break;
						}
						?>
					 </td>
					 <td>
						<a href ="javascript:if(confirm('Are You Sure to Delete?'))location='index.php?page=order&id=<?php echo $row_orders['id']?>'" class="btn btn-primary">Delete </a>
					 </td>
					</tr>
		 				<?php
		 			}
		 				?>
				</table>
        		</div>
    	</div>