	<dl class="mainblocks">
		<dd class="row clearfix">
			<form method='post' style='padding-top:20px;'>
				<h1 class="text-center text-danger"><?php echo ucwords($_SESSION['admin'])."'s Profile";?></h1>
				<div class='col-md-3 col-md-offset-1'>
					<label>Change Password</label>
				</div>
				<div class="form-group col-md-6 col-md-offset-1">
					
					<div class="form-group">
						 <label>Password </label>
						 <input type="password" class="form-control" name='oldpwd' required/>
					</div>
					<div class="form-group">
						 <label>Password </label>
						 <input type="password" class="form-control" onchange='checkpwd()' name='pwd' required/>
						 <kbd class='seepwd' onmousedown="seepwd('pwd')"><i class='fa fa-eye'></i></kbd>
					</div>
					<div class="form-group">
						<label>Password Confirm </label>
						<input type="password" class="form-control" onchange='checkpwd()' name='pwdConfirm' required/>
						<kbd class='seepwd' onmousedown="seepwd('pwdConfirm')" onclick='checkpwd()'><i class='fa fa-eye'></i></kbd>
					</div>
					<div class="form-group col-md-4 col-md-offset-4" style='padding:0'>
						 <button type="submit" class="btn btn-block btn-lg btn-success" name='sign' onmousedown='checkpwd()' disabled>Submit</button>
					</div>
				</div>
			</form>
			<form method='post' style='padding-top:20px;'>
				<div class='col-md-3 col-md-offset-1'>
					<label>Change Information</label>
				</div>
				<div class="form-group col-md-6 col-md-offset-1">
					<div class="form-group col-md-6">
						<label>Last name</label><input type="text" class="form-control" name='lname' maxlength=20/>
					</div>
					<div class="form-group col-md-6">
						<label>First name</label><input type="text" class="form-control" name='fname' maxlength=20/>
					</div>
					<div class="form-group col-md-6">
						<label>Phone</label><input type="tel" class="form-control" name='tel' maxlength=30/>
					</div>
					<div class="form-group col-md-6">
						<label>Birthdate</label><input type="date" class="form-control" name='birth' maxlength=30/>
					</div>
					<div class="form-group col-md-6">
						<label>Gender</label>
						<select type="sex" class="form-control" name='sex'/>
							<option value='0'>Unknown</option>
							<option value='1'>Male</option>
							<option value='2'>Female</option>
						</select>
					</div>
					<div class="form-group col-md-4 col-md-offset-4" style='padding:0'>
						<button type="submit" class="btn btn-block btn-lg btn-success" name='editinfo'>Submit</button>
					</div>
				</div>
			</form>
		</dd>
	</dl>

<?php 
/**Edit Password*/
	if(isset($_POST['sign'])){
		$oldpwd = inputCheck($_POST['oldpwd']);
		$res_pwd = $mysql->fetch($mysql->query("SELECT pwdhash,salt FROM employee WHERE id = '{$_SESSION['adminid']}'"));
		$oldpwdhash = MD5($oldpwd.$res_pwd['salt']);
		if($oldpwdhash == $res_pwd['pwdhash']){
			$newpwdhash = MD5($_POST['pwd'].$res_pwd['salt']);
			if($newpwdhash==$oldpwdhash){
				echo "<script>$('#myprofile').click();
					$('[name=\"pwd\"').addClass('alert-danger');
					$('[name=\"pwd\"').focus();
					alert('New Password Cannot be same as the original one!');
				</script>";
			}else{
				$sql_newPwd = "UPDATE employee SET pwdhash = '$newpwdhash' WHERE id = {$_SESSION['adminid']}";
				$mysql->query($sql_newPwd);
				unset($_SESSION['admin']);
				unset($_SESSION['adminid']);
				unset($_SESSION['role']);
				redirect('login.php','Change Password Successfully!\\nPlease Log in again!');
			}
		}else{
			echo "<script>$('#myprofile').click();
				$('[name=\"oldpwd\"').addClass('alert-danger');
				$('[name=\"oldpwd\"').focus();
				alert('Wrong Password');
			</script>";
		}
	}
/**Edit Customer Info*/
	$sql_userinfo = "SELECT * from employee WHERE id = {$_SESSION['adminid']}";
	$res_userinfo = $mysql->fetch($mysql->query($sql_userinfo)); 
	echo "<script>
				$('[name=\"fname\"').val('".inputCheck($res_userinfo['firstname'])."')
				$('[name=\"lname\"').val('".inputCheck($res_userinfo['lastname'])."')
				$('[name=\"tel\"').val('".inputCheck($res_userinfo['phone'])."')
				$('[name=\"birth\"').val('".inputCheck($res_userinfo['birth'])."')
				$('[name=\"sex\"').val('".inputCheck($res_userinfo['gender'])."')
		</script>";
 	if(isset($_POST['editinfo'])){
		$fname = inputCheck($_POST['fname']);
		$lname = inputCheck($_POST['lname']);
		$tel = inputCheck($_POST['tel']);
		$sex = inputCheck($_POST['sex']);
		$birth = inputCheck($_POST['birth']);
		$sql_updateInfo = "UPDATE employee SET firstname = '$fname', lastname = '$lname', phone = '$tel', gender = '$sex', birth = '$birth' WHERE id = '{$_SESSION['adminid']}'";
		$mysql->query($sql_updateInfo);
		redirect('index.php?page=profile','Change information Successfully!');
	}
?>