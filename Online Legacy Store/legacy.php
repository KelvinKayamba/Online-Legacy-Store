<!--CONNECTION TO THE DATABASE & ADD TO CART FUNCTION & DELETE TO CART FUNCTION-->
<?php 
session_start();
require "db.php";

if(isset($_POST["add_to_cart"]))
{
	if(isset($_SESSION["shopping_cart"]))
	{
		$item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
		if(!in_array($_GET["productid"], $item_array_id))
		{
			$count = count($_SESSION["shopping_cart"]);
			$item_array = array(
				'item_id'			=>	$_GET["productid"],
				'item_name'			=>	$_POST["hidden_name"],
				'item_price'		=>	$_POST["hidden_price"],
				'item_quantity'		=>	$_POST["quantity"]
			);
			$_SESSION["shopping_cart"][$count] = $item_array;
		}
		else
		{
			
		}
	}
	else
	{
		$item_array = array(
			'item_id'			=>	$_GET["productid"],
			'item_name'			=>	$_POST["hidden_name"],
			'item_price'		=>	$_POST["hidden_price"],
			'item_quantity'		=>	$_POST["quantity"]
		);
		$_SESSION["shopping_cart"][0] = $item_array;
	}
}
 
if(isset($_GET["action"]))
{
	if($_GET["action"] == "delete")
	{
		foreach($_SESSION["shopping_cart"] as $keys => $values)
		{
			if($values["item_id"] == $_GET["productid"])
			{
				unset($_SESSION["shopping_cart"][$keys]);
				echo '<script>alert("Item Removed")</>';
				echo '<script>window.location="legacy.php"</script>';
			}
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Legacy Online Store</title>
    <!--LINK TO CSS STYLESHEET-->
    <link rel="stylesheet" href="Styles.css">
    <!--SOME FUNCTIONS-->
    <script src="myFunction.js"></script>
</head>
<body>
     <!--TITLES-->
     <header>
        <h1>CloudInfoSystems Online Store</h1>
    </header>
        <h2> Choose products to add in your cart.</h2>
    <!--PRODUCTS LISTS-->
    <?php 
       $query = "SELECT * FROM sd_product ORDER BY productid ASC";
       $result = mysqli_query ($conn,$query);
       if(mysqli_num_rows($result)> 0){

         while ($row = mysqli_fetch_array($result)){
    ?>
    <div class="product_cards">
     <form method ="post" id="fcart"  action="legacy.php?action=add&productid=<?php echo $row["productid"]; ?>">
      <div class="items product" id="item">
          <img src=<?php echo $row['image']; ?> alt="">
          <h3><?php echo $row['name']; ?></h3>
          <p><?php echo $row['description']; ?></p><br>
          <div class="custom-select"><!--SELECT SIZE-->
            <select>
              <option value="0"><?php echo $row['radiodesc']; ?></option>
              <option value="1"><?php echo $row['radio1']; ?></option>
              <option value="2"><?php echo $row['radio2']; ?></option>
              <option value="3"><?php echo $row['radio3']; ?></option>
              <option value="4"><?php echo $row['radio4']; ?></option>
              <option value="5"><?php echo $row['radio5']; ?></option>
            </select>
          </div>
          <div class="custom-select"><!--SELECT COLOR-->
            <select>
              <option value="0"><?php echo $row['sradiodesc']; ?></option>
              <option value="1"><?php echo $row['sradio1']; ?></option>
              <option value="2"><?php echo $row['sradio2']; ?></option>
              <option value="3"><?php echo $row['sradio3']; ?></option>
              <option value="4"><?php echo $row['sradio4']; ?></option>
              <option value="5"><?php echo $row['sradio5']; ?></option>
            </select>
          </div><br><br>
          <label>QTY : <input type="text" name="quantity" class="count" value="0"/></label><!--UPDATE CART-->
             <br><br>
                       <input type="hidden" name="hidden_name" value="<?php echo $row['name']; ?>" />
                       <input type="hidden" name="hidden_price" value="<?php echo $row['price']; ?>" />
          <h4><?php echo $row['price']; ?></h4>
          <button class="btn" onclick="DisplayTable()"  name="add_to_cart">Add to Cart</button>
        </div>
        </form> 
    </div><!---END OF PRODUCTS LIST-->
    <?php
         }
        }
    ?>
    
      <!--VIEW CART INFO-->
      <table id="content" class="table">
      <thead>
          <tr>
            <th width="15%">Name</th>
            <th width="10%" >Quantity</th>
            <th width="10%" >Unit Price</th>
            <th width="10%">Price</th>
            <th width="10%">Action</th>
        </thead>
        <tbody>
        <?php
					if(!empty($_SESSION["shopping_cart"]))
					{
						$total = 0;
						foreach($_SESSION["shopping_cart"] as $keys => $values)
						{
					?>
					<tr>
						<td data-label="Name"><?php echo $values["item_name"]; ?></td>
						<td data-label="Quantity"><?php echo $values["item_quantity"]; ?></td>
						<td data-label="Unit Price">$ <?php echo $values["item_price"]; ?></td>
						<td data-label="Price">$ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2);?></td>
						<td data-label="Action"><a href="legacy.php?action=delete&productid=<?php echo $values["item_id"]; ?>"><span class="text-danger">X</span></a></td>
					</tr>
					<?php
							$total = $total + ($values["item_quantity"] * $values["item_price"]);
						}
					?>
					<tr>
						<td colspan="3" align="right" data-label="Total"><b>Total</b></td>
						<td align="right" data-label="">$ <?php echo number_format($total, 2); ?></td>
						<td></td>
					</tr>
                    <tr>
                    <td  colspan="4" align="right"><span class="text-success" onclick="openForm()">Checkout</span></td>
                    <br><br>
                    </tr>
					<?php
					}
					?>
        </tbody>
      </table>
      <!--CHECKOUT FORM-->
    <div class="container" id="Myform">
 <span class="close" onclick="closeForm()">&times;</span>
          <div class="text">Personal Information</div>
          <form action="#" name="myForm" method="post" onsubmit="return validateForm()">
           <div class="data">
               <label>Name</label>
               <input type="text" name="fname">
            </div>
            <div class="data">
              <label>Email</label>
              <input type="text" name="email">
            </div>
            <div class="data">
              <label>Associated Student</label>
               <input type="text"name="student">
            </div>
              <button type="submit">Submit</button>
          </form>
    </div>
</body>
</html>