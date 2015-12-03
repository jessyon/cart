<?php
session_start();
//session_destroy();

$page = 'index.php';

mysql_connect ('localhost','root','xcvb') or die (mysql_error( ));
mysql_select_db('cart') or die(mysql_error ());

if (isset($_GET['add'])){
	$quantity=mysql_query('SELECT id, quantity FROM products WHERE id ='
	                                     .mysql_real_escape_string((int)$_GET['add']));
	while($quantity_row = mysql_fetch_assoc($quantity)){
	   if ($quantity_row['quantity'] > $_SESSION['cart_'.(int)$_GET['add']])// this is the key and session value is the number of product in cart.
	     {
	     $_SESSION['cart_'.(int)$_GET[ 'add' ]] += '1'  ;

	               // this is the whole variable to ]] and then right is the value.        
	     }
	}
header('Location: '.$page);
}

if(isset($_GET['add'])) {
 $_SESSION['cart_' . (int) $_GET['remove']]+='1';
 header('Location: '.$page);
}



if(isset($_GET['remove'])) {
 $_SESSION['cart_' . (int) $_GET['remove']]-='1';
 header('Location: '.$page);
}

if(isset($_GET['delete'])) {
$_SESSION['cart_'.(int)$_GET['delete']] ='0';
header('Location: ' .$page );
}





function products(){
	$get = mysql_query('SELECT id, name, description, price 
	FROM products 
	WHERE quantity > 0 ORDER BY id DESC');
	if (mysql_num_rows($get)==0){
	echo "There are no products to display.";
	}else{
		 while ($get_rows = mysql_fetch_assoc($get)){
			echo '<p>'.$get_rows['name'].'<br />'.$get_rows['description'].'<br />'
			.number_format($get_rows['price'], 2)
			.' <a href ="cart.php?add='.$get_rows['id'].' ">Add</a></p>';
				}
			}
	  }







//google paypal checkout pdn
function paypal_items(){
	$num = 0;
	foreach ($_SESSION as $name => $value){
		if ($value != 0){
			//if (substr($name, 0, 5) == 'cart_'){
				$id = substr($name, 5,   strlen($name)  -5 )     ;
				$get = mysql_query('SELECT id, name, price, shipping 
				                                 FROM products WHERE id = '
				                                 .mysql_real_escape_string((int)$id));
		while ( $get_rows= mysql_fetch_assoc($get)){
		    $num++;		    	
		    echo $num. ' ' . $id .'<br />';
			echo '<input type = "hidden"  name = "item_number_ ' .$num.' "   value = " '.$id.' " >';
			echo '<input type = "hidden"  name="item_name_'.$num.' "  value=" '.$get_rows['name'].' ">';
			echo '<input type = "hidden" name = "amount_'.$num.' "  value=" '.$get_rows['price'].' " >';
			echo '<input type = "hidden"  name = "shipping_'.$num.' "   value=" '.$get_rows['shipping'].' "  >';
			echo '<input type = "hidden"  name = "shipping2_'.$num.' "   value=" '.$get_rows['shipping'].' "  >';
			echo '<input type = "hidden"  name="quantity_'.$num.' "    value = " '.$value.' ">'; 
			    }
					
		}
	}
}






































function cart()	{
	  foreach($_SESSION as $name => $value) {
	  echo$name . ' has quantity of ' .$value.'<br />';
	      if ($value>0){
	 			//if (substr($name, 0, 5) =  'cart_' ){
	 			// 0 is counting point and five letters from 0 and subtract that 5 letters
	 			//substr( string, start, length ) argument meaning 
	 			//minus four. This means "start 4 characters from the left of the end of the string
	 			//So you provide the function with a string, then you have to tell PHP which character in the string to start at. 
	 			//The length is how many characters you want to grab. This is optional. If you miss it out, you'll grab all the characters to the end of the string.

	 			 		$id = substr($name, 5 , (strlen ($name) - 5 )  );
	 			 		// start at five which is_ and strlen($name) is 5 and 5-5 equals 0.
	 			 		// we want to get id int
	 			 		$get = mysql_query('SELECT id, name, price FROM products WHERE id=' 
	 			 		                                .mysql_real_escape_string( (int)$id));
	 			 		                                
	 			         while ($get_rows=mysql_fetch_assoc($get)){
	 			         $sub = $get_rows['price']*$value;
	 			       		echo $get_rows['name'].' x '. $value. ' @  &dollar;'
	 			       		 .number_format($get_rows['price'],2). ' =  &dollar;' .number_format($sub, 2).
	 			        ' <a href="cart.php?remove='.$id.' ">[-]</a> <a href = "cart.php?add='.$id.' ">[+]</a>
	 			       	<a href="cart.php?delete='.$id.' "> Delete</a><br /><br /><br />' ;
	 			                                                                               }         	 			                   	 			
	                           }    $total +=$sub;
	 
	                                                                            } 
	if($total ==0){
		echo "Your cart is empty.";
	                     }else{ echo '<p>Total: &dollar; ' . number_format($total, 2).'</p>'; 
?>
<p>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_cart">
<input type="hidden" name="upload" value="1">
<input type="hidden" name="business" value="kateyon81@gmail.com">
<?php paypal_items(); ?>
<input type="hidden" name="currency_code" value="AUD">
<input type="hidden" name="amount" value="<?php echo $total; ?>">
<input type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but03.gif" 
name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>
</p>
<?php

	                              }
}  
?>