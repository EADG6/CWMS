    <?php
	if ($_SESSION['customer_id'] == 0 ){
		unset($_SESSION['customer_id']);
		session_destroy();
		echo "<script>alert('Please Login First');location.href='login.php'</script>";
	}
    ?>
    <body background="../CWMS/static/img/bg3.jpg">
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
				    	<input type="submit" value="Submit" class="btn btn-primary">  
					</div>
				</form>
				
				<div class="col-md-12">
					<hr>
					<h3>Update Password</h3>
				</div>
				<?php
				if (isset ($_POST['password'])){
					$password_old = $cusinfo['password'];
					$password = $_POST['password'];
					$new_password = $_POST['newpassword'];
					$new_password_again = $_POST['newpasswordagain'];
					if($password==""|| $new_password=="" || $new_password_again=="") {  
						echo"<script type='text/javascript'>alert('Write all the information');location='index.php?page=customer';</script>";
							} else if ($new_password!=$new_password_again){
								echo"<script type='text/javascript'>alert('New Password Not Same');location='index.php?page=customer';</script>";
								} else if ($password!=$password_old){
									echo"<script type='text/javascript'>alert('Wrong Password ');location='index.php?page=customer';</script>";
					} else {
						$sql_updatepass = "UPDATE customer SET password = '$new_password' WHERE id = '".$_SESSION['customer_id']."'";
						$result_updatepass = mysql_query($sql_updatepass);
						echo"<script type='text/javascript'>alert('Update Success'); location='index.php?page=customer';</script>";
					}
				}
				?>
				<form method="post">
			    	<div class="form-group col-md-5 col-md-offset-0">  
			   		 	<label for='password'>Password:</label>
						<input type="text" class="form-control" name="password" id='password' placeholder="Your Old Password">
					</div>
			    	<div class="form-group col-md-5 col-md-offset-0">  
			   		 	<label for='newpassword'>New Password:</label>
						<input type="text" class="form-control" name="newpassword" id='newpassword' placeholder="New Password">
					</div>
			    	<div class="form-group col-md-5 col-md-offset-0">  
			   		 	<label for='newpasswordagain'>New Password Again:</label>
						<input type="text" class="form-control" name="newpasswordagain" id='newpasswordagain' placeholder="New Password Again">
					</div>
					<div class="col-md-12 col-md-offset-10">			
				    	<input type="submit" value="Submit" class="btn btn-primary">  
					</div>
				</form>
				<hr>
				<div class="col-md-12">
					<h3>Update Car Information</h3>
				</div>
				<?php
				$sql_cuscarid = "SELECT car.id,car.plate,car.color,car.type FROM customer INNER JOIN customercar ON customer.id = customercar.customerid INNER JOIN car ON customercar.carid = car.id WHERE customer.id='".$_SESSION['customer_id']."'";
				$result_cuscarid = mysql_query($sql_cuscarid);
				$rows = mysql_num_rows($result_cuscarid);
				$num = 0;
				while ($row_carinfo = mysql_fetch_array($result_cuscarid)) {
					$num ++;
				?>
				<?php
				if (isset ($_POST['plate1'])){
					$plate1 = $_POST['plate1'];
					$plate2 = $_POST['plate2'];
					$plate3 = $_POST['plate3'];
					$color1 = $_POST['color1'];
					$color2 = $_POST['color2'];
					$color3 = $_POST['color3'];
					$type1 = $_POST['type1'];
					$type2 = $_POST['type2'];
					$type3 = $_POST['type3'];
					$id1 = $_POST['id1'];
					$id2 = $_POST['id2'];
					$id3 = $_POST['id3'];
					$sql_updatecar1 = "UPDATE car SET plate = '$plate1', type = '$type1', color = '$color1' WHERE id = '$id1'";
					$result_updatecar1 = mysql_query($sql_updatecar1);
					$sql_updatecar2 = "UPDATE car SET plate = '$plate2', type = '$type2', color = '$color2' WHERE id = '$id2'";
					$result_updatecar2 = mysql_query($sql_updatecar2);
					$sql_updatecar3 = "UPDATE car SET plate = '$plate3', type = '$type3', color = '$color3' WHERE id = '$id3'";
					$result_updatecar3 = mysql_query($sql_updatecar3);
					
					echo"<script type='text/javascript'>alert('Update Success'); location='index.php?page=customer';</script>";
				}
				?>
					<form method="post">
						<div class="col-md-4">
						<h4>Car Information<?php echo $num;?></h4>
				   	 		<div class="form-group  col-md-offset-0">  
				   			 	<label for='plate'>Plate Number:</label>
								<input type="text" class="form-control" name="plate<?php echo $num;?>" id='plate' value="<?php echo $row_carinfo['plate']; ?>">
								<input type="hidden" name="id<?php echo $num;?>" value="<?php echo $row_carinfo['id']; ?>">
							</div>
					
				    		<div class="form-group  col-md-offset-0">  
				   			 	<label for='colol'>Color:</label>
								<input type="text" class="form-control" name="color<?php echo $num;?>" id='color' value="<?php echo $row_carinfo['color']; ?>">
								<input type="hidden" name="id<?php echo $num;?>" value="<?php echo $row_carinfo['id']; ?>">
							</div>
							
				    		<div class="form-group  col-md-offset-0">  
				   			 	<label for='type'>Type:</label>
								<input type="text" class="form-control" name="type<?php echo $num;?>" id='type' value="<?php echo $row_carinfo['type']; ?>">
								<input type="hidden" name="id<?php echo $num;?>" value="<?php echo $row_carinfo['id']; ?>">
							</div>
						</div>
					<?php
				}
					?>
						<div class="col-md-12 col-md-offset-10">
				    		<input type="submit" value="Submit" class="btn btn-primary">  
						</div>
				  </form>
		</div>        
	</div>
    </body>