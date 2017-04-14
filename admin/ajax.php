<?php
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
			$sql_soldProp = "SELECT pss.product_name,SUM(quantity) AS quan,SUM(quantity*ps.price) AS price FROM order_product AS op INNER JOIN orders AS o ON o.id=op.order_id JOIN product_service AS ps ON op.product_id=ps.id RIGHT JOIN product_service AS pss ON pss.id=ps.type_id $timecond GROUP BY pss.type_id";
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
	 	}else if($_POST['diagram']=='finanTrend'){
			$sql_revenues = "SELECT SUM(ps.price*op.quantity) AS revenues,o.Date FROM order_product AS op JOIN product_service AS ps ON op.product_id = ps.id JOIN orders AS o ON o.id=op.order_id GROUP BY o.Date";
			$res_rev = $mysql->query($sql_revenues);
			$revAry = ['reve'=>[],'rech'=>[],'pay'=>[]];
			while($row_rev = $mysql->fetch($res_rev)){
				array_push($revAry['reve'],['x'=>$row_rev['Date'],'y'=>$row_rev['revenues']]);
			}
			$sql_recharge = "SELECT Date(datetime) AS date,SUM(price) AS price FROM recharge GROUP BY date";
			$res_rech = $mysql->query($sql_recharge);
			while($row_rech = $mysql->fetch($res_rech)){
				array_push($revAry['rech'],['x'=>$row_rech['date'],'y'=>$row_rech['price']]);
			}
			$sql_payments = "SELECT DATE(pay_time) AS date,SUM(price) AS price FROM payment GROUP BY date";
			$res_pay = $mysql->query($sql_payments);
			while($row_pay = $mysql->fetch($res_pay)){
				array_push($revAry['pay'],['x'=>$row_pay['date'],'y'=>$row_pay['price']]);
			}
			echo json_encode($revAry);
		}else if($_POST['diagram']=='ordSta'){
			$ordsta = ['labels'=>[],'quan'=>[]];
			$sql_ordstatus = "SELECT os.status,COUNT(o.status) AS quan FROM orders AS o JOIN order_status AS os ON os.id=o.status GROUP BY o.status";
			$res_ordstatus = $mysql->query($sql_ordstatus);
			while($row_ordsta = $mysql->fetch($res_ordstatus)){
				array_push($ordsta['labels'],$row_ordsta['status']);
				array_push($ordsta['quan'],$row_ordsta['quan']);
			}
			echo json_encode($ordsta);
		}else if($_POST['diagram']=='cusTransac'){
			$custransac = [];
			$sql_custrans = "SELECT SUM(balance) AS data FROM customer UNION ALL SELECT SUM(price) FROM recharge UNION ALL SELECT SUM(price) FROM payment";
			$res_custra = $mysql->query($sql_custrans);
			while($row_custra = $mysql->fetch($res_custra)){
				array_push($custransac,$row_custra['data']);//0=>balance,1=>recharge,2=>payment
			}
			echo json_encode($custransac);
		}
		else if($_POST['diagram']=='paytype'){
			$paytypeAry = array('labels'=>[],'recharge'=>[],'payment'=>[]);
			$sql_paytype = "SELECT type FROM pay_type ORDER BY id";
			$res_paytype = $mysql->query($sql_paytype);
			while($row_paytype = $mysql->fetch($res_paytype)){
				array_push($paytypeAry['labels'],$row_paytype['type']);
			}
			$sql_recharge = "SELECT SUM(price) AS amount FROM recharge AS p RIGHT JOIN pay_type AS pt ON p.pay_type_id=pt.id GROUP BY pt.id ORDER BY pt.id";
			$res_recharge = $mysql->query($sql_recharge);
			while($row_rech = $mysql->fetch($res_recharge)){
				array_push($paytypeAry['recharge'],$row_rech['amount']);
			}
			$sql_payments = "SELECT SUM(price) AS amount FROM payment AS p RIGHT JOIN pay_type AS pt ON p.pay_type_id=pt.id GROUP BY pt.id ORDER BY pt.id";
			$res_pay = $mysql->query($sql_payments);
			while($row_pay = $mysql->fetch($res_pay)){
				array_push($paytypeAry['payment'],$row_pay['amount']);
			}
			echo json_encode($paytypeAry);
		}else if($_POST['diagram']=='cusUnknown'){
			$cusUnk = $mysql->oneQuery("SELECT COUNT(*) AS num FROM orders WHERE cus_id IS NULL");
			$cusKno = $mysql->oneQuery("SELECT COUNT(*) AS num FROM orders WHERE cus_id IS NOT NULL");
			echo json_encode([$cusUnk,$cusKno]);
		}else if($_POST['diagram']=='cusSex'){
			$cus_sex = [];
			$sql_cusSex = "SELECT COUNT(*) AS sex FROM customer GROUP BY sex ORDER BY sex DESC";
			$res = $mysql->query($sql_cusSex);
			while($row = $mysql->fetch($res)){
				array_push($cus_sex,$row['sex']);
			}
			echo json_encode($cus_sex);
		}else if($_POST['diagram']=='cusAge'){
			$age_labels = array('0-25'=>0,'25-35'=>0,'35-45'=>0,'45-55'=>0,'55-65'=>0,'65-'=>0);
			$cus_age = array('male'=>$age_labels,'female'=>$age_labels,'unknown'=>$age_labels);
			$sql_age = "SELECT CASE WHEN temp.age <=24 THEN '0-25' 
				WHEN temp.age BETWEEN 25 AND 35 THEN '25-35' 
				WHEN temp.age BETWEEN 35 AND 45 THEN '35-45' 
				WHEN temp.age BETWEEN 45 AND 55 THEN '45-55' 
				WHEN temp.age BETWEEN 55 AND 65 THEN '55-65' 
				ELSE '65-' END AS agerange, 
				COUNT(male) AS malenum, COUNT(female) AS femalenum, COUNT(unknown) AS unknum FROM (
					SELECT YEAR(FROM_DAYS(DATEDIFF(now(),birth))) AS AGE,
						CASE WHEN sex=1 THEN sex END AS male,
						CASE WHEN sex=2 THEN sex END AS female, 
						CASE WHEN sex=3 THEN sex END AS unknown 
					FROM customer
				) AS temp 
			GROUP BY agerange ORDER BY agerange";
			$res = $mysql->query($sql_age);
			while($row = $mysql->fetch($res)){
				$cus_age['male'][$row['agerange']] = $row['malenum'];
				$cus_age['female'][$row['agerange']] = $row['femalenum'];
				$cus_age['unknown'][$row['agerange']] = $row['unknum'];
			}
			$cus_age['male']=array_values($cus_age['male']);
			$cus_age['female']=array_values($cus_age['female']);
			$cus_age['unknown']=array_values($cus_age['unknown']);
			echo json_encode($cus_age);
		}else if($_POST['diagram']=='carBind'){
			$cars_bind = array('0'=>0,'1'=>0,'2'=>0,'3'=>0);
			$sex_car = array('male'=>$cars_bind,'female'=>$cars_bind,'unknown'=>$cars_bind);
			$sql_cuscar = "SELECT cars,sex,COUNT(cars) AS num FROM (
			SELECT COUNT(car.id) AS cars,CASE WHEN sex=1 THEN 'male' WHEN sex=2 THEN 'female' WHEN sex=3 THEN 'unknown' END AS sex 
				FROM car INNER JOIN customer AS cus ON car.cus_id=cus.id WHERE plate !='' GROUP BY cus_id
			) AS temp GROUP BY cars,sex";
			$res = $mysql->query($sql_cuscar);
			while($row = $mysql->fetch($res)){
				$sex_car[$row['sex']][$row['cars']] = $row['num'];
			}
			echo json_encode($sex_car);
		}else if($_POST['diagram']=='sexBuy'){
			$sexbuy = array('balance'=>[],'recharge'=>[],'paid'=>[]);
			$sql_sexbuy = "SELECT g.sex,SUM(balance) AS balance,SUM(p.price) AS paid,SUM(r.price) AS recharge 
			FROM customer AS c INNER JOIN gender AS g ON c.sex=g.id LEFT JOIN payment AS p ON p.cus_id=c.id LEFT JOIN recharge AS r ON r.cus_id=c.id GROUP BY g.sex ORDER BY g.id";
			$res = $mysql->query($sql_sexbuy);
			while($row = $mysql->fetch($res)){
				array_push($sexbuy['balance'],$row['balance']);
				array_push($sexbuy['paid'],$row['paid']);
				array_push($sexbuy['recharge'],$row['recharge']);
			}
			echo json_encode($sexbuy);
		}else if($_POST['diagram']=='ageBuy'){
			$age_labels = array('0-25'=>0,'25-35'=>0,'35-45'=>0,'45-55'=>0,'55-65'=>0,'65-'=>0);
			$cus_agebuy = array('ageBal'=>$age_labels,'ageRec'=>$age_labels,'agePay'=>$age_labels);
			$sql_agebuy = "SELECT CASE WHEN temp.age <=24 THEN '0-25' 
				WHEN temp.age BETWEEN 25 AND 35 THEN '25-35' 
				WHEN temp.age BETWEEN 35 AND 45 THEN '35-45' 
				WHEN temp.age BETWEEN 45 AND 55 THEN '45-55' 
				WHEN temp.age BETWEEN 55 AND 65 THEN '55-65' 
				ELSE '65-' END AS agerange, 
				SUM(balance) AS balance,  SUM(recharges) AS recharges, SUM(payments) AS payments FROM (
					SELECT YEAR(FROM_DAYS(DATEDIFF(now(),birth))) AS age,balance,SUM(p.price*discount) AS payments,SUM(r.price) AS recharges 
						FROM customer AS c LEFT JOIN payment AS p ON p.cus_id=c.id LEFT JOIN recharge AS r ON r.cus_id=c.id GROUP BY age 
				) AS temp 
			GROUP BY agerange ORDER BY agerange";
			$res = $mysql->query($sql_agebuy);
			while($row = $mysql->fetch($res)){
				$cus_agebuy['ageBal'][$row['agerange']] = empty($row['balance'])? 0:round($row['balance'],2);
				$cus_agebuy['ageRec'][$row['agerange']] = empty($row['recharges'])? 0:round($row['recharges'],2);
				$cus_agebuy['agePay'][$row['agerange']] = empty($row['payments'])? 0:round($row['payments'],2);
			}
			$cus_agebuy['ageBal']=array_values($cus_agebuy['ageBal']);
			$cus_agebuy['ageRec']=array_values($cus_agebuy['ageRec']);
			$cus_agebuy['agePay']=array_values($cus_agebuy['agePay']);
			echo json_encode($cus_agebuy);
		}
	}
	/**product assoc function*/
	if(isset($_POST['minsup'])){
		include "inc/datarep.php";
		$sql_ordProducts = "SELECT od.order_id,p.product_name FROM order_product AS od INNER JOIN product_service AS p ON od.product_id=p.id INNER JOIN orders AS o ON o.id=od.order_id ORDER BY order_id";
		$result = $mysql->query($sql_ordProducts);
		$ordProducts = array();
		$ordID='';$ordNum=0;
		while($row = $mysql->fetch($result)){
			if($ordID!=$row['order_id']){
				array_push($ordProducts,[$row['product_name']]);
				$ordNum++;
				$ordID=$row['order_id'];
			}else{
				array_push($ordProducts[$ordNum-1],$row['product_name']);
			}
		}
		$staRes = new Report($ordProducts);
		$minsup = $_POST['minsup']/100;
		$res = array('cut'=>[],'empty'=>'');
		$cut2 = array();
		$cut3 = array();
		$cut2 = $staRes->aprior($minsup,2);
		$cut3 = $staRes->aprior($minsup,3);
		$res['cut'] = array_merge($cut2,$cut3);
		$isempty = count($res['cut'])==0 ? 1:0;
		$res['empty'] = $isempty;
		echo json_encode($res);
	}
?>