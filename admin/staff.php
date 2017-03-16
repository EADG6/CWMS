<script>
	function popFrom(id,type=''){
		$('#modal-2').click()
		$('[name="editid"]').val(id)
		if(type=='del'){
			$('[name="editid"]').attr('name','delid')
			$('[name="newRole"]').attr('required',false)
			$('#selectRole').hide()
			$('#popFormLabel').html('Delete Employee')
		}else{
			$('#selectRole').show()
			$('#popFormLabel').html('Change User Role')
		}
	}
</script>
<!--Show All employee information-->
<div class="col-md-12 mainblocks">
	<div class='helptip' id='helptip1' style="display:none;">
				<a class='label label-primary'>E</a> Edit /
				<a class='label label-danger'>X</a> Delete /
			</div>
	<table class ='table table table-striped'>
		<thead>
			<th colspan='4'>Product catalogue:</th>
			<tr>
				<th>ID</th>
				<th>Username</th>
				<th>Realname</th>
				<th>Gender</th>
				<th>Age</th>
				<th>User Group</th>
				<th>Phone</th>
				<th>Hire Date</th>
				<th>
					Operation <a href='javascript:void(0);' onclick="$('#helptip1').toggle()" class="glyphicon glyphicon-question-sign icona"></a>
				</th>
			</tr>
		</thead>
		<tbody>
	<?php
		$sql_empInfo = "SELECT e.id,username,CONCAT(firstname,' ',lastname) AS realname,gender,year(from_days(datediff(now(),birth))) AS age,phone,r.role,hiredate FROM employee AS e INNER JOIN role AS r ON e.role_id=r.id";
		$res_empInfo = $mysql->query($sql_empInfo);
		while($row=$mysql->fetch($res_empInfo)){
			switch($row['gender']){
				case 0: $gender ='Female';break;
				case 1: $gender ='Male';break;
				case 1: $gender ='Unknown';break;
			}
			echo "<tr>
				<td>".$row['id']."</td>
				<td>".$row['username']."</td>
				<td>".$row['realname']."</td>
				<td>$gender</td>
				<td>".$row['age']."</td>
				<td>".$row['role']."</td>
				<td>".$row['phone']."</td>
				<td>".$row['hiredate']."</td>
				<td>
					<a class='label label-primary' onclick='popFrom({$row['id']})'>E</a>						
					<a class='label label-danger' onclick=\"popFrom({$row['id']},'del')\">X</a>
				</td>
			</tr>";
		}
	?>
		</tbody>
	</table>
</div>
<!-- Edit role Form -->	
			<input type='hidden' id='modal-2' href='#modal-container-2' data-toggle='modal'/>
			<div class="modal fade" id="modal-container-2" role="dialog" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h1 class="modal-title text-center" id='popFormLabel'>
								Change User Role
							</h1>
						</div>
						<div class="modal-body">	
							<form method='post'>
							  <div class="form-group" id='selectRole'>
								<label>User Role:</label>
								<select class="form-control" name='newRole' required>
								  <option value="">Select a Role...</option>
					<?php
						//Get all user role
						$sql_queryRole = "SELECT * FROM role ORDER BY pid";
						$sql_queryRole = $mysql->query($sql_queryRole);
						while($row_queryRole = $mysql->fetch($sql_queryRole)){
							$isdiabled = $row_queryRole['pid']==0 ? 'disabled':'';
							echo "<option value='{$row_queryRole['id']}' $isdiabled>{$row_queryRole['role']}</option>";
						}
					?>
								</select>
							  </div>
								<div class="form-group">
									<label>Please Verify Your Password...</label>
									<input type='password' name='cfpwd' class="form-control" required/>
								</div>
								<input type='hidden' name='editid'/>
								<br/><button type='submit' class='btn btn-success btn-block' style='padding-right:0;'/>Submit</button>
							</form>
						</div>
					</div>	
				</div>
			</div>
<?php
$_SESSION['userid']=1;
	$pwdres = $mysql->fetch($mysql->query("SELECT pwdhash,salt FROM employee WHERE id = {$_SESSION['userid']}"));
	if(isset($_POST['cfpwd'])){$inputpwd = MD5($_POST['cfpwd'].$pwdres['salt']);}
	if(isset($_POST['editid'])){		
		if($inputpwd==$pwdres['pwdhash']){
			if($_SESSION['userid']==$_POST['editid']){
				redirect("index.php?page=staff&action=info","You cannot edit your own role!");
			}else{
				$editid = inputCheck($_POST['editid']);
				$newRole = inputCheck($_POST['newRole']);
				$sql_updRole = "UPDATE employee SET role_id = '$newRole' WHERE id = $editid";
				$mysql->query($sql_updRole);
				redirect("index.php?page=staff&action=info","Change Role Successfully!");
			}
		}else{
			echo "<script>alert('Wrong Password')</script>";
		}	
	}
	if(isset($_POST['delid'])){
		$delid = inputCheck($_POST['delid']);
		if($_SESSION['userid']==$delid ){
			redirect("index.php?page=staff&action=info","You cannot delete your own role!");
		}else{
			$inputpwd = MD5($_POST['cfpwd'].$pwdres['salt']);
			if($inputpwd==$pwdres['pwdhash']){
				$sql_delEmp = "DELETE FROM employee WHERE id = '$delid'";
				$mysql->query($sql_delEmp);
				redirect("index.php?page=staff&action=info","Delete Employee Successfully!");
			}else{
				echo "<script>alert('Wrong Password')</script>";
			}
		}
	}
?>
