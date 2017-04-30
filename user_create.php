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
  if (isset($_POST['submit']))
  {
    $username =$user->checkUsername($_POST['username']);

    $email =$user->checkEmail($_POST['email']);

    $password = $user->createPassword($_POST['password'], $_POST['password_confirmation']);
  }

  if (isset($username) && isset($email) && isset($password))
  {
    $user->register($username, $email, $password);
    header("Location: user_admin.php");
    exit();
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title> Create user page</title>
</head>
<body>
  <h1>Create a user account</h1>
  <div>
    Fill this form to create a new account for a new user.
  </div>
  <form  action="user_create.php" method="post">
    <div>
      <label for="username">Username: </label> <input type="text" name="username" id="username" />
    </div>
    <div>
      <label for="email">Email: </label> <input type="email" name="email" id="email" />
    </div>
    <div>
      <label for="password">Password :</label> <input type="password" name="password" id="password" />
    </div>
    <div>
      <label for="password_confirmation">Confirm password :</label> <input type="password" name="password_confirmation" id="password_confirmation" />
    </div>
    <div>
      <input type="submit" name="submit" value="submit" />
    </div>
  </form>
</body>
</html>
