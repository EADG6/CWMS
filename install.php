<?php
	include('inc/header.php');
?>
	<div class="col-sm-4 col-sm-offset-4">
		<div class='col-sm-12' style="margin-top:40px;border-radius:5px;height:400px;background:#fff;">
		</div>
		<button id='install' onclick='location.href="install.php?submit"' class='btn btn-danger btn-lg btn-block center-block'>Start to Install</button>
	</div>
<?php
	$conn =  mysql_connect('localhost','root','0618') or die("Cannot connect to server".mysql_error());
	$db = mysql_select_db("carwashing",$conn);
	if($db){
		echo "<script>$('#install').attr('disabled',true)</script>";
	}else{
		if(isset($_GET['submit'])){
			mysql_query("CREATE DATABASE IF NOT EXISTS `carwashing` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci",$conn);
			mysql_select_db("carwashing",$conn) or die("Cannot use this Database");
			$sql_tables = file_get_contents('carwashing_new.sql');
			$sql_ary = explode(';',$sql_tables);
			for($i=0;$i<count($sql_ary);$i++){
				mysql_query($sql_ary[$i].';');
				//echo $mysql->fetch($mysql->query('SHOW WARNINGS'))[2].'<br/>';
			}
			echo "<script>alert('Create Database Successfully');location.href='index.php'</script>";
			header("Location:index.php");
		}
	}
	//print_r(scandir(__dir__));
	/*echo md5_file("inc/db.php"); */
?>