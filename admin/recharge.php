<div class="col-md-9 col-md-offset-1 mainblocks">
	<div class="cards col-md-12">
	  <h1 class="text-center">Recharge Page</h1>
		<div class="col-md-8 col-md-offset-2">
			<form method='post'>
				<div class="form-group">
					<label>Customer:</label>
					<select name='userid' class="form-control" required>
						<option value=''>Username - Realname</option>
		<?php
			$sql_allCus = "SELECT id,username,CONCAT(FirstName,' ',LastName) AS realname FROM customer";
			$res = $mysql->query($sql_allCus);
			while($row = $mysql->fetch($res)){
		?>				
						<option value='<?php echo $row['id'];?>'><?php echo $row['username'].'&nbsp;-&nbsp;'.$row['realname']?></option>
						
			<?php
			}  ?>
					</select>
				</div>
				<div class="form-group" class="form-control" required>
					<label>Pay Type:</label>
					<select name='paytype' class="form-control" required>
						<option value='Cash'>Cash</option>
						<option value='AliPay'>AliPay</option>
						<option value='WeChatPay'>WeChatPay</option>
					</select>
				</div>
				<div class="form-group">
					<label>Price:</label>
					<input type="number" name='price' class="form-control" max=9999 required></input>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-block btn-success">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
if(isset($_POST['price'])){
	$origres = $mysql->fetch($mysql->query("SELECT username,CONCAT(FirstName,' ',LastName) AS realname,balance FROM customer WHERE id ={$_POST['userid']}"));
	$origBalance = $origres[2];
	$cusName = $origres[0].' / '.$origres[1];
	$recharge = (int)$_POST['price'];
	$newBalance = $origBalance + $recharge;
	$sql_recharge = "UPDATE customer SET balance = $newBalance WHERE id = {$_POST['userid']}";
	$mysql->query($sql_recharge);
	$sql_rechargeLog = "INSERT recharge VALUES('','{$_POST['userid']}','{$_POST['price']}',NOW(),'{$_POST['paytype']}')";
	$mysql->query($sql_rechargeLog);
	echo "<script>alert('Recharge \"$cusName\" RMB $recharge Successfully! \\n Curent Balance: $newBalance')</script>";
}
?>
