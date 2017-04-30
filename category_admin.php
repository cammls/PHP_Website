<?php
session_start();
include_once('connect_db.php');
include_once('category.php');
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
    <title>Admin Page - Categories</title>
  </head>
  <body>
    <h1>Admin Page - Categories</h1>
		<div>
			<a href="category_create.php">Create a category</a>
		</div>
<table>
     <tr>
   <th>Id</th>
   <th>Name</th>
   <th>Parent id</th>
   <th>Delete category</th>
   <th>Edit category</th>
 </tr>
 <?php

$product = new Category($db);
$product->displayCategory();
?>
</table>
<?php }?>
