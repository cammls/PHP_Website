<?php
session_start();
include_once('connect_db.php');
include_once('product.php');
include_once('User.php');
include_once('header_nav.html');
$user->getInfo($_SESSION['username']);

if ($user->getIsAdmin()==false)
{
	header("Location: index.php");
  exit();
}
else
{
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Admin Page - Products</title>
  </head>
  <body>
    <h1>Admin Page - Products</h1>
		<div>
			<a href="product_create.php">Create a product</a>
		</div>
<table>
     <tr>
   <th>Id</th>
   <th>Name</th>
   <th>Price</th>
   <th>Delete product</th>
   <th>Edit product</th>
 </tr>

 <?php

$product = new Product($db);
$product->displayProduct();

}
?>
</table>
</html
