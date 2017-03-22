<?php
	session_start();
	require("inc/db.php");
	//error_reporting(E_ALL^E_NOTICE^E_WARNING^E_DEPRECATED);
	date_default_timezone_set('PRC'); 
	if(!isset($_SESSION['adminid'])){
		header("Location:login.php");
	}
	if(isset($_GET['exit'])){
		unset($_SESSION['admin']);
		unset($_SESSION['adminid']);
		session_destroy();
		header("Location:login.php");
	}
	if (isset($_GET['page'])) {
		$page = $_GET['page'];
	} else {
		$page = 'default';
	}
	include("inc/header.php");
	include("inc/nav.php");
	if($_SESSION['role']==4){
		echo "<script>alert('Your account is not validated,\\n so you cannot use more management function\\n until super administrator give you permission!')</script>";
	}
	if ($page == 'default') {
		include "orders_block.php";
	} else if ($page == 'product') {
		include "product.php";
	}else if ($page == 'customer') {
		include "customer.php";
	}else if ($page == 'current_orders') {
		include "orders_block.php";
	}else if ($page == 'create_order') {
		include "create_order.php";
	}else if($page == 'recharge'){
		include "recharge.php";
	}else if($page == 'payment'){
		include "payment.php";
	}else if($page == 'staff'){
		include "staff.php";
	}
	include("inc/footer.php");

?>