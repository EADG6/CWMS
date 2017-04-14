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
	 include "inc/header.php";
	 include "inc/nav.php";
	 if(isset($_GET['page'])){
		$page = $_GET['page'];
	 }else{
		$page = 'home'; //If can't get page go to index.php
	 }
	 if(isset($_GET['logout'])){
		unset($_SESSION['customer_id']);
		session_destroy();
		echo "<script>location.href='index.php'</script>";
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
	}else if($page=='customer'){
		include "app/customer.php";
	}
	include "inc/footer.php";
?>