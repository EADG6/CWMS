        <?php
			session_start();
			require "inc/db.php";
			include "inc/header.php";
			echo "<div class='col-sm-6 col-sm-offset-3'>
					<div class='alert alert-success'>
					<div class='fat'>";
            if(isset($_SESSION['product__quantity']) && !isset($_POST['fname']) && !isset($_POST['isCata'])){
				if(isset($_SESSION['order_id'])){
/**To edit an order, first need to DELETE previous order*/
					$mysql->query("DELETE FROM order_product WHERE order_id = '{$_SESSION['order_id']}'");
					$mysql->query("DELETE FROM order_service WHERE order_id = '{$_SESSION['order_id']}'");
					$sql_del="DELETE FROM orders WHERE id='{$_SESSION['order_id']}'";
					$mysql->query($sql_del);
					unset($_SESSION['order_id']);
				}
/**save new order info into array, create new order and INSERT each product item*/
				$product__quantity=$_SESSION['product__quantity'];
	            $cus_id = $_SESSION['cus_id'];	
	            $emp_id = $_SESSION['emp_id'];	
				unset($_SESSION['emp_id']);
				unset($_SESSION['cus_id']);
				unset($_SESSION['product__quantity']);
                $itemnum = count($product__quantity);
				$car_id = inputCheck($_POST["carid"]);
                $sql_inserto = "INSERT orders(cus_id,date,time,status) VALUE($cus_id,curdate(),curtime(),1)";
                $mysql->query($sql_inserto);
				$order_id = mysql_insert_id();
				if(!empty($emp_id)&&!empty($car_id)){
					$mysql->query("INSERT order_service(emp_id,car_id,order_id) VALUE('$emp_id','$car_id','$order_id')");
				}
                for ($itemcount=0;$itemcount<$itemnum;$itemcount++) {
					$product_id = array_keys($product__quantity)[$itemcount];
					$quantity = $product__quantity[$product_id];
                    $sql_insertf = "INSERT order_product(order_id,product_id,quantity) VALUE(".$order_id.",".$product_id.",".$quantity.")";
                    $mysql->query($sql_insertf);
                }
                echo "Create Order Successfully";  
               header("refresh:1;url='index.php?page=current_orders'");		
            }else if(isset($_POST['fname'])){
/**cheack info and create a new customer*/	
				$fname = preg_replace("/\s/","",(string)$_POST['fname']);
				if(!empty($fname)){
					$lname = preg_replace("/\s/","",(string)$_POST['lname']);
					$address = preg_replace("/\s/","",(string)$_POST['address']);
					$tel = preg_replace("/\s/","",(string)$_POST['tel']);
					$sex = (int)$_POST['sex'];
					for($i=1;$i<=3;$i++){
						$carid = 'carid'.$i;
						$plate = 'plate'.$i;
						$brand = 'brand'.$i;
						$color = 'color'.$i;
						$$carid = inputCheck($_POST['carid'.$i]);
						$$plate = inputCheck($_POST['plate'.$i]);
						$$brand = inputCheck($_POST['brand'.$i]);
						$$color = inputCheck($_POST['color'.$i]);
					}
					if(isset($_POST['cusid'])){
						$cusid = inputCheck($_POST['cusid']);
						$sql_editcus = "UPDATE customer SET firstname = '$fname',lastname = '$lname',tel = '$tel',sex = $sex,address = '$address' WHERE id = '$cusid'";
						$mysql->query($sql_editcus);
						$mysql->query("UPDATE car SET plate='$plate1',brand='$brand1',color='$color1' WHERE id = '$carid1'");
						$mysql->query("UPDATE car SET plate='$plate2',brand='$brand2',color='$color2' WHERE id = '$carid2'");
						$mysql->query("UPDATE car SET plate='$plate3',brand='$brand3',color='$color3' WHERE id = '$carid3'");
						echo 'Update Customer Successfully';
					}else{
						$username = inputCheck(preg_replace("/\s/","",$_POST['username']));
						$salt=base64_encode(mcrypt_create_iv(6,MCRYPT_DEV_RANDOM)); //Add random salt
						$pwdhash = MD5('1234'.$salt); //MD5 of pwd+salt
						$sql_newcus= "INSERT customer (firstname,lastname,sex,tel,address,username,salt,pwdhash) VALUE ('$fname','$lname',$sex,'$tel','$address','$username','$salt','$pwdhash')";
						$mysql->query($sql_newcus);
						$cusid = mysql_insert_id();
						$mysql->query("INSERT car VALUES ('','$plate1','$brand1','$color1','$cusid'),('','$plate2','$brand2','$color2','$cusid'),('','$plate3','$brand3','$color3','$cusid')");
						echo "Add Customer Successfully";
					}
					header("refresh:1;url='index.php?page=customer&action=info'");
				}else{
					echo "<script> history.back(-1)</script>";
				}
            }else if(isset($_POST['isCata'])){
/**create or update product item*/
				$productname = inputCheck($_POST['productName']);
				$productPrice = preg_replace("/\s/","",(string)$_POST['price']);
				if(!empty($productname)){
					if($_POST['isCata']=='product'){
						$productCata = inputCheck($_POST['productCata']);
						if(isset($_POST['origId'])){
							$sql_newproduct = "UPDATE product_service SET product_name = '$productname',Price = $productPrice,type_id = $productCata WHERE id = {$_POST['origId']}";
							echo "Update Product Information Successfully";
						}else{
							$sql_newproduct = "INSERT product_service (product_name,Price,type_id) VALUES ('$productname',$productPrice,$productCata)";
							echo "Add New Product Successfully";
						}
						$mysql->query($sql_newproduct);
						header("refresh:1;url='index.php?page=product&action=detail'");
					}else if($_POST['isCata']=='cata'){
						if(isset($_POST['origId'])){
							$sql_newcata = "UPDATE product_service SET product_name = '$productname' WHERE id = '{$_POST['origId']}'";
							echo "Update Product Catalogue Successfully";
						}else{
							$cataId = inputCheck($_POST['cataId']);
							$sql_newcata = "INSERT product_service (product_name,type_id) VALUES ('$productname','$cataId')";
							echo "Add New Product Catalogue Successfully";
						}
						$mysql->query($sql_newcata);
						header("refresh:1;url='index.php?page=product&action=cata'");
					}
				}else{
					echo "Wrong!<script>history.go(-1);</script>";
				}
			}
			echo "		</div>
						<p>Back to Home Page in 1 seconds...</p>
						<a href='index.php'>Back to Homepage immdiately</a>
					</fieldset>
				</div>";
        ?>
				</dd>
			</dl>
		</div>
	</body>
</html>