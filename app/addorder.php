<div class="col-sm-10 col-sm-offset-1 form-group" style="background:#fff;border-radius:5px;margin-top:30px">
	<h1 class="text-center">Appoint an Order</h1>
	<?php
	if(isset($_POST['id'])){
		if(isset($_POST['services'])){
			//save info from $_post to local variables
			$carid = $_POST['id'];
			$emp_id = $_POST['emp_id'];
			$customerid = $_SESSION['customer_id'];
			$time = $_POST['time'];
			//creat SQL and execute query
			$num_pending = $mysql->oneQuery("SELECT COUNT(ID) FROM orders WHERE status < 4");
			$sql_order= "INSERT INTO orders (cus_id,Date,Time,status,rate) VALUES ('$customerid',NOW(),'$time','1','')";
			$mysql->query($sql_order); 		
			$order_id = mysql_insert_id();
			for($i=0;$i<count($_POST['services']);$i++){
				$sql_orderProduct = "INSERT INTO order_product(order_id,product_id,Quantity) VALUES ('$order_id','".$_POST['services'][$i]."','1')";
				$mysql->query($sql_orderProduct);
			}
            $sql_orderService = "INSERT INTO order_service(emp_id,car_id,order_id) VALUES ('$emp_id','$carid','$order_id')";
            $mysql->query($sql_orderService);
			echo"<script type='text/javascript'>alert('There have ".$num_pending." people before'); location='index.php?page=order';</script>"; 
		}else{
			echo "<script>alert('No service selected')</script>";
		}
	}
	?>
	<div class="col-sm-8 col-sm-offset-2">
		<?php
		$sql_orders = "SELECT c.*,CONCAT(username,'-',FirstName,' ',LastName) as user FROM car AS c INNER JOIN customer AS cu ON c.cus_id=cu.id WHERE cus_id ='".$_SESSION['customer_id']."'";
		$result_orders = $mysql->query($sql_orders);
		$row_orders = $mysql->fetch($result_orders);
		?>
		<form method="post"> 
			<div class="form-group">
				<label>Current User: <?php echo $row_orders['user'];?></label>
			</div>
			<div class='form-group'>
				<label for='emp'>Worker: <span id='empName'></span></label>
				<input name='emp_id' id='emp' class='form-control selectid' onchange="selectCus(this,'empQueryRes','empName')" list='empQueryRes' placeholder="ID/Username" onfocus="this.autocomplete='off'" onblur="this.autocomplete='on'">
				<datalist id="empQueryRes">  
				<?php 
					$sql_employee = "SELECT * FROM employee";
					$result_emp = $mysql->query($sql_employee);
					while($row = $mysql->fetch($result_emp)) {
						echo "<option value=".$row['id'].">".$row['username']." - ".$row['firstname']." ".$row['lastname']."</option>";
					}	
				?>
				</datalist>
			</div>
			<div class="form-group">
				<label>Choose Car:</label>
				<select name="id" class="form-control"> 
				<?php
					while ($row_orders = $mysql->fetch($result_orders)){
				?>
					<option value="<?php echo $row_orders['id']; ?>">
						<?php echo $row_orders['plate']; ?>
					</option> 
				<?php
					}
				?>
				</select> 
			</div>
			<div class="form-group">
				<label>Choose Services:</label>
				<?php
					$sql_serviers = "SELECT * FROM product_service WHERE type_id = 1 AND Price IS NOT NULL";
					$result_serviers = $mysql->query($sql_serviers);
					while ($row_serviers = $mysql->fetch($result_serviers)){
				?>
				<div class="form-group col-sm-offset-1">
					<label><?php echo $row_serviers['product_name']; ?>:</label>
					<input type="checkbox" class='form-control' name="services[]" value="<?php echo $row_serviers['id']; ?>">
				</div>
				<?php
					}
				?>
			</div>
			<div class="form-group">
				<label>Time:</label>
				<input type="time" class="form-control" name="time" min="<?php echo date('H:m',time());?>" value="<?php echo date('H:m',time());?>">
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-block btn-lg btn-primary">Submit</button>
			</div>
		</form>
	</div>
