
<div class="container">
        <hr>
        <div class="row">
            <div class="col-sm-12">
                <h1>ORDERS</h1>
				
				<hr>
				<h2>First</h2>
			  </div>
				<table class="zebra">
				    <thead>
				    <tr>
				        <th>#</th>        
						<th>Name</th>
						<th>Phone Number</th>
						<th>Plate Number</th>
						<th>Time</th>
						<th>Update</th>
						<th>Delete</th>
				    </tr>
				    </thead>
				    <tfoot>
				    <tr>   
				    </tr>
				    </tfoot>    
					<?php
					$result = mysql_query("SELECT id,name,phone,plate,ordertime  FROM orders ORDER BY ordertime");
					//select information from database
					while ($row = mysql_fetch_array($result)) {
					?>
		            <tr>
					 <td><?php echo $row{'id'}; ?></td>
		             <td><?php echo $row{'name'}; ?></td>
		   	         <td><?php echo $row{'phone'}; ?></td>
					 <td><?php echo $row{'plate'}; ?></td>
					 <td><?php echo $row{'ordertime'}; ?></td>
				     <td><a href="index.php?page=update&id=<?php echo $row{'id'}?>">Update</a></td>
					 <!-- Make sure delete or not -->
				     <td><a href ="javascript:if(confirm('Are You Sure to Delete?'))location='index.php?page=deletem&id=<?php echo $row{'id'}?>'">delete </a></td>
					</tr>					
		            <?php     
					}
		            ?>
				</table>
				<h1><a href="index.php?page=addorder">New Order</a></h1>
        <hr>
        </div>
        <!-- /.row -->
        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
            </div>
            <!-- /.row -->
        </footer>
    </div>
