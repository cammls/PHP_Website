<?php

session_start();

include_once('connect_db.php');

include_once('product.php');

include_once('User.php');

$user->getInfo($_SESSION['username']);

if ($user->getIsAdmin())

{
	$product = new Product($db);
	$product->deleteProduct($_GET['del']);
	header("Location: product_admin.php");
	exit();
}
else
{
  header("Location: index.php");
  exit();

}
?>
