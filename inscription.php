<?php
include_once('connect_db.php');
include_once('User.php');

if (isset($_POST['submit']))
{
  $username =$user->checkUsername($_POST['username']);

  $email =$user->checkEmail($_POST['email']);

  $password = $user->createPassword($_POST['password'], $_POST['password_confirmation']);
}

if (isset($username) && isset($email) && isset($password))
{
  $user->register($username, $email, $password);
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title> Subscription</title>
</head>
<body>
  <h1>Subscription page</h1>
  <div>
    Fill this form to subscribe to our awesome service.
  </div>
  <form  action="inscription.php" method="post">
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
