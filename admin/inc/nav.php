		<div class="tab_out">
            <table class="table-stripped">
		        <tr><td class='text-centered tab'>
				<nav>
					<div class="left-menu">
						<a href="index.php?page=create_order"><button class='btn btn-primary' type="button"><i class="fa fa-plus"></i> Create Order</button></a>
						<a href="index.php?page=current_orders"><button class='btn btn-info' type="button"><i class="fa fa-shopping-cart"></i> Current Orders</button></a>
					</div>
					<div class="right-menu">
						<div class="nav dropdown">
						    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
							<i class="fa fa-navicon "></i> Menu <span class="caret"></span></button>
						    <ul class="dropdown-menu">
						      <li class="dropdown-header">Overviews</li>
							  <li><a href="index.php?page=product&action=weekly">Weekly Report</a></li>
							  <li><a href="index.php?page=report">Statistical Report</a></li>
						      <li class="divider"></li>
						      <li class="dropdown-header">Customer</li>
						      <li><a href="index.php?page=customer&action=info">Customer Info</a></li>
							  <li><a href="index.php?page=customer&action=new">New Customer</a></li>
							  <li><a href="index.php?page=recharge">Recharge</a></li>
							  <li class="divider"></li>
							  <li class="dropdown-header">Staff</li>
							  <li><a href="index.php?page=staff&action=info">Staff Info</a></li>
							  <li><a href="index.php?page=payment">Payment Log</a></li>
							  <li><a href="index.php?page=rechlog">Recharge Log</a></li>
						      <li class="divider"></li>
							  <li class="dropdown-header">Product</li>							  
							  <li><a href="index.php?page=product&action=detail">Product Items</a></li>
							  <li><a href="index.php?page=product&action=cata">Product Categories</a></li>
							  <li><a href="index.php?page=product&action=new">New Product</a></li>
							  <li class="divider"></li>
							  <li class="dropdown-header">Hello, <?php echo ucwords($_SESSION['admin']);?></li>							  
							  <li><a href="index.php?page=profile">My Profile</a></li>
							  <li><a href="index.php?exit">Log out</a></li>
						    </ul>
						  </div>
					</div>
				</nav>
				</tr></td>      
		    </table>
		</div>
		<div class='col-xs-1'>
			<div class="left_tab">
				<a href='#'><i class="fa fa-3x fa-chevron-up"></i></a><br/>
				<?php
				if(!isset($_GET['action'])){
					$_GET['action']='';
				}
				if ($page == 'create_order' || ($_GET['action']=='weekly') || $_GET['action']=='sold') {
					$sql_fcata = "SELECT product_name FROM product_service WHERE price IS NULL ORDER BY type_id";
					$res_fcata = $mysql->query($sql_fcata);
					while($row_fcata = $mysql->fetch($res_fcata)){
						echo "<a href=#".$row_fcata['product_name'].">".$row_fcata['product_name']."</a><br/>";
					}
				}
				?>
				<a href='#bottom'><i class="fa fa-3x fa-chevron-down"></i></a>
			</div>
		</div>
		<div class='col-xs-11'>
           <dl class="container">
				<dd class="row clearfix">