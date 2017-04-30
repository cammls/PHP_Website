<?php
session_start();
include_once('connect_db.php');
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
    <title>Admin Page - Users</title>
  </head>
  <body>
    <h1>Admin Page - Users</h1>
      <div>
      <a href="https://localhost/php_rush.com/user_create.php">Create user</a>
      </div>
    <table>
      <tr>
    <th>Id</th>
    <th>Username</th>
    <th>Email</th>
    <th>Delete User</th>
    <th>Edit User</th>
  </tr>

  <?php $user->DisplayUsers();  ?>

</table>
</body>
</html>

  <?php
}


 ?>
