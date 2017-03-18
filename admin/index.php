<?php
	session_start();
	//error_reporting(E_ALL^E_NOTICE^E_WARNING^E_DEPRECATED);
	date_default_timezone_set('PRC'); 
	require("inc/db.php");
	$_SESSION['userid']=1;
	if (isset($_GET['page'])) {
		$page = $_GET['page'];
	} else {
		$page = 'default';
	}
	include("inc/header.php");
	include("inc/nav.php");
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