    <?php
	if ($_SESSION['customer_id'] == 0 ){
		unset($_SESSION['customer_id']);
		session_destroy();
		echo "<script>alert('Please Login First');location.href='login.php'</script>";
	}
    ?>
	<div class="container">
        <div class="row">
				<div class="col-md-12 customer">
				<h1>You Can Update Your Information</h1> 
				</div>
				<?php
					$sql_cusinfo = "SELECT * FROM customer WHERE id = '".$_SESSION['customer_id']."'";
					$result_cusinfo = $mysql->query($sql_cusinfo);
					$cusinfo = $mysql->fetch($result_cusinfo);
					if (isset ($_POST['fname'])){
						$fname = $_POST['fname'];
						$lname = $_POST['lname'];
						$phone = $_POST['phone'];
                        $sex = $_POST['sex'];
                        $address = $_POST['address'];
						if($lname==""||  $fname=="" || $phone=="" || $address=="") {  
				    echo"<script type='text/javascript'>alert('Write all the information');location='index.php?page=customer';</script>";
					} else {  
				    $sql_updatecus = "UPDATE customer SET FirstName = '$fname', LastName = '$lname', tel = '$phone', address = '$address', sex = '$sex' WHERE id = '".$_SESSION['customer_id']."'";     
					$result_updatecus = $mysql->query($sql_updatecus);
					echo"<script type='text/javascript'>alert('Update Success'); location='index.php?page=customer';</script>";
				}
			}
				?> 
				<form method='post'>
				    <div class="form-group col-md-5 col-md-offset-0 customer">  
				    	<label for='fname'>First Name:</label>
						<input type="text" maxlength="20" class="form-control" name="fname" id="fname" value="<?php echo $cusinfo['FirstName']; ?>">
					</div>
					
					<div class="form-group col-md-5 col-md-offset-0 customer">  
				    	<label for='lname'>Last Name:</label>
						<input type="text" maxlength="20" class="form-control" name="lname" id="lname" value="<?php echo $cusinfo['LastName']; ?>">
					</div>
					
				    <div class="form-group col-md-5 col-md-offset-0 customer">  
				    	<label for='username'>Username:</label>
						<input type="text" class="form-control" name="username" id='username' value="<?php echo $cusinfo['username']; ?>" disabled>
					</div>			    	
					
				    <div class="form-group col-md-5 col-md-offset-0 customer">  
				    	<label for='phone'>Phone Number:</label>
						<input type="text" maxlength="13" class="form-control" name="phone" id='phone' value="<?php echo $cusinfo['tel']; ?>">
					</div>
					
					<div class="form-group col-md-5 col-md-offset-0 customer">  
				    	<label for='address'>Address:</label>
						<input type="text" maxlength="40" class="form-control" name="address" id='address' value="<?php echo $cusinfo['address']; ?>">
					</div>
                    
                    <div class="form-group col-md-5 col-md-offset-0 customer">  
				    	<label for='sex'>Gender:</label>
                        <div class="form-control">
                        <td>
				            <label>Male<input type='radio' name='sex' value=1/></label> 
				            <label>Female<input type='radio' name='sex' value=2/></label> 
				            <label>Unknown<input type='radio' name='sex' value=0 checked/></label>
			             </td>
                        </div>
					</div>
					
					<div class="col-md-12 col-md-offset-10 customer">			
				    	<input type="submit" value="Submit" class="btn btn-danger">  
					</div>
				</form>
				
				<div class="col-md-12 customer">
					<hr>
					<h3>Update Password</h3>
				</div>
				<?php
				if (isset ($_POST['password'])){
					$oldpwd = inputCheck($_POST['password']);
					$res_pwd = $mysql->fetch($mysql->query("SELECT pwdhash,salt FROM customer WHERE id = '{$_SESSION['customer_id']}'"));
					$oldpwdhash = MD5($oldpwd.$res_pwd['salt']);
					if($oldpwdhash == $res_pwd['pwdhash']){
						if($_POST['newpassword']==$_POST['newpasswordagain']){
							$newpwdhash = MD5($_POST['newpassword'].$res_pwd['salt']);
							if($newpwdhash==$oldpwdhash){
								echo "<script>$('#myprofile').click();
									$('[name=\"pwd\"').addClass('alert-danger');
									$('[name=\"pwd\"').focus();
									alert('New Password Cannot be same as the original one!');
								</script>";
							}else{
								$sql_newPwd = "UPDATE customer SET pwdhash = '$newpwdhash' WHERE id = '{$_SESSION['customer_id']}'";
								$mysql->query($sql_newPwd);
								unset($_SESSION['customer_name']);
								unset($_SESSION['customer_id']);
								redirect('login.php','Change Password Successfully!\\nPlease Log in again!');
							}
						}else{
							echo "<script>alert('Password Not Same')</script>";
						}
					}else{
						echo "<script>$('#myprofile').click();
							$('[name=\"oldpwd\"').addClass('alert-danger');
							$('[name=\"oldpwd\"').focus();
							alert('Wrong Password');
							alert('$oldpwd');
						</script>";
					}
				}
				?>
				<form method="post">
			    	<div class="form-group col-md-5 col-md-offset-0 customer">  
			   		 	<label for='password'>Password:</label>
						<input type="text" class="form-control" name="password" id='password' placeholder="Your Old Password">
					</div>
			    	<div class="form-group col-md-5 col-md-offset-0 customer">  
			   		 	<label for='newpassword'>New Password:</label>
						<input type="text" class="form-control" name="newpassword" id='newpassword' placeholder="New Password">
					</div>
			    	<div class="form-group col-md-5 col-md-offset-0 customer">  
			   		 	<label for='newpasswordagain'>New Password Again:</label>
						<input type="text" class="form-control" name="newpasswordagain" id='newpasswordagain' placeholder="New Password Again">
					</div>
					<div class="col-md-12 col-md-offset-10 customer">			
				    	<input type="submit" value="Submit" class="btn btn-danger">  
					</div>
				</form>
				<div class="col-md-12 customer"><hr>
					<h3>Update Car Information</h3>
				</div>
				<?php
				$sql_cuscarid = "SELECT * FROM car WHERE cus_id ='".$_SESSION['customer_id']."'";
				$result_cuscarid = $mysql->query($sql_cuscarid);
				$rows = mysql_num_rows($result_cuscarid);
				$num = 0;
				while ($row_carinfo = $mysql->fetch($result_cuscarid)) {
					$num ++;
				?>
					<form method="post">
						<div class="col-md-4 customer">
						<h4>Car Information<?php echo $num;?></h4>
				   	 		<div class="form-group  col-md-offset-0 customer">  
				   			 	<label for='plate'>Plate Number:</label>
								<input type="text" class="form-control" name="plate<?php echo $num;?>" id='plate' value="<?php echo $row_carinfo['plate']; ?>">
								<input type="hidden" name="id<?php echo $num;?>" value="<?php echo $row_carinfo['id']; ?>">
							</div>
					
				    		<div class="form-group  col-md-offset-0 customer">  
				   			 	<label for='colol'>Color:</label>
								<input type="text" class="form-control" name="color<?php echo $num;?>" id='color' value="<?php echo $row_carinfo['color']; ?>">
								<input type="hidden" name="id<?php echo $num;?>" value="<?php echo $row_carinfo['id']; ?>">
							</div>
							
				    		<div class="form-group  col-md-offset-0 customer">  
				   			 	<label for='type'>Type:</label>
								<input type="text" class="form-control" name="type<?php echo $num;?>" id='type' value="<?php echo $row_carinfo['brand']; ?>">
								<input type="hidden" name="id<?php echo $num;?>" value="<?php echo $row_carinfo['id']; ?>">
							</div>
						</div>
					<?php
				}
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
						$sql_updatecar1 = "UPDATE car SET plate = '$plate1', brand = '$type1', color = '$color1' WHERE id = '$id1'";
						$result_updatecar1 = $mysql->query($sql_updatecar1);
						$sql_updatecar2 = "UPDATE car SET plate = '$plate2', brand = '$type2', color = '$color2' WHERE id = '$id2'";
						$result_updatecar2 = $mysql->query($sql_updatecar2);
						$sql_updatecar3 = "UPDATE car SET plate = '$plate3', brand = '$type3', color = '$color3' WHERE id = '$id3'";
						$result_updatecar3 = $mysql->query($sql_updatecar3);
						
						echo"<script type='text/javascript'>alert('Update Success'); location='index.php?page=customer';</script>";
				}
					?>
						<div class="col-md-12 col-md-offset-10">
				    		<input type="submit" value="Submit" class="btn btn-danger">  
						</div>
				  </form>
		</div>        
	</div>