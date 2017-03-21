<!DOCTYPE html>
<html>
    <head>
        <title>Submit</title>
        <link type="text/css" rel="stylesheet" href="../static/css/kube.css"/>
		<link type="text/css" rel="stylesheet" href="../static/css/admin.css"/>
    </head>
    <body><br/><br/><br/><br/>
        <row centered>
        <column cols="6">
        <?php
			session_start();
			include "inc/db.php";
			echo "<div class='forms'>
					<fieldset class='alert alert-success'>
					<legend class='fat'>";
            if(isset($_SESSION['product__quantity']) && !isset($_POST['fname']) && !isset($_POST['isCata'])){
				if(isset($_SESSION['order_id'])){
/**To edit an order, first need to DELETE previous order*/
					$sql_del="DELETE FROM orders WHERE id={$_SESSION['order_id']}";
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
				if(isset($_POST['time']) && !empty($_POST['time'])){
					$time = "'{$_POST['time']}'";	
				}else{
					$time = 'curtime()';
				}
                $itemnum = count($product__quantity);
                $sql_inserto = "INSERT orders(cus_id,emp_id,date,time) VALUE($cus_id,$emp_id,curdate(),$time)";
                $mysql->query($sql_inserto);
				$order_id = mysql_insert_id();
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
					if(isset($_POST['cusid'])){
						$cusid = $_POST['cusid'];
						$sql_editcus = "UPDATE customer SET firstname = '$fname',lastname = '$lname',tel = '$tel',sex = $sex,address = '$address' WHERE id = '$cusid'";
						$mysql->query($sql_editcus);
						echo 'Update Customer Successfully';
					}else{
						$sql_newcus= "INSERT customer (firstname,lastname,sex,tel,address) VALUE ('$fname','$lname',$sex,'$tel','$address')";
						$mysql->query($sql_newcus);
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
			echo "		</legend>
						<p>Back to Home Page in 1 seconds...</p>
						<a href='index.php'>Back to Homepage immdiately</a>
					</fieldset>
				</div>";
        ?>
        </column>
        </row>
    </body>
</html>