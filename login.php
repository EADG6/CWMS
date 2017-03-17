<!-- This page used to the customer login -->
<?php
	 //Start the session
	 session_start();
	 //Connect database
	 require "inc/db.php";
	 include "inc/header.php";
 	if(isset($_GET['new'])){
		$action = 'sign';
	 }else{
		 $action = 'login';
	 }
 	if($action == 'login'){
?>
	    <div class="container">
	        <hr>
	        <div class="row">
					<h1>PLEASE LOGIN</h1>
					<br> </br>
						<form method="post">  
							<!-- input the user name -->
		        			<h4>Usename:</h4>
							<div class="form-group col-md-offset-0">
							<input type="text" name="username" class="form-control" style="width: 200px">  
							</div> 
							<!-- input the password -->
		        			<h4>Password:</h4>
							<div class="form-group col-md-offset-0">
							<input type="password" name="password" class="form-control" style="width: 200px">  
							</div>
							<a href="login.php?new" class="btn btn-primary">Sign Up</a>&nbsp;&nbsp;
		       			 <input type="submit" value="Sign In" class="btn btn-primary">  
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
				echo"<script type='text/javascript'>alert('Empty Username');location='index.php?page=login';  
					</script>";            
			}else if(empty($password)){
				// check vaule
				echo"<script type='text/javascript'>alert('Empty Password');location='index.php?page=login';</script>";  
			}else{   
				// select information from database
				$sql = "SELECT * FROM customer WHERE password = '$password' AND username = '$username'";
				$query = mysql_query("$sql");
				$cusinfo = mysql_fetch_array($query);
				$id = $cusinfo['id'];
				$rows = mysql_num_rows($query);
				$row = mysql_fetch_array($query);
				// check u & p
				if ($rows ==1){
					session_start();
					$_SESSION['customer_id']= $id;
					$_SESSION['customer_username']= $username;
					//Say right and go to home2 page
					echo"<script type='text/javascript'>alert('ok');</script>"; 
					header("location: index.php");		
				}else{					
					//Say wrong and go back to login page 
					echo"<script type='text/javascript'>alert('Wrong User Name or Password');location='login.php';</script>";
				}   
			}          
		}  
		include "inc/footer.php";
	?>  
<?php		
	}else if($action=='sign'){
?> 
<?php  
require "inc/db.php";
if (isset ($_POST['name']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['passwordagain']) && isset($_POST['phone']) && isset($_POST['plate1']) && isset($_POST['color1']) && isset($_POST['type1']) && isset($_POST['plate2']) && isset($_POST['color2']) && isset($_POST['type2']) && isset($_POST['plate3']) && isset($_POST['color3']) && isset($_POST['type3'])) {
	$name = $_POST['name'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$passwordagain = $_POST['passwordagain'];
	$phone = $_POST['phone'];
	$plate1 = $_POST['plate1'];
	$color1 = $_POST['color1'];
	$type1 = $_POST['type1'];
	$plate2 = $_POST['plate2'];
	$color2 = $_POST['color2'];
	$type2 = $_POST['type2'];
	$plate3 = $_POST['plate3'];
	$color3 = $_POST['color3'];
	$type3 = $_POST['type3'];	

	if($username==""|| $password=="" || $name=="" || $phone=="" || $passwordagain=="") {  
		echo"<script type='text/javascript'>alert('write all the information');location='login.php?new';  
            </script>";
			if ($passwoed!=$passwardagain){
				echo"<script type='text/javascript'>alert('write same password');location='login.php?new';  
		            </script>";
				}
	} else {  
	    $sql = "SELECT * FROM customer WHERE username = '$username'";
	    $query = mysql_query("$sql");
	    $rows = mysql_num_rows($query);
	
	        if ($rows ==1){
			echo"<script type='text/javascript'>alert('Username in Use');location='login.php?new';  
            </script>";
		      }else{
		         if($password!=$passwordagain) {   
			       echo"<script type='text/javascript'>alert('Password Not Same');location='login.php?new';  
                        </script>"; 
                  } else { 
			          $sql_newcus = "INSERT INTO customer (name,username,password,phone) VALUES('$name','$username','$password','$phone')"; 
					  $sql_newcar1 = "INSERT INTO car (plate,color,type) VALUES('$plate1','$color1','$type1')";
					  $sql_newcar2 = "INSERT INTO car (plate,color,type) VALUES('$plate2','$color2','$type2')";
					  $sql_newcar3 = "INSERT INTO car (plate,color,type) VALUES('$plate3','$color3','$type3')";
			          mysql_query($sql_newcus);
					  $customerid = mysql_insert_id();
					  mysql_query($sql_newcar1);
					  $carid1 = mysql_insert_id();
					  mysql_query($sql_newcar2);
					  $carid2 = mysql_insert_id();
					  mysql_query($sql_newcar3);
					  $carid3 = mysql_insert_id(); 
					  $sql_cuscar1 = "INSERT INTO customercar (customerid, carid) VALUES('$customerid','$carid1')";
					  $sql_cuscar2 = "INSERT INTO customercar (customerid, carid) VALUES('$customerid','$carid2')";
					  $sql_cuscar3 = "INSERT INTO customercar (customerid, carid) VALUES('$customerid','$carid3')";
					  mysql_query($sql_cuscar1);
					  mysql_query($sql_cuscar2);
					  mysql_query($sql_cuscar3);	 
				echo"<script type='text/javascript'>alert('You Can Login Now');location='login.php';  
           	 </script>";  
			}
		}  
	}  
}
?>  
 	<hr>
    <div class="container">
        <div class="row">
				<h1>Please Enter Your Information</h1>  
				<form method='post'>
				    <div class="form-group col-md-5 col-md-offset-0">  
				    	<label for='name'>Name:</label>
						<input type="text" class="form-control" name="name" id='name'>
					</div>
					
				    <div class="form-group col-md-5 col-md-offset-0">  
				    	<label for='username'>Username:</label>
						<input type="text" class="form-control" name="username" id='username'>
					</div>
					
			    	<div class="form-group col-md-5 col-md-offset-0">  
			   		 	<label for='password'>Password:</label>
						<input type="text" class="form-control" name="password" id='password'>
					</div>
					
				    <div class="form-group col-md-5 col-md-offset-0">  
				   	 	<label for='passwordagain'>Password Again:</label>
						<input type="text" class="form-control" name="passwordagain" id='passwordagain'>
					</div>
					
				    <div class="form-group col-md-5 col-md-offset-0">  
				    	<label for='phone'>Phone Number:</label>
						<input type="text" class="form-control" name="phone" id='phone'>
					</div>
					<div class="col-md-12">
						<hr>
						<h3>Vehicle information can choose to fill</h3>
					</div>
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
					<div class="col-md-12">
						<hr>
					</div>
					<div class="col-md-12 col-md-offset-10">
				    	<a href="login.php" class="btn btn-primary" >Back</a>
				    	<input type="submit" value="Submit" class="btn btn-primary">  
				   	 	<input type="reset" value="Delete" class="btn btn-primary">
					</div>
				</form>
        		</div>        
    		</div>
	<?php
	include "inc/footer.php";
}
	?>

