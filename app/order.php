<script>
	/* Change order rate */
	function rateStar(num,orid){
		for(var i=0;i<(num+1);i++){
			$($('#stars'+orid).children()[i]).css('color','yellow')
		}
	}
 	function hideStar(num,orid,orig){
		for(var i=5;i>(orig-1);i--){
			$($('#stars'+orid).children()[i]).css('color','#fff')
		}
	}
	function changeRate(starnum,orid){
		starnum++;
		$.ajax({
			url:'admin/ajax.php',
			data:{"rate":starnum,"orderid":orid},
			type:'POST',
			success:function(data){
				window.location.href='index.php?page=order'
			}
		});
	}
</script>
<?php
   if (isset($_GET['id'])){
   	$id =$_GET['id'];
   	//delete the menu
    $result = $mysql->query("DELETE FROM order_product WHERE order_id = $id");
    $result = $mysql->query("DELETE FROM order_service WHERE order_id = $id");
    $result = $mysql->query("DELETE FROM orders WHERE id = $id");
    $result = $mysql->query("DELETE FROM payment WHERE order_id = $id");
   		echo"<script type='text/javascript'>alert('Menu Delete Now'); location='index.php?page=order';</script>"; 
   }
	if ($_SESSION['customer_id'] == 0 ){
		unset($_SESSION['customer_id']);
		session_destroy();
		echo "<script>alert('Please Login First');location.href='login.php'</script>";
	}
?>
<div class="container">
    <div class="addorder">
		<h1>Check Order</h1>
    </div>
			<div class="col-sm-12 ordertable">
				<table class="table table table-striped">
					<thead>
						<tr>
				       	 	<th>Order ID</th>        
							<th>Plate</th>
							<th>Time</th>
							<th>Rate</th>
							<th>Status</th>
							<th>Delete</th>
						<tr>
					</thead>
				<?php
					$sql_orders = "SELECT o.id,c.plate,CONCAT(Date,' ',Time) AS time,o.status,o.rate FROM orders AS o INNER JOIN order_service AS os ON o.id=os.order_id INNER JOIN car AS c ON c.id=os.car_id WHERE o.cus_id='".$_SESSION['customer_id']."'"; 
					$result_orders = $mysql->query($sql_orders);
                    if(mysqli_num_rows($result_orders)>0){
                        while ($row_orders = $mysql->fetch($result_orders)){
                    ?>							       
                        <tr>
                         <td><?php echo $row_orders['id']; ?></td>
                         <td><?php echo $row_orders['plate']; ?></td>
                         <td><?php echo $row_orders['time']; ?></td>
                         <td>
                            <button type="button" class="btn btn-primary" id='stars<?php echo $row_orders['id']; ?>'>
                        <?php
                            for($i=0;$i<5;$i++){
                                $star = $row_orders['rate']>$i?'style="color:yellow"':'' ;
                                echo "<i class='fa fa-star stars' $star onclick='changeRate($i,".$row_orders['id'].")' onmouseover='rateStar($i,".$row_orders['id'].")' onmouseout='hideStar($i,".$row_orders['id'].",".$row_orders['rate'].")'></i>";
                            }
                        ?>
                            </button>
                        </td>
                         <td>
                        <?php 
                            switch($row_orders['status']){
                                case 1: echo 'Pending';break;
                                case 2: echo 'On Going<script>$(document).ready(function(){$("#delbtn'.$row_orders['id'].'").attr("href","javascript:alert(\'You cannot delete ongoing order\')");$("#delbtn'.$row_orders['id'].'").attr("class","btn btn-default")})</script>';break;
                                case 3: echo 'Done but Unpaid';break;
                                case 4: echo 'Paid';break;
                            }
                        ?>
                         </td>
                         <td>
                            <a href ="javascript:if(confirm('Are You Sure to Delete?'))location='index.php?page=order&id=<?php echo $row_orders['id'];?>'" id='delbtn<?php echo $row_orders['id'];?>' class="btn btn-danger">Delete </a>
                         </td>
                        </tr>
                        <?php
                            }
                        }else{
                            echo "<tr><td class='alert-warning' colspan=6>No Records</td></tr>";
                        }
                        ?>
				</table>
			</div>
    	</div>