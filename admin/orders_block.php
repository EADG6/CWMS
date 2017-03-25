<script>
/**change block's style after click pay,edit,delete and more buttons*/	
	function paidstyle(orid){	
		$('#obnav'+orid+' table *').css('background','rgba(166, 255, 209,1)');
		$('#obnav'+orid+' table').css('background','rgba(166, 255, 209,1)');
		$('#paid'+orid).css('visibility','visible');
		$('#btn2'+orid+' button:not(.btn-warning)').css('visibility','hidden');	
	}
	function submit(orid){
		document.getElementById('formd'+orid).submit();
	}
	function foldbtn(orid){
		document.getElementById('ob'+orid).style.height='300px';
		document.getElementById('obnav'+orid).style.height= '280px';
		document.getElementById('more'+orid).style.display='inline';
		document.getElementById('fold'+orid).style.display='none';
		var x1 = document.getElementsByClassName('obtd'+orid);
		var i1;
		for (i1=0;i1<x1.length;i1++){
			x1[i1].style.display= 'none';
		}
	}
	function morebtn(orid,t){
		document.getElementById('ob'+orid).style.height= ((50*(t-3))+300)+'px';
		document.getElementById('obnav'+orid).style.height= ((50*(t-3))+300)+'px';
		document.getElementById('more'+orid).style.display='none';
		document.getElementById('fold'+orid).style.display='inline';
		var x = document.getElementsByClassName('obtd'+orid);
		var i;
		for (i=0;i<x.length;i++){
			x[i].style.display= 'table-cell';
		}
	}
	function noBalance(){
		$('[name="paytype"] option:first').attr('disabled',true)
		$('[name="paytype"]').val(2);
	}
	function checkcus(){
		if($('[name="payer"]').val()=='NULL'){
			noBalance();
		}else{
			$('[name="paytype"] option:first').attr('disabled',false)
			$('[name="paytype"]').val(1);
		}
		discountPrice()
	}
	function discountPrice(){
		origPri = $('[name="totprice"]').val()
		if($('[name="paytype"]').val()==1){
			$('#payordid').html(origPri*0.9)
		}else{
			$('#payordid').html($('[name="totprice"]').val())
		}
	}
 	function payOrder(orid,cusid,totprice){
		if(cusid==0){
			cusid='NULL';
			noBalance();
		}
		$('#payordid').html(totprice)
		$('[name="payordid"]').val(orid)
		$('[name="totprice"]').val(totprice)
		$('[name="payer"]').val(cusid)
		$('#modal-pay').click()
		discountPrice()
	}
	function rateOrder(orid,stars,empname){
		if(stars==0){
			$('#stars').parent().attr('disabled',true)
		}else{
			$('[name="ratelevel"]').val(stars)
			rateStar()
		}
		$('#worker').html(empname)
		$('[name="rateordid"]').val(orid)
		$('#modal-rate').click()
	}
	function rateStar(){
		starNum = $('[name="ratelevel"]').val();
		for(i=0;i<$('#stars').children().length;i++){
			if(i<starNum){
				$($('#stars').children()[i]).css('color','yellow')
			}else{
				$($('#stars').children()[i]).css('color','#ffffff')
			}
		}
		if(starNum==0){
			$('#stars').parent().attr('disabled',true)
		}else{
			$('#stars').parent().attr('disabled',false)
		}
	}
	function deleteOrder(orid){
		if(confirm('Do you want to Delete order No.'+orid+'?')){
			document.getElementById('del'+orid).click();
		}
	}
</script>
<?php
	include 'timecond.php';
/**query all the orders and customer information in limited condition*/	
	$sql_orders = "SELECT o.id,o.cus_id,car.plate,CONCAT(c.firstname,' ',c.lastname) AS cusname,emp_id,CONCAT(e.firstname,' ',e.lastname) AS empname,Date,Time,status,rate FROM orders as o LEFT JOIN customer as c ON o.cus_id = c.id LEFT JOIN employee as e ON o.emp_id = e.id LEFT JOIN car ON o.car_id = car.id $condition ORDER BY Date DESC,time DESC";
	$result = $mysql->query($sql_orders);
	while($row_order = $mysql->fetch($result)) {
		$cusname= empty($row_order['cusname']) ? 'Unknown': $row_order['cusname'];
		$empname= empty($row_order['empname']) ? '': '(Worker: '.$row_order['empname'].")";
		$car_info = inputCheck($row_order['plate']);
?>
<div class='order_block col-md-4' id='ob<?php echo $row_order[0];?>'>
	<div class='ob_nav' id='obnav<?php echo $row_order[0];?>'>
		<table id="ob_tbl<?php echo $row_order[0];?>">
			<tr>
		<?php
/**count one orders' total price and item number*/
		$sql_order_price = "select sum(f.price * quantity) as order_price, count(*) as num from order_product inner join product_service as f ON order_product.product_id = f.id where order_id = {$row_order['id']}";
			$res=$mysql->query($sql_order_price);
			$row_item=$mysql->fetch($res);
			$num=$row_item['num'];
			echo "<th colspan='2'>$cusname <small>$car_info</small></th>
					<th class='text-right' colspan='2'>".substr($row_order['Date'],5)." ".substr($row_order['Time'],0,5)."</th>";
			?>
			</tr>
			<tr id='ob_tbl_th'>
				<td>Products</td>
				<td>Quantity</td>
				<td>Single</td>
				<td>Total</td>
			</tr>
		<?php
/**find and show detail information of each order*/
		$sql_item_detail = "SELECT Item_id,F.order_id,cus.lastname as lname,Cs.product_name as item_name,Cp.product_name,Quantity,Cs.price as Single_Price,(Cs.price*quantity)as Total_Price,F.product_id from order_product as F JOIN orders as O on F.order_id = O.id JOIN product_service as Cs ON F.product_id = Cs.id JOIN product_service as Cp ON Cp.id = Cs.type_id LEFT JOIN customer as cus ON cus.id = O.cus_id WHERE F.order_id= {$row_order['id']}";
			$result_item_detail = $mysql->query($sql_item_detail);
/**action to create_order to edit order if user need*/
			echo "<form id='formd{$row_order['id']}' method='post' action='index.php?page=create_order'>";
			$showtimes=0;
			while($row_item_detail = $mysql->fetch($result_item_detail)) {
				$showtimes++;
/**if an order have more than 4 items, it should be fold*/
				if ($showtimes<4){
					echo "<tr id='ob_tbl_tb' >
							<td>".$row_item_detail['item_name']." </td>
							<td>".$row_item_detail['Quantity']." </td>
							<td>&#165;".$row_item_detail['Single_Price']." </td>
							<td>&#165;".$row_item_detail['Total_Price']." </td>
						</tr>";
				}else{
					echo "<tr id='ob_tbl_tb1'>
							<td class='obtd$row_order[0]'>".$row_item_detail['item_name']." </td>
							<td class='obtd$row_order[0]'>".$row_item_detail['Quantity']." </td>
							<td class='obtd$row_order[0]'>&#165;".$row_item_detail['Single_Price']." </td>
							<td class='obtd$row_order[0]'>&#165;".$row_item_detail['Total_Price']." </td>
						</tr>";
				}
/**save product_id, quantity, order_id and cus_id in hidden input*/	
				echo "<input type='hidden' name='fd_quan[{$row_item_detail['product_id']}]' value='{$row_item_detail['Quantity']}'/>";
			}
			echo "<input type='hidden' name='od_cus[{$row_order['id']}]' value='{$row_order['cus_id']}'/>
					<input type='hidden' name='od_emp' value='{$row_order['emp_id']}'/>
				</form>";
			/*fill in blank row if the order have less than 3 items*/	
			for($n=$num;$n<3;$n++){
				echo "<tr id='ob_tbl_tb'><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td></tr>";
			}		
			echo "<tr id='ob_tbl_tb'>
					<th colspan='2' class='paid'><span id='paid$row_order[0]'>Paid</span></th>
					<th class='text-right' colspan='2'>{$row_item['order_price']}&nbspRMB</th>
				</tr>";
		?>
		</table>
		<div class='paybtn'>
			<span id="btn2<?php echo $row_order[0];?>">
				<button type="button"  onclick="payOrder('<?php echo $row_order['id']."','".$row_order['cus_id']."','".$row_item['order_price'];?>')" class='btn btn-success'>Pay</button>
				<button type="button" onclick="rateOrder('<?php echo $row_order['id']."','".$row_order['rate']."','".$empname;?>')" class='btn btn-warning' id='rate<?php echo $row_order['id'];?>' ><?php echo $row_order['rate']==0?'Rate':'Rated '.$row_order['rate']."<i class='fa fa-star'></i>";?></button>
				<button type='button' name='edit' onclick="submit('<?php echo $row_order[0];?>')"  class='btn btn-primary'>Edit</button>
				<button type='button' onclick="deleteOrder('<?php echo $row_order['id'];?>')" class='btn btn-danger'>Del</button>
				<form method='post' action=''>
					<input id='del<?php echo $row_order['id'];?>' type='submit' name='deloid' value='<?php echo $row_order['id'];?>' style='display:none;'/>
				</form>
			</span>
			<?php
/**change style if more than 3 row*/
			if($num > 3){	
				echo "<span id='more$row_order[0]' class='morerow' onclick='morebtn($row_order[0],$num)'>
						<a><i class='fa fa-angle-double-down fa-3x'></i></a>
					</span>
					<span id='fold$row_order[0]' class='morerow' style='display:none;' onclick='foldbtn($row_order[0])'>
						<a><i class='fa fa-angle-double-up fa-3x'></i></a>
					</span>";
			}
/**paid style*/
			if($row_order['status']==4){
				echo "<script>paidstyle('$row_order[0]')</script>";
			}
			?>
		</div>
	</div>
</div>
<?php
	}
?>
<!-- Pay Order Form -->	
			<input type='hidden' id='modal-pay' href='#modal-container-2' data-toggle='modal'/>
			<div class="modal fade" id="modal-container-2" role="dialog" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h1 class="modal-title text-center" id='popFormLabel'>
								Pay a RMB <span class='label label-warning' id='payordid'></span>
							</h1>
						</div>
						<div class="modal-body">	
							<form method='post'>
								<div class="form-group">
									<label>Select Payer:</label>
									<select class="form-control" name='payer' onchange='checkcus()' required>
							<?php
								//Get all cusotmer
								$sql_cus = "SELECT id,username,CONCAT(FirstName,' ',LastName) AS realname FROM customer ORDER BY firstname, lastname";
								$res_cus = $mysql->query($sql_cus);
								while($row_cus = $mysql->fetch($res_cus)){
									echo "<option value='{$row_cus['id']}' $isdiabled>".$row_cus['username']." - ".$row_cus['realname']."</option>";
								}
							?>
										<option value='NULL'>Unknown</option>
									</select>
								</div>
							    <div class="form-group">
									<label>Select Pay Type:</label>
									<select class="form-control" name='paytype' onchange='discountPrice()' required>
							<?php
								//Get all pay type
								$sql_payType = "SELECT * FROM pay_type ORDER BY id";
								$res_payType = $mysql->query($sql_payType);
								while($row_payType = $mysql->fetch($res_payType)){
									echo "<option value='{$row_payType['id']}' $isdiabled>{$row_payType['type']}</option>";
								}
							?>
									</select>
								</div>
								<input type='hidden' name='payordid'/>
								<input type='hidden' name='totprice'/>
								<button type='submit' class='btn btn-success btn-block'/>Submit</button>
							</form>
						</div>
					</div>	
				</div>
			</div>
<!-- Rate Order Form -->	
			<input type='hidden' id='modal-rate' href='#modal-container-1' data-toggle='modal'/>
			<div class="modal fade" id="modal-container-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h1 class="modal-title text-center" id='popFormLabel'>
								Rate Order <span id='worker'></span>
							</h1>
						</div>
						<div class="modal-body">	
								<div class="form-group">
									<label>How did customer rate the order:</label>
									<select class="form-control" name='ratelevel' onchange='rateStar()' required>
										<option value='0' selected>Select a Level...</option>
										<option value='5'>Perfect</option>
										<option value='4'>Very Good</option>
										<option value='3'>Not Bad</option>
										<option value='2'>Bad</option>
										<option value='1'>Very Bad</option>
									</select>
								</div>
								<input type='hidden' name='rateordid'/>
								<button type='button' class='btn btn-success btn-block' onclick='changeRate()' disabled/>
								   <span id='stars'>
									<i class='fa fa-star'></i>
									<i class='fa fa-star'></i>
									<i class='fa fa-star'></i>
									<i class='fa fa-star'></i>
									<i class='fa fa-star'></i>
								  </span>
								</button>
						</div>
					</div>	
				</div>
			</div>
<?php
/**function of pay order*/
	if(isset($_POST['payordid'])){
		$payId = inputCheck($_POST['payordid']);
		$cusId = inputCheck($_POST['payer']);
		$paytype = inputCheck($_POST['paytype']);
		$totprice = inputCheck($_POST['totprice']);
		if($paytype==1){
			$discount = '0.9';
			$paid = $totprice*$discount;
			$origBalance = $mysql->oneQuery("SELECT balance FROM customer WHERE id ='$cusId'");
			if($origBalance < $paid){
				echo "<script>alert('Banlance ($origBalance) is lower than price ($paid)')</script>";
				return false;
			}else{
				$sql_redbalance = "UPDATE customer SET balance = balance-$paid WHERE id = '$cusId'";
				$mysql->query($sql_redbalance);
			}
		}else{
			$discount = '1';
		}	
		$empid = $_SESSION['adminid'];
		$sql_payment = "INSERT payment VALUES ('','$payId',$cusId,'$totprice','$discount',NOW(),'$paytype','$empid')";
		$sql_updOrdStatus = "UPDATE orders SET status=4 WHERE id= $payId";
		$mysql->query($sql_payment);
		$mysql->query($sql_updOrdStatus);
		echo "<script>paidstyle('$payId');alert('Payed Successfully!')</script>";
	}
/**function of delete order*/
	if(isset($_POST['deloid'])){
			$delId = $_POST['deloid'];
			echo "<script>document.getElementById('obnav'+$delId).style.display='none';</script>";
			$mysql->query("DELETE FROM orders WHERE id = $delId");
		}
/**if row_item is not empty,row_order must not be empty(no orders).Because it's outside of while loop,so it only can use row_item*/		
	if(empty($row_item)){
		echo "No $unpaidAdj orders for <samp>$timestamp</samp> yet";
	}
?>
