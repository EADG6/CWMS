<?php
	session_start();
	require "inc/db.php";
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
?>