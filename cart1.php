<?php
// this part is the session functions for add to cart
//add delete remove increas the quantity through a href and get id
//if id gets pass to the sessoin then ++
// if id get pass to the cart.php through delete then session = '0'
// if id gets pass to the cart.php through remove the session -='1'
// and those links are with products list and cart dislayed. and come to the session
 

if(isset($_GET['add'])){
	$quantity= mysql_query('SELECT id, quanity 
	FROM products WHERE id = ' . $_GET['add']);
	while($quantity_row = mysql_fetch_assoc
	($quantity)){
	if($quantity_row['quantity']>$_SESSION('cart_'.$_GET['add']){
	$_SESSION['cart_'.$_GET['add']]+='1';
	}
	
	}header ('Location: '.$page);
}

if(isset($_GET['remove'])){
$_SESSION['cart_'.$_GET['remove']] -='1';
header('Location: '.$page);
}

if(isset($_GET['delete'])){
$_SESSION['cart_' . $_GET['delete']] = '0';
}


function products {
 $get=mysql_query('SELECT id, name, description, price, quantity FROM
 products WHERE quanity > 0 ORDER BY DESC');
 
 if(mysql_num_rows($get==0)){
 echo "there is no products to display";
 }else{
 while $get_rows=mysql_fetch_assoc($get){
 echo $get_rows['name'].'<br />' . $get_rows['description'].'<br />'. 
 number_format($get_rows['price'],2) . 
 '<a href = "cart.php?add='.$_GET['id'] ' ">Add</a>';
 }
 }
}

//  find id that had value in session variable. cart quantity value
//and then dosplay the products within the session
//searched by id 
//that i have session value more than 0 and display the products 
//multipled by session value that increaded by a href incremented one by one. as get
// so this thisplay the sub total.
//and the loop with while so sub total get added and all products displayed 
//products that has session value incremented by ++.

function car(){
 foreach($_SESSION as $name => $value){
 echo $name . ' has quanity of ' . $value . '<br />';
  if($value > 0){
  
   $id= substr($name, 5, (strlen($name))-5)// start from 5 to right. depends  lenth of the number
   $get= mysql_query('SELECT id, name, price FROM products 
   WHERE id = ' . $id);
   while($get_rows= mysql_fetch_assoc($get)){
   	$sub= $get_rows['price'] *$value;
   	echo $get_rows['name']. ' X ' .$value. 
   	' @  &dollar; '. $get_rows['price']. ' = &dollar; ' .$sub.
   	'<a href = "cart.php?add='.$id.' ">[+]</a>
   	<a href = "cart.php?remove=' .$id.' ">[-]</a>
   	<a href = "cart.php?delete=' .$id.' ">Delete</a>
   	'
   }  $total += $sub;
   
  }
  if($total ==0){
  echo "Your cart is empty.";}else {
  echo 'Total : &dollar;' . $total; 
  }
  
  }
 }
}

function paypal_items(){
	$num=0;
	
	foreach ($_SESSION as $name => $value){
	if($value !=0){
	$id= substr($name, 5, strlen($name)-5) ;
	$get = mysql_query('SELECT id, name
	price, shipping FROM products WHERE id = '
	.$id;
	
	while ($get_rows = mysql_fetch_assoc($get)){
	$num++;
	echo $num.' '.$id .'<br/>';
	}
	')
	
	}
	}
	
}






?>