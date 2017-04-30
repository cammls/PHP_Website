<?php

session_start();
include_once('connect_db.php');
include_once('category.php');
include_once('User.php');

$user->getInfo($_SESSION['username']);

if ($user->getIsAdmin())

{
	$category = new Category($db);
	$category->deleteCategory($_GET['del']);
	header("Location: category_admin.php");
	exit();
}
else
{
  header("Location: index.php");
  exit();

}
?>
