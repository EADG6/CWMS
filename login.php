<!-- This page used to the customer login -->
    <div class="container">
        <hr>
        <div class="row">
				<h1>PLEASE LOGIN</h1>
				<br> </br>
					<form method="post">  
						<!-- input the user name -->
	        			<h4>Usename:</h4><br></br><input type="text" name="username" >  
						<br> </br> 
						<!-- input the password -->
	        			<h4>Password:</h4><br></br><input type="password" name="password">  
						<br> </br>
						<hr>
						<a href="index.php">Back To Home</a>&nbsp;&nbsp;
						<a href="index.php?page=sign">Sign Up</a>&nbsp;&nbsp;
	       			 <input type="submit" value="ok">  
				 	</form>
		</div>
	</div>
	<!-- This page used to check the username & password -->
<?php  
	//require('db.php');
	// get username & password
	if(isset($_POST['username'])&&isset($_POST['password'])){
		$username = $_POST['username'];  
		$password = $_POST['password']; 
		if(empty($username)){    
			// check vaule
			echo"<script type='text/javascript'>alert('Empty User Name');location='index.php?page=login';  
				</script>";            
		}else if(empty($password)){
			// check vaule
			echo"<script type='text/javascript'>alert('Empty Pass Word');location='index.php?page=login';</script>";  
		}else{   
			// select information from database
			$sql = "SELECT * FROM customer WHERE password = '$password' AND username = '$username'";
			echo $sql;
			$query = mysql_query("$sql");
			$rows = mysql_num_rows($query);
			$row = mysql_fetch_array($query);
			// check u & p
			if ($rows ==1){
				session_start();
				$_SESSION['userid']= $row{'id'};
				$_SESSION['customer_username']= $username;
				$_SESSION['customer_name']= $row{'name'};
				//Say right and go to home2 page
				echo"<script type='text/javascript'>alert('ok');</script>"; 
				header("location: index.php");		
			}else{
				//Say worn and go back to login page 
				echo"<script type='text/javascript'>alert('Worn User Name or Password');location='index.php?page=login';</script>";
			}     
		}          
	}  
?>  
