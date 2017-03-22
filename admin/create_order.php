<?php
/**save product catalogue and customers full name into arrays*/
	$sql_fcata = "SELECT type_id,product_name FROM product_service WHERE price IS NULL ORDER BY type_id";
	$result_fcata = $mysql->query($sql_fcata);
	$sql_cusinfo = "SELECT id,CONCAT(firstname,' ',lastname) FROM customer ORDER BY firstname, lastname";
	$result_cusinfo = $mysql->query($sql_cusinfo);
?>
<script>
/**Confirm when leave current page*/
//window.onbeforeunload=function(){return "Do You Want to Leave Current Page?"};
/**function of add,minus,show,hide and check input number*/
	function a(fid){ 
		var x=document.getElementById(fid).value; 
		if(x.length==0){ x=0; }
		if(x < 999){
			document.getElementById(fid).value = parseInt(x)+1;
		}
	}
	function m(fid){ 
		var x=document.getElementById(fid).value;
		if(x > 0){
			document.getElementById(fid).value = parseInt(x)-1;
		}
	}
	function vis(fid){
		document.getElementById('l'+fid).style.visibility = "visible";
		document.getElementById('r'+fid).style.visibility = "visible";
	}
	function hide(fid){
		document.getElementById('l'+fid).style.visibility = "hidden";
		document.getElementById('r'+fid).style.visibility = "hidden";
	}
	function check(fid){
		var q = document.getElementById(fid).value;
		if (q <= 0 || q > 999 || q != parseInt(q)){
			document.getElementById(fid).value = '';
			document.getElementById(fid).style.backgroundColor = "white";
		}else{
			document.getElementById(fid).style.backgroundColor = "rgba(10, 135, 84, 0.13)";
		}
	}
	function changeEmpSele(){
		boxs = $('input[type="checkbox"]');
		ischeck = false;
		for(i=0;i<boxs.length;i++){
			if(boxs[i].checked){
				ischeck = true;
			}
		}
		if(ischeck){
			$('#emp').attr('required',true);
			$('#emp').attr('disabled',false);
		}else{
			$('#emp').attr('required',false);
			$('#emp').attr('disabled',true);
			$('#emp').val('')
		}
	}
/**print time and refresh in every 1s*/		
	setInterval(printTime,1000);
	function reset() {  
		if (confirm("Do you want to reset?")) {  
				window.location.href='index.php?page=create_order';
		}  
	}
</script>
	<div class='col-sm-7'>
		<form id='order_table' action='index.php?page=create_order' method ='post'>
			<div class='col-sm-12'>
				<div class='big form-group col-sm-9'>
					<label for='cus'>Customer:</label>
					<select name='cus_id' id='cus' class='form-control selectid'>
						<option value='0'>--</option>
					<?php 
						while($row = $mysql->fetch($result_cusinfo)) {
							echo "<option value=$row[0]>$row[1]</option>";
						}	
					?>
					</select><br/>
					<label for='emp'>Worker:</label>
					<select name='emp_id' id='emp' class='form-control selectid' disabled>
						<option value=''>--</option>
					<?php 
						$sql_employee = "SELECT * FROM employee";
						$result_emp = $mysql->query($sql_employee);
						while($row = $mysql->fetch($result_emp)) {
							echo "<option value=$row[0]>$row[1]</option>";
						}	
					?>
					</select>
				</div>
				<div class='col-xs-3 createbtns'>
					<button id='createbtn' type='primary' class='btn btn-primary btn-lg'>Create New</button>
				</div>
			</div>
			<div class='create_order'>
				<table class='table table-striped'>
	<?php
/**output all the product items of each type of product*/
		while($row_fcata = $mysql->fetch($result_fcata)) {
			$cata_id = $row_fcata['type_id']; 
			/*only product info, no product catalogue*/
	        $sql_finfo = "select s.id,s.product_name as product_name,s.price,s.type_id from product_service as s join product_service as p where p.id = s.type_id and s.price IS NOT NULL and s.type_id = $cata_id ORDER BY s.price"; 
	        $result_finfo = $mysql->query($sql_finfo); 
            echo "<th colspan='5' id=".$row_fcata['product_name'].">".$row_fcata['product_name']."</th>
					<tr>
						<td><b>Product ID</b></td>
						<td><b>Product Name</b></td>	
						<td><b>Product Price</b></td>
						<td class='text-center'><b>Quantity</b></td>
					</tr>";
            while($row_finfo = $mysql->fetch($result_finfo)) {
                echo "<tr>
						<td>".$row_finfo['id']."</td>
						<td>".$row_finfo['product_name']." </td>
						<td>&#165;".$row_finfo['price']." </td>";
				if($cata_id==1){
					echo "<td>
								<label><input type='checkbox' id='checkbox{$row_finfo['id']}' onclick='var i=document.getElementById({$row_finfo['id']});i.value=(i.value==1)?0:1' onchange='changeEmpSele()'> Select This Service</label>
								<input type='hidden' id='{$row_finfo['id']}' name='odproduct[{$row_finfo['id']}]'>
							</td>
						</tr>";
				}else{
					echo "<td onmousemove='vis({$row_finfo['id']})' onmouseout='hide({$row_finfo['id']});check({$row_finfo['id']})'>
							<div class='col-sm-2'>	
								<button id='l{$row_finfo['id']}' class='btn btn-primary bnum bnuml' type='button' onclick='m({$row_finfo['id']})' ><i class='fa fa-minus'></i></button>
							</div>
							<div class='col-sm-5 col-sm-offset-1'>	
								<input type='number' id='{$row_finfo['id']}' name='odproduct[{$row_finfo['id']}]' min = '0' max = '999' class='form-control'/>
							</div>
							<div class='col-sm-2'>	
								<button id='r{$row_finfo['id']}' class='btn btn-primary bnum bnumr' type='button' onclick='a({$row_finfo['id']})' ><i class='fa fa-plus'></i></button>
							</div>
						</td>
					</tr>";
				}
            }
		}		
	?>	
				</table>
			</div>
		</form>
	</div>
	
<div id='create_page' class='col-sm-5'>
	<?php 
/**IT'S THE EDIT FUNCTION. When 'order_block.php' post this page,it can get the order data and write on the 'create order' input form;
session['times'] is a counter to make sure session['order_id'] directly comes from 'order_block.php', otherwise, if user refersh,
 go to other page or cancel order while editing order, the session['order_id'] is still here.*/	
		if(isset($_POST['fd_quan'])){
			$fd_quan= $_POST['fd_quan'];
			$od_cus = $_POST['od_cus'];
			$emp_id = empty($_POST['od_emp'])? '':inputCheck($_POST['od_emp']);
			$order_id=array_keys($od_cus)[0];
			$_SESSION['order_id']=$order_id;
			$cus_id=$od_cus[$order_id];
			echo "<script>$('#cus').val($cus_id);
							$('#emp').val($emp_id);
							if('$emp_id'!=0){
								$('#emp').attr('disabled',false)
							}
				</script>";
			for($i=0;$i<count($fd_quan);$i++){
				$product_id=array_keys($fd_quan)[$i];
				$product_num=$fd_quan[$product_id];	
				echo "<script>var quaninput = document.getElementById($product_id);
							if(quaninput.type=='hidden'){
								document.getElementById('checkbox$product_id').checked=true
							}
							quaninput.value=$product_num
							quaninput.style.backgroundColor = 'rgba(10, 135, 84, 0.13)';
						</script>";
			}
			unset($_POST['fd_quan']);
			$_SESSION['times']=0;
		}else{
			if(isset($_SESSION['times'])){
				$_SESSION['times']++;
			}
		}
		if(isset($_SESSION['times'])){
			if($_SESSION['times']>1){
				unset($_SESSION['order_id']);
			}	
		}						
/**save product items detail information into array*/
        $sql_productinfo = "SELECT id,product_name AS product_name,price FROM product_service WHERE price IS NOT NULL";
        $result = $mysql->query($sql_productinfo);
        $product_cata_info = array();
        echo "<table class='table table-bordered table-striped'>";  
        while($row = $mysql->fetch($result)) {
	        $product_cata_info['name'][$row['id']] = $row['product_name'];
	        $product_cata_info['price'][$row['id']] = $row['price'];
		}
/**Result part(right part) of create new order*/
/**if choose a custer,search full name and print it,or just show unknown*/
		if(isset($_POST['cus_id'])){
			if(!empty($_POST['cus_id'])){
				$cus_id = (int)$_POST['cus_id'];
				$sql_cusinfo = "SELECT firstname,lastname,tel from customer where id = $cus_id;";
				$result_cus = $mysql->query($sql_cusinfo);  
				$row_cus = $mysql->fetch($result_cus);
				$cusname=$row_cus[0]."&nbsp".$row_cus[1];
			}else{
				$cus_id = '0';
				$cusname='Unknown';
			}
		}else{
			$cusname='New Order';
		}
		if(isset($_POST['emp_id'])){
			if(!empty($_POST['emp_id'])){
				$emp_id = (int)$_POST['emp_id'];
				$sql_empinfo = "SELECT firstname,lastname from employee where id = $emp_id;";
				$result_emp = $mysql->query($sql_empinfo);  
				$row_emp = $mysql->fetch($result_emp);
				$empname=$row_emp[0]."&nbsp".$row_emp[1];
			}else{
				$emp_id = '0';
				$empname='Unknown';
			}
		}else{
			$empname='No Worker';
			$emp_id = '0';
		}
		$datetime = date('Y/m/d H:i:s',time());
		echo "<tr class='bold'>
				<td style='font-size: 26px;border-right:0px;' >".$cusname."&nbsp</td>
				<td style='border-left:0;text-align:right;'>$empname</td>
				<td colspan='2' style='border-left:0;text-align:right;' id='time' onclick='inputTime()'>$datetime</td>
				<td colspan='2' style='border-left:0;text-align:right;display:none;' id='timeNew'>
					<form action='submit.php' method='post' id='newOrder'>
						<input type='time' name='time'/>
					</form>
				</td>
			</tr>
            <tr class='fat'>
				<td>Product Name</td><td>Price</td><td>Quantity</td>
			</tr>"; 
		echo "<script>
				function inputTime(){
					document.getElementById('time').style.display='none';
					document.getElementById('timeNew').style.display='inline';
					
				}
			</script>";
/**Save all the product id and quantity in an Array, and filter the empty items,if the array is still not empty, 
print the product items and total price in a table, and hide the 'Create New' button*/
		$totalp = 0;
		if(isset($_POST['odproduct'])){
			$product__quantity = array_filter($_POST['odproduct']);//The array_filter without call back functon, default delte empty array items
			if(!empty($product__quantity)){
				for($i=0;$i < count($product__quantity);$i++){
					$f_id = array_keys($product__quantity)[$i];
					$f_quantity = $product__quantity[$f_id];
					if(!empty($f_quantity)){
						echo "<tr>
								<td><b>".$product_cata_info['name'][$f_id]."</b></td>
								<td>&#165;".$product_cata_info['price'][$f_id]."</td>
								<td>".$f_quantity."</td>
							</tr>";
						$totalp += $product_cata_info['price'][$f_id] * $f_quantity;
					}
				}	
			}
			echo "<tr>
					<td colspan='2' class='fat'>Total Price</td>
					<td colspan='2' class='text-centered'>&#165;&nbsp".$totalp."</td>
				 </tr>
				 </table>
			<script>document.getElementById('createbtn').style.display= 'none'</script>";
		?>
			<nav class='submitbtn'>
				<ul>
					<li>
						<button id='subord' class='btn btn-success' type="primary" onclick="document.getElementById('newOrder').submit();">Submit</button>
					</li>
					<li>
						<button id='modord' class='btn btn-primary' onclick ="history.go(-1)" outline>Modify</button>
					</li>
					<li>
						<button class='btn btn-default' onclick="printdiv('create_page')">Print</button>
					</li>
					<li>
						<button class='btn btn-danger' onclick ="reset()" outline>Reset</button>
					</li>
				</ul>
			</nav>
		<?php
/**if the total price is greater than 0, save order info array and customerID in Session, otherwise disable the Submit button*/		
			if($totalp > 0){
				$_SESSION['product__quantity'] = $product__quantity;
				$_SESSION['cus_id']= $cus_id;
				$_SESSION['emp_id']= $emp_id;
			}else{
				echo "<script>document.getElementById('subord').disabled='true';</script>";
			}
/**if Session['order_id'] is isset, which means user is Editing order. The Modify order button will be disabled, because it may cause some problem*/
			if(isset($_SESSION['order_id'])){
				echo "<script>document.getElementById('modord').disabled='true';</script>";
			}
        }else{
			echo "</table>";
		}
        ?>
</div>




