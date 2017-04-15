<?php
 class Mysql{
	function __construct(){
		$this->conn=$this->getConn();
	}
	function getConn(){
        $conn =  mysql_connect('localhost','root','0618') or die("Cannot connect to server".mysql_error());
        $db = mysql_select_db("carwashing",$conn);
		if(!$db){
			header("Location:install.php");
		}
        mysql_query("set names gbk");
        return $conn;
    }
	function fetch($result){
        $row = mysql_fetch_array($result);
        return $row;
    }
	function query($sql){
        $res = mysql_query($sql,$this->conn) or die(mysql_error());
		return $res;
	}
	function oneQuery($sql){	//Get one value from db
		return $this->fetch($this->query($sql))[0];
	}
}
$mysql = new Mysql();
	function inputCheck($input){	//prevent some of SQL injection and XSS attack
		$input=mysql_real_escape_string(htmlspecialchars(strip_tags($input)));
		return $input;
	}
	function redirect($url,$msg=''){	//redirect and alert
		if(empty($msg)){
			echo "<script>location.href='$url';</script>";
		}else{
			echo "<script>alert('$msg');location.href='$url';</script>";
		}
	}
?>