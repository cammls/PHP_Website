<?php
session_start();
include_once('connect_db.php');
include_once('product.php');
include_once('User.php');
include_once('header_nav.html'); 
$user->getInfo($_SESSION['username']);

if ($user->getIsAdmin() == false)
{
	header("Location: index.php");
  exit();
}
else
{
  if(empty($_GET['edit']))
  {
    header("Location: user_admin.php");
    exit();
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Edit user</title>
  </head>
  <body>
    <h1>Admin Page - Users - Edit</h1>
    <form class="" action="user_edit_action.php" method="post">
      <label for="username">Username: </label> <input type="text" name="username" value=<?php echo $user->getUser_username($_GET['edit']); ?> id="username" />
    <div>
      <label for="email">Email: </label> <input type="email" name="email" value=<?php echo $user->getUser_Email($_GET['edit']); ?> id="email" />
    </div>
    <div>
      To modify the password:
    </div>
    <div>
      <label for="password"> Current password :</label> <input type="password" name="password" id="password" />
    </div>
    <div>
      <label for="new_password">New password :</label> <input type="password" name="new_password" id="new_password" />
    </div>
    <div>
    <input type="hidden" name="id" value=<?php echo $_GET['edit']?>/>
  </div>
    <div>
      <input type="submit" name="update" value="Update your info" />
    </div>
  </form>

  </body>
</html>
