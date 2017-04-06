<!--Show All Payment information-->
<script src="../static/js/mychart.js"></script>
<div class="col-md-12 mainblocks" style='padding-top:20px'>	
	<div class="col-md-12" >
	  <div class="tabbable" id="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#panel-sales" data-toggle="tab"><span class="fa fa-car"></span>&nbsp;Product Sales</a>
			</li>
			<li onclick="this.onclick='';crefinanTrend();creOrdStaChart();creCusTransacChart();crePaytypeChart()">
				<a href="#panel-analysis" data-toggle="tab" id='myanaly'><span class="fa fa-line-chart"></span>&nbsp;Finiancial Analysis</a>
			</li>
			<li>
				<a href="#panel-assoc" data-toggle="tab" id='proassoc'><span class="fa fa-shopping-basket"></span>&nbsp;Product Association</a>
			</li>
			<li onclick="creCusUnknownChart();creCusSexChart();creCusAgeChart();crecarbindChart();this.onclick='';">
				<a href="#panel-cus" data-toggle="tab" id='proassoc'><span class="fa fa-users"></span>&nbsp;Customer Analysis</a>
			</li>
<!--			<li>
				<a href="#panel-emp" data-toggle="tab" id='proassoc'><span class="fa fa-pie-chart"></span>&nbsp;Staff Performance</a>
			</li>
-->
		</ul>
		<div class="tab-content" style='padding-top:20px'>
			<div class="tab-pane active" id="panel-sales">
		<?php
			include("inc/timecond.php");
		?>
		<script>$('#timecond_ordsta').hide()</script>
			<div class='col-sm-6' id='ProSold' style='display:none'>
				<canvas id="ProSoldChart" width="400" height="400"></canvas>
			</div>
			<div class='col-sm-6' id='ProPri' style='display:none'>
				<canvas id="ProPriChart" width="400" height="400"></canvas>
			</div>
			<div class='col-sm-4' id='soldProp' style='display:none'>
				<canvas id="SoldPropChart" width="400" height="400"></canvas>
			</div>
			<div class='col-sm-8' id='ordTrend' style='display:none'>
				<canvas id="OrdTrendChart" width="600" height="300"></canvas>
			</div>
	<?php
	/**Show product sold information*/
	$sql_fcata = "SELECT type_id,product_name FROM product_service WHERE price IS NULL ORDER by type_id";
	$result_fcata = $mysql->query($sql_fcata);
	//create arrays for draw charts
	$prod = ['label'=>[],'quan'=>[],'pri'=>[]];
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
			array_push($prod['label'],'"'.$row_finfo['product_name'].'"');
			array_push($prod['quan'] ,$quantity);
			array_push($prod['pri'] ,$quantity*$row_finfo['price']);
	    }   
    }
	$totalPrice = $mysql->oneQuery("SELECT SUM(op.Quantity*p.Price) AS total FROM order_product AS op INNER JOIN product_service AS p ON op.product_id=p.id INNER JOIN orders AS o ON o.id=op.order_id $condition");
	if(empty($totalPrice)){$totalPrice = 0;}
	echo "<th colspan=3>Total Price: &#165;$totalPrice<th>
	</table>";
?>
			</div>
<script>
	creProSoldChart([<?php echo implode(',',$prod['quan']).'],['.implode(',',$prod['label']).'],"'.ucwords($timestamp).'",['.implode(',',$prod['pri']).']';?>)
	creSoldProp('<?php echo $condition."','".ucwords($timestamp);?>')
	creOrdTrend('<?php echo $condition."','".ucwords($timestamp);?>')
</script>
			<div class="tab-pane" id="panel-analysis">
				<div class='col-sm-12' id='finanTrend' style='display:none'>
					<canvas id="FinanTrendChart" width="800" height="300"></canvas>
				</div>
				<div class='col-sm-4' id='ordSta' style='display:none'>
					<canvas id="ordStaChart" width="400" height="400"></canvas>
				</div>
				<div class='col-sm-3' id='cusTransac' style='display:none'>
					<canvas id="cusTransacChart" width="300" height="400"></canvas>
				</div>
				<div class='col-sm-5' id='paytype' style='display:none'>
					<canvas id="paytypeChart" width="400" height="300"></canvas>
				</div>
			</div>
			
			<div class="tab-pane" id="panel-assoc">
<?php
	include("inc/datarep.php");
	//$sql_ordProducts = "SELECT od.order_id,p.cata_name AS product_name FROM cafe.order_food AS od INNER JOIN cafe.food_catalogue AS p ON od.food_id=p.food_id ORDER BY order_id";
	$sql_ordProducts = "SELECT od.order_id,p.product_name FROM order_product AS od INNER JOIN product_service AS p ON od.product_id=p.id INNER JOIN orders AS o ON o.id=od.order_id ORDER BY order_id";
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
	print_r($staRes->aprior(0.05,3));
	?>
			</div>
			<div class="tab-pane" id="panel-cus">
				<div class='col-sm-3' id='cusUnknown' style='display:none'>
					<canvas id="cusUnknownChart" width="400" height="400"></canvas>
				</div>
				<div class='col-sm-4' id='cusSex' style='display:none'>
					<canvas id="cusSexChart" width="500" height="400"></canvas>
				</div>
				<div class='col-sm-5' id='cusAge' style='display:none'>
					<canvas id="cusAgeChart" width="600" height="400"></canvas>
				</div>
				<div class='col-sm-4' id='age' style=''>
					
				</div>
				<div class='col-sm-3' id='sexBuy' style=''>
					<canvas id="sexBuyChart" width="600" height="400"></canvas>
				</div>
				<div class='col-sm-5' id='carBind' style='display:none'>
					<canvas id="carBindChart" width="600" height="400"></canvas>
				</div>
			</div>
		</div>
	  </div>
	</div>
</div>