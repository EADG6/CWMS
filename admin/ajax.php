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
		$timecond = isset($_POST['timecond'])?mysql_real_escape_string($_POST['timecond']):'';
		if($_POST['diagram']=='soldProp'){
			$sql_soldProp = "SELECT pss.product_name,SUM(quantity) AS quan,SUM(quantity*ps.price) AS price FROM order_product AS op INNER JOIN orders AS o ON o.id=op.order_id JOIN product_service AS ps ON op.product_id=ps.id RIGHT JOIN product_service AS pss ON pss.id=ps.type_id $timecond GROUP BY ps.type_id";
			$res_soldProp = $mysql->query($sql_soldProp);
			if(mysql_num_rows($res_soldProp)==0){
				echo json_encode(['status'=>'empty']);
				return false;
			}
			$soldProp_data = ['labels'=>[],'quan'=>[],'price'=>[]];
			while($row = $mysql->fetch($res_soldProp)){
				$row['quan'] = empty($row['quan'])?0:$row['quan'];
				$row['price'] = empty($row['price'])?0:$row['price'];
				array_push($soldProp_data['labels'],$row['product_name']);
				array_push($soldProp_data['quan'],$row['quan']);
				array_push($soldProp_data['price'],$row['price']);
			}
			$soldProp_data['status']=0;
			echo json_encode($soldProp_data);
		}else if($_POST['diagram']=='ordTrend'){
			$timetype = ($_POST['timetype']=='min')? 'Time':'Date';
			$soldtrend_data =['totord'=>[],'totquan'=>[],'date'=>[],'labels'=>[]];
			$sql_totquan = "SELECT totord,SUM(quantity) AS totquan,o.$timetype FROM order_product AS op JOIN orders AS o ON o.id=op.order_id JOIN (SELECT COUNT(*) AS totord,$timetype AS ".$timetype."1 FROM orders GROUP BY $timetype ORDER by $timetype) AS t ON t.".$timetype."1=o.$timetype $timecond GROUP BY o.$timetype ORDER BY o.$timetype;";
			$res_totquan = $mysql->query($sql_totquan);
			if(mysql_num_rows($res_totquan)==0){
				echo json_encode(['status'=>'empty']);
				return false;
			}
			while($row_totquan = $mysql->fetch($res_totquan)){
				array_push($soldtrend_data['totord'],$row_totquan['totord']);
				array_push($soldtrend_data['totquan'],$row_totquan['totquan']);
				array_push($soldtrend_data['date'],$row_totquan[$timetype]);
			}
			$res_prodTypes = $mysql->query("SELECT id,product_name FROM product_service WHERE type_id=id");
			while($row_types = $mysql->fetch($res_prodTypes)){
				array_push($soldtrend_data['labels'],$row_types['product_name']);
				$soldtrend_data[$row_types['product_name']]=[];
				$sql_typequan = "SELECT SUM(quantity) AS quan,o.$timetype FROM order_product AS op JOIN orders AS o ON o.id=op.order_id JOIN product_service AS ps ON op.product_id=ps.id $timecond AND ps.type_id=".$row_types['id']." GROUP BY O.$timetype";
				$res_typequan = $mysql->query($sql_typequan);
				while($row_typequan = $mysql->fetch($res_typequan)){
					$soldtrend_data[$row_types['product_name']][$row_typequan[$timetype]] = $row_typequan['quan'];
				}
				for($i=0;$i<count($soldtrend_data['date']);$i++){
					if(!array_key_exists($soldtrend_data['date'][$i],$soldtrend_data[$row_types['product_name']])){
						$soldtrend_data[$row_types['product_name']][$soldtrend_data['date'][$i]] = 0;
					}
				}
				ksort($soldtrend_data[$row_types['product_name']]);
				$soldtrend_data[$row_types['product_name']] = array_values($soldtrend_data[$row_types['product_name']]);
			}
			$soldtrend_data['status']=0;
			echo json_encode($soldtrend_data);
	 	}
	}
?>