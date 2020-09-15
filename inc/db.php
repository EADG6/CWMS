<?php
 class Mysql{
	function __construct(){
		$this->conn=$this->getConn();
	}
	function getConn(){
		$installed = true;
		if(!$installed){
			header("Location:install.php");
		}
        $conn =  mysqli_connect('localhost','root','','carwashing');
        mysqli_query($conn,"set names gbk");
        return $conn;
    }
	function fetch($result){
        $row = mysqli_fetch_array($result);
        return $row;
    }
	function query($sql){
        $res = mysqli_query($this->conn,$sql);
		return $res;
	}
	function oneQuery($sql){	//Get one value from db
		return $this->fetch($this->query($sql))[0];
	}
}
$mysql = new Mysql();
	function inputCheck($input){	 
		global $mysql;
		$input = mysqli_real_escape_string( //prevent some of SQL injection
			$mysql->conn,htmlspecialchars( //invalid html tag
				strip_tags($input) //delete html.php,xml tags
			)
		);
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