<?php
 class Mysql{
	function __construct(){
		$this->conn=$this->getConn();
	}
	function getConn(){
        $conn =  mysql_connect('localhost','root','0618') or die("Cannot connect to server".mysql_error());
        mysql_select_db("carwashing",$conn) or die("Cannot use this Database");
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
}
$mysql = new Mysql();
//prevent some of SQL injection and XSS attack
	function inputCheck($input){
		$input=mysql_real_escape_string(htmlspecialchars($input));
		return $input;
	}
?>