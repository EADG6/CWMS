<!--Show All Payment information-->
<div class="col-md-12 mainblocks">
	<table class ='table table table-striped'>
		<thead>
			<th colspan='7'>Payment Records:</th>
			<tr>
				<th>Order ID</th>
				<th>Payer</th>
				<th>Price</th>
				<th>Pay Type</th>
				<th>Paid</th>
				<th>Cashier</th>
				<th>Payment Time</th>
			</tr>
		</thead>
		<tbody>
		<?php
			$sql_payInfo = "SELECT p.order_id,CONCAT(c.username,' - ',c.firstname,' ',c.lastname) AS customer,p.price,pt.type,p.price*p.discount AS paid,CONCAT(e.username,' - ',e.firstname,' ',e.lastname) AS staff,p.pay_time FROM payment AS p LEFT JOIN customer AS c ON p.cus_id = c.id INNER JOIN pay_type AS pt ON p.pay_type_id=pt.id INNER JOIN employee AS e ON p.emp_id = e.id";
			$res_payInfo = $mysql->query($sql_payInfo);
			while($row_payInfo = $mysql->fetch($res_payInfo)){
				$payer = empty($row_payInfo['customer'])?'Unknown':$row_payInfo['customer'];
				echo"<tr>
						<td>".$row_payInfo['order_id']."</td>
						<td>".$payer."</td>
						<td>".$row_payInfo['price']."</td>
						<td>".$row_payInfo['type']."</td>
						<td>".$row_payInfo['paid']."</td>
						<td>".$row_payInfo['staff']."</td>
						<td>".$row_payInfo['pay_time']."</td>
				</tr>";
			}
		?>
		</tbody>
	</table>
</div>