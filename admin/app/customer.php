<?php
if(isset($_GET['action'])){
	$action = $_GET['action'];
}else{
	$action='info';
}
if($action == 'new'){
/**query customers ID and show new customer form*/
$sql_cusinfo = "SELECT id from customer order by id DESC;";
	$result = $mysql->query($sql_cusinfo); 
	$row = $mysql->fetch($result);
	$newnum = $row[0]+1;		
	echo "
	<form action='submit.php' method='post' class='form-inline'>
	<table class='table'>
		<th colspan='4' id='formtitle'>New Customer</th>
		<tr>
			<td>Customer Number</td>
			<td>
				<input type='text' id='cusid' name='cusid' class='form-control' value='$newnum' disabled='disabled'/>
			</td>
			<td>Username<span class='req'> *</span></td>
			<td>
				<input type='text' class='form-control' maxlength=20 name='username' oninput='checkCusName()' autocomplete='off' required/><kbd style='position:absolute;margin:6px 0 0 -25px'class='hidden'><i></i></kbd>
			</td>
		</tr>
		<tr>
			<td class='bold'>First Name<span class='req'> *</span></td>
			<td>
				<input type='text' maxlength='10' name='fname' class='form-control' required/>
			</td>
			<td class='bold'>Last Name</td>
			<td>
				<input type='text' maxlength='10' name='lname' class='form-control'/>
			</td>
		</tr>
		<tr>
			<td class='bold'>Gender</td>
			<td>
				<label>Male:<input type='radio' name='sex' value=1/></label> 
				<label>Female:<input type='radio' name='sex' value=2/></label> 
				<label>Unknown:<input type='radio' name='sex' value=0 checked/></label>
			</td>
			<td class='bold'>Phone Number</td>
			<td>
				<input type='tel' maxlength='20' name='tel' class='form-control'/>
			</td>
		</tr>
		<tr>
			<td class='bold'>Address</td>
			<td>
				<input type='text' maxlength='200' name='address' class='form-control'/>
			</td>
			<td colspan=2>
			</td>
		</tr>
		<tr>
			<td class='bold'>Bind Car 1</td>
			<input type='hidden' name='carid1'/>
			<td>
				<input type='text' name='plate1' maxlength='50' placeholder='Car Plate' class='form-control'/>
			</td>
			<td>
				<input type='text' name='brand1' maxlength='50' placeholder='Car Brand' class='form-control'/>
			</td>
			<td>
				<input type='text' name='color1' maxlength='50' placeholder='Car Color' class='form-control'/>
			</td>
		</tr>
		<tr>
			<td class='bold'>Bind Car 2</td>
			<input type='hidden' name='carid2'/>
			<td>
				<input type='text' name='plate2' maxlength='50' placeholder='Car Plate' class='form-control'/>
			</td>
			<td>
				<input type='text' name='brand2' maxlength='50' placeholder='Car Brand' class='form-control'/>
			</td>
			<td>
				<input type='text' name='color2' maxlength='50' placeholder='Car Color' class='form-control'/>
			</td>
		</tr>
		<tr>
			<td class='bold'>Bind Car 3</td>
			<input type='hidden' name='carid3'/>
			<td>
				<input type='text' name='plate3' maxlength='50' placeholder='Car Plate' class='form-control'/>
			</td>
			<td>
				<input type='text' name='brand3' maxlength='50' placeholder='Car Brand' class='form-control'/>
			</td>
			<td>
				<input type='text' name='color3' maxlength='50' placeholder='Car Color' class='form-control'/>
			</td>
		</tr>
		
		<tr>
			<td colspan=4>
				<div class='col-md-4 col-md-offset-4'>
					<button class='btn btn-block btn-primary' type='primary' name='submit'>Submit</button>
				</div>
			</td>
		</tr>
	</table>
	</form>";	
	if(isset($_POST['origCusEdit'])){
			$origCus = explode(',',$_POST['origCusEdit']);
			echo "<script>
					var cusid = document.getElementById('cusid');
					cusid.disabled = false;
					cusid.value = {$origCus[0]};
					cusid.onchange = function(){
						cusid.value = {$origCus[0]};
					};
					document.getElementsByName('fname')[0].value = '{$origCus[1]}';
					document.getElementsByName('lname')[0].value = '{$origCus[2]}';
					document.getElementsByName('tel')[0].value = '{$origCus[3]}';
					document.getElementsByName('address')[0].value = '{$origCus[5]}';
					document.getElementsByName('username')[0].value = '{$origCus[6]}';
					document.getElementsByName('username')[0].required = false;
					document.getElementsByName('username')[0].disabled = true;
					var gender = document.getElementsByName('sex');
					if({$origCus[4]}==1) gender[0].checked=true;
					if({$origCus[4]}==0) gender[1].checked=true;	
					if({$origCus[4]}==3) gender[2].checked=true;
					$('#formtitle').html('Edit Customer')
				</script>";
			$sql_carinfo = "SELECT * FROM car WHERE cus_id = '".$origCus[0]."'";
			$res_carinfo = $mysql->query($sql_carinfo);
			$carnum = 0;
			while($row_carinfo=$mysql->fetch($res_carinfo)){
				$carnum++;
				echo "<script>
					$('[name=\"carid$carnum\"]').val('{$row_carinfo['id']}')
					$('[name=\"plate$carnum\"]').val('{$row_carinfo['plate']}')
					$('[name=\"brand$carnum\"]').val('{$row_carinfo['brand']}')
					$('[name=\"color$carnum\"]').val('{$row_carinfo['color']}')
				</script>";
				
			}
	}
}else if($action == 'info'){
/**show all customer's information*/
		$sql_cusinfo = "SELECT c.*,COUNT(car.id) AS cars FROM customer AS c LEFT JOIN car ON car.cus_id=c.id GROUP BY car.cus_id";
		$result = $mysql->query($sql_cusinfo);
?>		
	<div class="col-md-12 mainblocks">
		<div class='helptip' id='helptip_info' style="display:none;">
			<a class='label label-primary'>E</a> Edit /
			<a class='label label-danger'>X</a> Delete /
		</div>
		<table class ='table table table-striped'>
			<thead>
				<th colspan='11'>Customer Information:</th>
				<tr>
					<th>Customer ID</th>
					<th>First Name</th>
					<th>Last Nmae</th>
					<th>Sex</th>
					<th>Tel</th>
					<th>Cars</th>
					<th>Address</th>
					<th>Balance</th>
					<th>Payed</th>
					<th>
						Operation <a href='javascript:void(0);' onclick="$('#helptip_info').toggle()" class="glyphicon glyphicon-question-sign icona"></a>
					</th>
				</tr>
			<thead>
			<tbody>
<?php
/**count how much money does each customer paid*/
		while($row = $mysql->fetch($result)) {
		    echo "<tr>";
				$sql_sum="select sum(f.price * quantity) as credit from order_product inner join product_service as f ON order_product.product_id = f.id where order_id in (select id from orders where cus_id = {$row['id']})";
				$res_cre=$mysql->query($sql_sum);
				$row_cre=$mysql->fetch($res_cre);
				switch($row['sex']){
					case 1: $sex='Male';break;
					case 2: $sex='Female';break;
					case 3: $sex='Unknown';break;
				}
				$balance=(empty($row['balance']))? 0:round($row['balance'],2);
				$credit=(empty($row_cre['credit']))? 0:$row_cre['credit'];
			echo "	<td>".$row['id']."</td>
					<td>".$row['FirstName']."</td>
					<td>".$row['LastName']."</td>
					<td>".$sex."</td>
					<td>".$row['tel']."</td>
					<td>".$row['cars']."/3</td>
					<td>".$row['address']."</td>
					<td>&#165;$balance</td>
					<td>&#165;$credit</td>";
?>
					<td>
						<a class='label label-primary' onclick="firm('Do you want to Edit this Customer?','editCus<?php echo $row['id'];?>')">E</a>
						<a class='label label-danger' onclick="firm('Do you want to Delete this Customer?','deleteCus<?php echo $row['id'];?>')">X</a>
					</td>
				</tr>
				<form action='index.php?page=customer&action=new' method='post' id='editCus<?php echo $row['id'];?>'>
					<input type='hidden' name='origCusEdit' value='<?php echo $row['id'].','.$row['FirstName'].','.$row['LastName'].','.$row['tel'].','.$row['sex'].','.$row['address'].','.$row['username'];?>'/>
				</form>
				<form action='' method='post' id='deleteCus<?php echo $row['id'];?>'>
					<input type='hidden' name='origCusDel' value='<?php echo $row['id'];?>'/>
				</form>
<?php	}
?>			<tbody>
		</table>
	</div>
<?php
/**Delete Customer function*/
		if(isset($_POST['origCusDel'])){
			$sql_delCus = "DELETE FROM customer WHERE id = {$_POST['origCusDel']}";
			echo $sql_delCus;
			$mysql->query($sql_delCus);
			echo "<script>window.location.href='index.php?page=customer&action=info';</script>";
		}
}	
?>
<script>
	function firm(text,formid){  
		if(confirm(text)){
			document.getElementById(formid).submit();
		}else{
			return false;
		}
	}
</script>
