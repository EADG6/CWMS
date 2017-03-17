	<?php
		$sql_cusinfo = "SELECT name,username,password,phone  FROM customer WHERE id = '".$_SESSION['customer_id']."'";
		$result = mysql_query($sql_cusinfo);
		$cusinfo = mysql_fetch_array($result);
	?>
	
    <div class="container">
        <div class="row">
				<div class="col-md-12">
				<h1>You Can Update Your Information</h1> 
				</div>
				<?php
					$sql_cusinfo = "SELECT name,username,password,phone  FROM customer WHERE id = '".$_SESSION['customer_id']."'";
					$result_cusinfo = mysql_query($sql_cusinfo);
					$cusinfo = mysql_fetch_array($result_cusinfo);
					if (isset ($_POST['name']) && isset($_POST['username']) && isset($_POST['phone'])){
						$name = $_POST['name'];
						$username = $_POST['username'];
						$phone = $_POST['phone'];
						if($username==""||  $name=="" || $phone=="") {  
							echo"<script type='text/javascript'>alert('Write all the information');location='index.php?page=customer';</script>";
					} else {  
				    $sql_updatecus = "UPDATE customer SET name = '$name', username = '$username', phone = '$phone' WHERE id = '".$_SESSION['customer_id']."'";
					$result_updatecus = mysql_query($sql_updatecus);
					echo"<script type='text/javascript'>alert('Update Success'); location='index.php?page=customer';</script>";
				}
			}
				?> 
				<form method='post'>
				    <div class="form-group col-md-5 col-md-offset-0">  
				    	<label for='name'>Name:</label>
						<input type="text" class="form-control" name="name" id="name" value="<?php echo $cusinfo['name']; ?>">
					</div>
					
				    <div class="form-group col-md-5 col-md-offset-0">  
				    	<label for='username'>Username:</label>
						<input type="text" class="form-control" name="username" id='username' value="<?php echo $cusinfo['username']; ?>">
					</div>			    	
					
				    <div class="form-group col-md-5 col-md-offset-0">  
				    	<label for='phone'>Phone Number:</label>
						<input type="text" class="form-control" name="phone" id='phone' value="<?php echo $cusinfo['phone']; ?>">
					</div>
					
					<div class="col-md-12 col-md-offset-10">			
				    	<input type="submit" value="Submit">  
					</div>
				</form>
				
				<div class="col-md-12">
					<hr>
					<h3>Update Password</h3>
				</div>
				<form method="post">
			    	<div class="form-group col-md-5 col-md-offset-0">  
			   		 	<label for='password'>Password:</label>
						<input type="text" class="form-control" name="password" id='password' placeholder="Your Old Password">
					</div>
			    	<div class="form-group col-md-5 col-md-offset-0">  
			   		 	<label for='password'>Password:</label>
						<input type="text" class="form-control" name="password" id='password' placeholder="New Password">
					</div>
			    	<div class="form-group col-md-5 col-md-offset-0">  
			   		 	<label for='password'>Password:</label>
						<input type="text" class="form-control" name="password" id='password' placeholder="New Password Again">
					</div>
				</form>
				<?php
				$sql_cuscarid = "SELECT carid FROM customercar WHERE customerid = '".$_SESSION['customer_id']."'";
				$result_cuscarid = mysql_query($sql_cuscarid);
				echo $result_cuscarid;
				?>
					<div class="col-md-12">
						<hr>
						<h3>Update Car Information</h3>
					</div>
					<form method="post">
						<div class="col-md-4">
						<h4>First Car</h4>
				   	 		<div class="form-group  col-md-offset-0">  
				   			 	<label for='plate1'>Plate Number 1:</label>
								<input type="text" class="form-control" name="plate1" id='plate1'>
							</div>
					
				    		<div class="form-group  col-md-offset-0">  
				   			 	<label for='colol1'>Color:</label>
								<input type="text" class="form-control" name="color1" id='color1'>
							</div>
							
				    		<div class="form-group  col-md-offset-0">  
				   			 	<label for='type1'>Type:</label>
								<input type="text" class="form-control" name="type1" id='type1'>
							</div>
						</div>
					
						<div class="col-md-4">
						<h4>Second Car</h4>
				   	 		<div class="form-group col-md-offset-0">  
				   			 	<label for='plate2'>Plate Number 2:</label>
								<input type="text" class="form-control" name="plate2" id='plate2'>
							</div>
					
				    		<div class="form-group col-md-offset-0">  
				   			 	<label for='color2'>Color:</label>
								<input type="text" class="form-control" name="color2" id='color2'>
							</div>
							
				    		<div class="form-group col-md-offset-0">  
				   			 	<label for='type2'>Type:</label>
								<input type="text" class="form-control" name="type2" id='type2'>
							</div>
						</div>
						
						<div class="col-md-4">
						<h4>Third Car</h4>
				   	 		<div class="form-group col-md-offset-0">  
				   			 	<label for='plate3'>Plate Number 3:</label>
								<input type="text" class="form-control" name="plate3" id='plate3'>
							</div>
					
				    		<div class="form-group col-md-offset-0">  
				   			 	<label for='color3'>Color:</label>
								<input type="text" class="form-control" name="color3" id='color3'>
							</div>
							
				    		<div class="form-group col-md-offset-0">  
				   			 	<label for='type3'>Type:</label>
								<input type="text" class="form-control" name="type3" id='type3'>
							</div>
						</div>
					<div class="col-md-12 col-md-offset-10">
					    <a href="login.php" class="btn btn-primary" >Back</a>
				    	<input type="submit" value="Submit" class="btn btn-primary">  
				   	 	<input type="reset" value="Delete" class="btn btn-primary">
					</div>
				</form>
		</div>        
	</div>
