<!-- This page used to the customer login -->
<?php
	//Start the session
	session_start();
	//Connect database
	require "inc/db.php";
	include "inc/header.php";
	if(isset($_SERVER['HTTP_REFERER'])){
		$lastpage = explode('CWMS/',$_SERVER['HTTP_REFERER'])[1]; // get previous page name
		if(isset($_SESSION['gotopage'])){ // if already set the session
			if($lastpage!='login.php'&&$lastpage!='login.php?new'){ //rewrite previous page in the session only if it's not about login page
				$_SESSION['gotopage'] = $lastpage;
			}
		}else{ // if it's the first time, set the previous page in session
			$_SESSION['gotopage'] = $lastpage;
		}
	}else{
		$_SESSION['gotopage'] = 'index.php'; //Directly type url: /login.php
	}
 	if(isset($_GET['new'])){
		$action = 'sign';
	 }else{
		 $action = 'login';
	 }
 	if($action == 'login'){
?>
	    <div class="col-md-8 col-md-offset-2" style="margin-bottom:250px;">
	        <div class="col-xs-12 login" style="margin-top: 40px;">	
					<h1 class='text-center'>PLEASE LOGIN</h1>
						<form method="post" class='col-md-6 col-md-offset-3'> 
							<!-- input the user name -->
							<div class="form-group centerbox">
								<label for='username'>Username:</label>
								<input type="text" name="username" class="form-control" placeholder='cus1'>  
							</div> 
							<!-- input the password -->
							<div class="form-group">
								<label for='password'>Password:</label>
								<input type="password" name="password" class="form-control" placeholder='1234'>  
							</div>
							<button type="button" onclick='location.href="login.php?new"' class="btn btn-primary">Sign Up</button>
							<button type="submit" class="btn btn-org">Sign In</button>  
							<button type="button" onclick='location.href="index.php?new"' class="btn btn-primary">Back</button>
					 	</form>
			</div>
		</div>
</body>
		<!-- This page used to check the username & password -->
	<?php  
		// get username & password
		if(isset($_POST['username'])&&isset($_POST['password'])){
			$username = strtolower(inputCheck($_POST['username'])); 
			$pwd = inputCheck($_POST['password']);
			if(empty($username)){    
				// check vaule
				echo"<script type='text/javascript'>alert('Empty Username');location='login.php';  
					</script>";            
			}else if(empty($pwd)){
				// check vaule
				echo"<script type='text/javascript'>alert('Empty Password');location='login.php';</script>";  
			}else{   
				$res_pwd = $mysql->query("SELECT id,username,pwdhash,salt FROM customer WHERE username = '$username'"); 
				$cusInfo = $mysql->fetch($res_pwd);
				$pwdhash = MD5($pwd.$cusInfo['salt']);
				if(mysql_num_rows($res_pwd)){
					$rightpwd = $cusInfo['pwdhash'];
					if($pwdhash == $rightpwd){
						$_SESSION['customer_name'] = $cusInfo['username'];
						$_SESSION['customer_id'] = $cusInfo['id'];
						echo "<script>$('[name=\"username\"').addClass('alert-success');$('[name=\"password\"').addClass('alert-success');</script>";
						redirect($_SESSION['gotopage']);
					}else{
						echo "<script>$('[name=\"username\"').addClass('alert-success')
							$('[name=\"password\"').addClass('alert-danger')
							$('[name=\"username\"').val('$username')
							alert('Wrong Password');$('[name=\"password\"').focus();
						</script>";
					}
				}else{
					echo "<script>$('[name=\"username\"').addClass('alert-danger');$('[name=\"username\"').focus();alert('Username not found')</script>";
				}	  
			}          
		}  
	?>  
<?php		
	}else if($action=='sign'){
?> 
<?php  
if (isset ($_POST['fname'])) {
	$fname = inputCheck($_POST['fname']);
	$lname = inputCheck($_POST['lname']);
	$username = inputCheck($_POST['username']);
	$password = inputCheck($_POST['password']);
	$passwordagain = inputCheck($_POST['passwordagain']);
	$phone = inputCheck($_POST['phone']);	
	$address = inputCheck($_POST['address']);	
	$sex = inputCheck($_POST['sex']);	

	if($username==""|| $password=="" || $phone=="" || $passwordagain=="") {  
		echo"<script type='text/javascript'>alert('write all the information');location='login.php?new';  
            </script>";
			if ($password!=$passwardagain){
				echo"<script type='text/javascript'>alert('write same password');location='login.php?new';  
		            </script>";
				}
	} else {  
	    $sql = "SELECT * FROM customer WHERE username = '$username'";
	    $query = $mysql->query("$sql");
	    $rows = mysql_num_rows($query);
	        if ($rows ==1){
			echo"<script type='text/javascript'>alert('Username in Using');location='login.php?new';  
            </script>";
		      }else{
					if($password!=$passwordagain) {   
			        echo"<script type='text/javascript'>alert('Password Not Same');location='login.php?new';  
                        </script>"; 
					}else{
					$salt=base64_encode(mcrypt_create_iv(6,MCRYPT_DEV_RANDOM)); //Add random salt
					$pwdhash = MD5($password.$salt); //MD5 of pwd+salt
			        $sql_newcus = "INSERT INTO customer VALUES('','$username','$pwdhash','$salt','$fname','$lname','$sex','$phone','$address','0')"; 
			        $mysql->query($sql_newcus);
					echo"<script type='text/javascript'>alert('You Can Login Now');location='login.php';  </script>";  
			}
		}  
	}  
}
?>  
		 <div class="col-md-8 col-md-offset-2" style="margin-bottom:250px;">
	        <div class="col-xs-12 login" style="margin-top: 40px;">	
				<h1 class="text-center">Sign Up</h1>  
				<form method='post' class='col-md-10 col-md-offset-1'>
				    <div class="form-group col-md-6">  
				    	<label for='fname'>First Name:</label>
						<input type="text" class="form-control" name="fname" id='fname' placeholder="First Name" required>
					</div>
					
				    <div class="form-group col-md-6">  
				    	<label for='fname'>Last Name:</label>
						<input type="text" class="form-control" name="lname" id='lname' placeholder="Last Name" required>
					</div>
					
				    <div class="form-group col-md-6">  
				    	<label for='username'>Username:</label>
						<input type="text" class="form-control" name="username" id='username' placeholder="Make a User Name" required>
					</div>
					
			    	<div class="form-group col-md-6">  
			   		 	<label for='password'>Password:</label>
						<input type="password" class="form-control" name="password" id='password' placeholder="Your Password" required>
					</div>
					
				    <div class="form-group col-md-6">  
				   	 	<label for='passwordagain'>Password Again:</label>
						<input type="password" class="form-control" name="passwordagain" id='passwordagain'placeholder="Password Again" required>
					</div>
					
				    <div class="form-group col-md-6">  
				    	<label for='phone'>Phone Number:</label>
						<input type="text" class="form-control" name="phone" id='phone' placeholder="Your Phone Number" required>
					</div>

					<div class="form-group col-md-6">  
				    	<label for='address'>Address:</label>
						<input type="text" class="form-control" name="address" id='address' placeholder="Address" required>
					</div>
					
					<div class="form-group col-md-6">  
				    	<label for='sex'>Sex:</label>
						<select class="form-control" name="sex" id='sex' required>
							<option value='0'>Unknown</option>
							<option value='1'>Male</option>
							<option value='2'>Female</option>
						</select>
					</div>
					<div class="col-xs-12">
				    	<a href="login.php" class="btn btn-primary" >Back</a>
				    	<input type="submit" value="Submit" class="btn btn-danger">  
				   	 	<input type="reset" value="Reset" class="btn btn-primary">
					</div>
				</form>
        	</div>        
    	</div>
	<?php
}
	include "inc/footer.php";
	?>
