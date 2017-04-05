<?php
	session_start();
	require("../inc/db.php");
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
		redirect('index.php?exit','Sign up Successfully, But your account is not validated,\\n so you cannot management function\\n until super administrator give you permission!');
	}
	if ($page == 'default') {
		include "app/orders_block.php";
	} else if ($page == 'product') {
		include "app/product.php";
	}else if ($page == 'customer') {
		include "app/customer.php";
	}else if ($page == 'current_orders') {
		include "app/orders_block.php";
	}else if ($page == 'create_order') {
		include "app/create_order.php";
	}else if($page == 'recharge'){
		include "app/recharge.php";
	}else if($page == 'payment'){
		include "app/payment.php";
	}else if($page == 'rechlog'){
		include "app/rechlog.php";
	}else if($page == 'staff'){
		include "app/staff.php";
	}else if($page == 'profile'){
		include "app/profile.php";
	}else if($page == 'report'){
		include "app/report.php";
	}
	include("inc/footer.php");

?>