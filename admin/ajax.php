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
	/**Data of product sold proportion diagram*/
	if(isset($_POST['diagram'])){
		$timecond = isset($_POST['timecond'])?inputCheck($_POST['timecond']):'';
		if($_POST['diagram']=='soldProp'){
			$sql_soldProp = "SELECT ps.product_name,SUM(quantity) AS quan,SUM(quantity*ps.price) AS price FROM order_product AS op INNER JOIN orders AS o ON o.id=op.order_id RIGHT JOIN product_service AS ps ON op.product_id=ps.id $timecond GROUP BY type_id";
			$res_soldProp = $mysql->query($sql_soldProp);
			$soldProp_data = ['labels'=>[],'quan'=>[],'price'=>[]];
			while($row = $mysql->fetch($res_soldProp)){
				$row['quan'] = empty($row['quan'])?0:$row['quan'];
				$row['price'] = empty($row['price'])?0:$row['price'];
				array_push($soldProp_data['labels'],$row['product_name']);
				array_push($soldProp_data['quan'],$row['quan']);
				array_push($soldProp_data['price'],$row['price']);
			}
			echo json_encode($soldProp_data);
		}
	}
?>