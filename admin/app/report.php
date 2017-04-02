<!--Show All Payment information-->
<div class="col-md-12 mainblocks" style='padding-top:20px'>	
<?php
	include("inc/timecond.php");
	include("inc/datarep.php");
?>
	<div class="col-md-12" >
	  <div class="tabbable" id="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#panel-sales" data-toggle="tab">Sale Statistic</a>
			</li>
			<li>
				<a href="#panel-analysis" data-toggle="tab" id='myanaly'><span class="glyphicon glyphicon-cog"></span>&nbsp;Sales Analysis</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="panel-sales">
	<?php
	/**Show product sold information*/
	$sql_fcata = "SELECT type_id,product_name FROM product_service WHERE price IS NULL ORDER by type_id";
	$result_fcata = $mysql->query($sql_fcata);
	echo "<table class='table table table-striped'>"; 
	while($row_fcata = $mysql->fetch($result_fcata)) {
		$cata_id = $row_fcata['type_id'];	
        $sql_finfo = "SELECT id,s.product_name AS product_name,s.price FROM product_service AS s WHERE s.type_id = ".$cata_id." AND s.price IS NOT NULL;";
	    $result_finfo = $mysql->query($sql_finfo); 
        echo "<tr><th colspan='4' id=".$row_fcata['product_name'].">".$row_fcata['product_name']."</th></tr>
				<tr>
					<th class='text-center'>Item Name</th>
					<th>Price</th>
					<th>Quantity</th>
					<th>Total</th>
				</tr>";
		while($row_finfo = $mysql->fetch($result_finfo)) {
			echo "<tr>
					<td class='text-center'>".$row_finfo['product_name']."</td>
					<td>&#165;".$row_finfo['price']." </td>";   
            $productid = $row_finfo['id'];
            $sql_fquantity = "SELECT SUM(quantity) AS quantity FROM order_product AS od INNER JOIN orders AS o ON o.id=od.order_id $condition AND product_id = ".$productid.";";
			$result_fquantity = $mysql->query($sql_fquantity); 
			while($row_fquantity = $mysql->fetch($result_fquantity)) {
				$quantity = empty($row_fquantity['quantity'])?0:$row_fquantity['quantity'];
				echo "<td>".$quantity."</td>";
			}
			echo "<td>&#165;".$quantity*$row_finfo['price']."</td>
			</tr>";
	    }   
    }
	$totalPrice = $mysql->oneQuery("SELECT SUM(op.Quantity*p.Price) AS total FROM order_product AS op INNER JOIN product_service AS p ON op.product_id=p.id INNER JOIN orders AS o ON o.id=op.order_id $condition");
	if(empty($totalPrice)){$totalPrice = 0;}
	echo "<th colspan=3>Total Price: &#165;$totalPrice<th>
	</table>";
?>
			</div>
			<div class="tab-pane" id="panel-analysis">
<?php
	//$sql_ordProducts = "SELECT od.order_id,p.cata_name AS product_name FROM cafe.order_food AS od INNER JOIN cafe.food_catalogue AS p ON od.food_id=p.food_id ORDER BY order_id";
	$sql_ordProducts = "SELECT od.order_id,p.product_name FROM order_product AS od INNER JOIN product_service AS p ON od.product_id=p.id INNER JOIN orders AS o ON o.id=od.order_id $condition ORDER BY order_id";
	$result = $mysql->query($sql_ordProducts);
	$ordProducts = array();
	$ordID='';$ordNum=0;
	while($row = $mysql->fetch($result)){
		if($ordID!=$row['order_id']){
			array_push($ordProducts,[$row['product_name']]);
			$ordNum++;
			$ordID=$row['order_id'];
		}else{
			array_push($ordProducts[$ordNum-1],$row['product_name']);
		}
	}
	$staRes = new Report($ordProducts);
	//$staRes->find2SC(0.1,0.1,'%');
	//print_r($staRes->aprior(0.1,2));
	?>
			</div>
		</div>
	  </div>
	</div>
</div>