<?php
	session_start();
	require "../inc/db.php";
	/**Check if username have been used when sign up*/
	if(isset($_POST['usercheck'])){
		$usercheck = inputCheck(strtolower(preg_replace("/\s/","",$_POST['usercheck'])));
		if(empty($usercheck)){
			$isNameUsed= 'empty';
		}else{
			$querytable = $_POST['page']=='cus'? 'customer':'employee';
			$res = $mysql->query("SELECT id FROM $querytable WHERE username = '$usercheck'");
			$isNameUsed = mysql_num_rows($res)? 'used':'ok';
		}
		$resp = ['used'=>$isNameUsed];
		echo json_encode($resp);
	}
	/**function of rate order*/
	if(isset($_POST['rate'])){
		$rateLevel = inputCheck($_POST['rate']);
		$rateordid = inputCheck($_POST['orderid']);
		$sql_rateOrd = "UPDATE orders SET rate = '$rateLevel' WHERE id = '$rateordid'";
		$mysql->query($sql_rateOrd);
	}
	/**Change order status*/
	if(isset($_POST['status'])){
		$status = inputCheck($_POST['status']);
		$orderid = inputCheck($_POST['orderid']);
		$sql_statusOrd = "UPDATE orders SET status = '$status' WHERE id = '$orderid'";
		$mysql->query($sql_statusOrd);
	}
	/**Query customer's cars*/
	if(isset($_POST['cusid'])){
		$cusid = inputCheck($_POST['cusid']);
		$sql_queryCars = "SELECT id,CONCAT(plate,' ',brand,' ',color) AS carinfo FROM car WHERE cus_id = $cusid";
		$res_cars = $mysql->query($sql_queryCars);
		if(mysql_num_rows($res_cars)){
			$i = 0;
			$carinfo['status'] = mysql_num_rows($res_cars);
			while($row = $mysql->fetch($res_cars)){
				$i++;
				$carinfo['car'.$i] = ['id'=>$row['id'],'carinfo'=>$row['carinfo']];
			}
			echo json_encode($carinfo);
		}else{
			echo json_encode(['status'=>0]);
		}
	}
?>