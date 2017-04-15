<?php
	include('inc/header.php');
	date_default_timezone_set('PRC');
?>
	<object id='spider' type="application/x-shockwave-flash" style="margin:-20px;position:fixed;z-index:1;display:none" data="http://cdn.abowman.com/widgets/spider/spider.swf?" width="100%" height="100%">
		<param name="movie" value="http://cdn.abowman.com/widgets/spider/spider.swf?"></param>
		<param name="AllowScriptAccess" value="always"></param>
		<param name="wmode" value="transparent"></param>
		<param name="scale" value="exactfit"/>
		<param name="quality" value="best"/>
	</object>
	<div class="col-md-6 col-md-offset-3">
		<div class='col-xs-12' style="margin-top:40px;padding-top:10px;border-radius:5px;height:400px;background:#fff;">
			<table class="table table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">Environments</th>
                            <th>Recommend</th>
                            <th class="text-center">Current</th>
                            <th class="text-center">Minimum</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Operation System</td><td class="font-bold text-left">WINNT</td>
                            <td><div class="label label-warning"><?php echo PHP_OS;?></div></td>
                            <td>No Limit</td>
                        </tr>
                        <tr> <td>PHP Version</td><td>5.5.x</td><td><?php echo phpversion();?></td><td>5.3.0</td></tr>
                        <tr> <td>MySQL Version</td><td>5.x.x</td><td><?php echo function_exists('mysql_connect')?mysql_get_server_info():'<span>&radic;</span>Error';?></td><td>5.2</td></tr>
                         <tr>
                            <td>File Upload</td><td>2M</td><td><?php echo ini_get('file_uploads')?ini_get('upload_max_filesize'):'<span>&radic;</span>禁止上传';?></td><td>No Limit</td>
                        </tr>
                        <tr>
                            <td>SESSION</td><td>Open</td><td><?php echo function_exists('session_start')?'<i class="fa fa-check"></i>Supported':'<span>&radic;</span>Nonsupport';?></td><td>Open</td>
                        </tr>
                        <tr>
                            <th class="text-center">Directory Authority</th><th class="text-center" colspan="2">Write</th><th class="text-center">Read</th>
                        </tr>
                        <?php
						$folder = array(
							'/',
							'/inc/',
							'/admin/'
						);
						$cwd = __dir__;
						for($i=0;$i<count($folder);$i++){
							$path = $cwd.$folder[$i];
							if(is_readable($path)){
								$readable = '<i class="fa fa-check"></i>Readable';
							}else{
								$readable = '<i class="fa fa-close"></i>Not Readable';
							}
							if(is_writable($path)){
								$writeable = '<i class="fa fa-check"></i>Writable';
							}else{
								$writeable = '<i class="fa fa-close"></i>Not Writable ';
							}
							echo "<tr>
                                <td>".$path."</td>
                                <td colspan=2 class='text-center'>$writeable</td>
                                <td>$readable</td>
                            </tr>";
						}
						
                        ?>
                    </tbody>
                </table>
		</div>
		<button id='install' onclick='location.href="install.php?submit"' class='btn btn-danger btn-lg btn-block center-block'>Start to Install</button>
	</div>
<?php
	if(file_exists('install.lock')){
		echo "<script>$('#install').attr('disabled',true);$('#spider').show()</script>";
	}else{
		if(isset($_GET['submit'])){
			include "inc/db.php";
/* Create Lock file to stop re-install*/
			$lock_file = fopen('install.lock','wb');
			$lock_cont = 'User: '.$_SERVER['SERVER_ADDR'].' installed system at'.date("Y/m/d H:m:s");
			fputs($lock_file,$lock_cont);
			fclose($lock_file);
			/* 
			$conn =  mysql_connect('localhost','root','0618') or die("Cannot connect to server".mysql_error());
			$db = mysql_select_db("carwashing",$conn);
			mysql_query("CREATE DATABASE IF NOT EXISTS `carwashing` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci",$conn);
			mysql_select_db("carwashing",$conn) or die("Cannot use this Database");
			$sql_tables = file_get_contents('carwashing_new.sql');
			$sql_ary = explode(';',$sql_tables);
			for($i=0;$i<count($sql_ary);$i++){
				mysql_query($sql_ary[$i].';');
				//echo $mysql->fetch($mysql->query('SHOW WARNINGS'))[2].'<br/>';
			}
			echo "<script>alert('Create Database Successfully');location.href='index.php'</script>"; */
			//header("Location:index.php");
		}
	}
	//print_r(scandir(__dir__));
	/*echo md5_file("inc/db.php"); */
?>