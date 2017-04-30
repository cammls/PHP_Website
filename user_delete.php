<?php
session_start();
include_once('connect_db.php');
include_once('User.php');
$user->getInfo($_SESSION['username']);

if ($user->getIsAdmin())
{
  $user->DeleteUser($_GET['del']);
  header("Location: user_admin.php");
  exit();

}
else
{
  header("Location: index.php");
  exit();
}

 ?>
