<?php  
//require('db.php');
if (isset ($_POST['name']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['passwordagain']) && isset($_POST['phone']) && isset($_POST['plate1']) && isset($_POST['color1']) && isset($_POST['type1']) && isset($_POST['plate2']) && isset($_POST['color2']) && isset($_POST['type2']) && isset($_POST['plate3']) && isset($_POST['color3']) && isset($_POST['type3'])) {
	$name = $_POST['name'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$passwordagain = $_POST['passwordagain'];
	$phone = $_POST['phone'];
	$plate1 = $_POST['plate1'];
	$color1 = $_POST['color1'];
	$type1 = $_POST['type1'];
	$plate2= $_POST['plate2'];
	$color2 = $_POST['color2'];
	$type2 = $_POST['type2'];
	$plate3 = $_POST['plate3'];
	$color3 = $_POST['color3'];
	$type3 = $_POST['type3'];	

	if($username==""|| $password=="" || $name=="" || $phone=="" || $passwordagain=="") {  
		echo"<script type='text/javascript'>alert('write all the information');location='register.php';  
            </script>";  
	} else {  
	    $sql = "SELECT * FROM customer WHERE username = '$username'";
	    $query = mysql_query("$sql");
	    $rows = mysql_num_rows($query);
	
	        if ($rows ==1){
			echo"<script type='text/javascript'>alert('Username in Use');location='register.php';  
            </script>";
		      }else{
		         if($password!=$passwordagain) {   
			       echo"<script type='text/javascript'>alert('Password Not Same');location='register.php';  
                        </script>"; 
                  } else { 
			          $sql = "INSERT INTO customer (name,username,password,phone,plate1,plate2,plate3,color1,color2,color3,type1,type2,type3) VALUES('$name','$username','$password','$phone','$plate1','$plate2','$plate3','$color1','$color2','$color3','$type1','$type2','$type3')"; 
			          $result=mysql_query($sql);  
			if(!$result) {  
				echo"<script type='text/javascript'>alert('Worn');location='register.php';  
            </script>";
			} else {  
				echo"<script type='text/javascript'>alert('You Can Login Know');location='login.php';  
            </script>";  
			}
		 }	
		}  
	}  
}
?>  
 	<hr>
    <div class="container">
        <div class="row">
				<h1>Please Enter Your Information</h1>  
				    <div class="form-group col-md-5 col-md-offset-0">  
				    	<label for='name'>Name:</label>
						<input type="text" class="form-control" name="name" id='name'>
					</div>
					
				    <div class="form-group col-md-5 col-md-offset-0">  
				    	<label for='name'>Username:</label>
						<input type="text" class="form-control" name="username" id='username'>
					</div>
					
			    	<div class="form-group col-md-5 col-md-offset-0">  
			   		 	<label for='name'>Password:</label>
						<input type="text" class="form-control" name="password" id='password'>
					</div>
					
				    <div class="form-group col-md-5 col-md-offset-0">  
				   	 	<label for='name'>Password Again:</label>
						<input type="text" class="form-control" name="passwordagain" id='passwordagain'>
					</div>
					
				    <div class="form-group col-md-5 col-md-offset-0">  
				    	<label for='name'>Phone Number:</label>
						<input type="text" class="form-control" name="phone" id='phone'>
					</div>
					<div class="col-md-12">
						<hr>
						<h3>Vehicle information can choose to fill</h3>
					</div>
						<div class="col-md-4">
						<h4>First Car</h4>
				   	 		<div class="form-group  col-md-offset-0">  
				   			 	<label for='name'>Plate Number 1:</label>
								<input type="text" class="form-control" name="plate1" id='plate1'>
							</div>
					
				    		<div class="form-group  col-md-offset-0">  
				   			 	<label for='name'>Color:</label>
								<input type="text" class="form-control" name="color1" id='color1'>
							</div>
							
				    		<div class="form-group  col-md-offset-0">  
				   			 	<label for='name'>Type:</label>
								<input type="text" class="form-control" name="type1" id='type1'>
							</div>
						</div>
					
						<div class="col-md-4">
						<h4>Second Car</h4>
				   	 		<div class="form-group col-md-offset-0">  
				   			 	<label for='name'>Plate Number 2:</label>
								<input type="text" class="form-control" name="plate2" id='plate2'>
							</div>
					
				    		<div class="form-group col-md-offset-0">  
				   			 	<label for='name'>Color:</label>
								<input type="text" class="form-control" name="color2" id='color2'>
							</div>
							
				    		<div class="form-group col-md-offset-0">  
				   			 	<label for='name'>Type:</label>
								<input type="text" class="form-control" name="type2" id='type2'>
							</div>
						</div>
						
						<div class="col-md-4">
						<h4>Third Car</h4>
				   	 		<div class="form-group col-md-offset-0">  
				   			 	<label for='name'>Plate Number 3:</label>
								<input type="text" class="form-control" name="plate3" id='plate3'>
							</div>
					
				    		<div class="form-group col-md-offset-0">  
				   			 	<label for='name'>Color:</label>
								<input type="text" class="form-control" name="color3" id='color3'>
							</div>
							
				    		<div class="form-group col-md-offset-0">  
				   			 	<label for='name'>Type:</label>
								<input type="text" class="form-control" name="type3" id='type3'>
							</div>
						</div>
					<div class="col-md-12">
						<hr>
					</div>
					<div class="col-md-12 col-md-offset-10">
				    	<a href="login.php" >Back</a>
				    	<input type="submit" value="ok">  
				   	 	<input type="reset" value="delete">
					</div>
        </div>
        <!-- /.row -->
        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
					<hr>
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
            </div>
            <!-- /.row -->
        </footer>
    </div>
	
