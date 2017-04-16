<!--Show All Recharge information-->
<div class="col-md-12 mainblocks">
	<table class ='table table table-striped'>
		<thead>
			<th colspan='7'>Payment Records:</th>
			<tr>
				<th>Customer</th>
				<th>Amount</th>
				<th>Pay Type</th>
				<th>Cashier</th>
				<th>Recharge Time</th>
			</tr>
		</thead>
		<tbody>
		<?php
			$sql_payInfo = "SELECT CONCAT(c.username,' - ',c.firstname,' ',c.lastname) AS customer,r.price,pt.type,CONCAT(e.username,' - ',e.firstname,' ',e.lastname) AS staff,r.datetime FROM recharge AS r INNER JOIN customer AS c ON r.cus_id = c.id INNER JOIN pay_type AS pt ON r.pay_type_id=pt.id INNER JOIN employee AS e ON r.emp_id = e.id ORDER BY r.datetime DESC";
			$res_payInfo = $mysql->query($sql_payInfo);
			while($row_payInfo = $mysql->fetch($res_payInfo)){
				echo"<tr>
						<td>".$row_payInfo['customer']."</td>
						<td>".$row_payInfo['price']."</td>
						<td>".$row_payInfo['type']."</td>
						<td>".$row_payInfo['staff']."</td>
						<td>".$row_payInfo['datetime']."</td>
				</tr>";
			}
		?>
		</tbody>
	</table>
</div>