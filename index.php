<?php
	 //Start the session
	 session_start();
	 //Make sure login
	 if (isset($_SESSION['customer_username'])){
	 } else {
		 //Ask login
	 	 echo"<script type='text/javascript'>alert('Please Login First');location='login.php';</script>";
		 }
	 //Connect database
	 require "inc/db.php";
	 include "inc/header.php";
	 include "inc/nav.php";
	 if(isset($_GET['page'])){
		$page = $_GET['page'];
	 }else{
		$page = 'home'; //If can't get page go to index.php
	 }
	 if(isset($_GET['logout'])){
		unset($_SESSION['userid']);
		unset($_SESSION['customer_username']);
		unset($_SESSION['customer_name']);
		session_destroy();
		echo "<script>location.href='login.php'</script>";
		//redirect('login.php');
	 }
	 //show all the page's location
	 if($page=='home'){
		include "app/home.php";
	}else if($page=='services'){
		include "app/services.php";
	}else if($page=='order'){
		include "app/order.php";
	}else if($page=='news'){
		include "app/news.php";
	}else if($page=='addorder'){
		include "app/addorder.php";
	}
	include "inc/footer.php";
?>