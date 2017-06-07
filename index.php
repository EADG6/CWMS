<?php
	 //Start the session
	 session_start();
	 date_default_timezone_set('PRC'); 
	 //Make sure login
	 if (!isset($_SESSION['customer_id'])){
		 	$_SESSION['customer_id'] = 0;
			$_SESSION['customer_name']= 'unknown';
			$_SESSION['customer_phone']= 'unknown';
			$_SESSION['customer_username']= 'unknown';
		 }
	 //Connect database
	 require "inc/db.php";
	 if(isset($_GET['page'])){
		$page = $_GET['page'];
	 }else{
		$page = 'home';
	 }
	 if(isset($_GET['logout'])){
		unset($_SESSION['customer_id']);
		session_destroy();
		header("Location:index.php");
		//redirect('login.php');
	 }
	 //show all the page's location
	 include "inc/header.php";
	 include "inc/nav.php";
	 if($page=='home'){
		include "app/home.php";
	}else if($page=='services'){
		include "app/services.php";
	}else if($page=='order'){
		include "app/order.php";
	}else if($page=='addorder'){
		include "app/addorder.php";
	}else if($page=='customer'){
		include "app/customer.php";
	}
	include "inc/footer.php";
?>