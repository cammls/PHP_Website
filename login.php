<?php
session_start();
include_once('connect_db.php');
include_once('User.php');
//include_once('login.html');
if (isset($_POST['submit'])) // si le form est submit alors:
{
  // on stock les infos rentrées par le user dans des variables. htmlspecialchars pour securité. Suffisant ?? (geckos)
  $email = htmlspecialchars($_POST['email']);
  $password = htmlspecialchars($_POST['password']);

  $user->Login($email,$password);
    }

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">

    <!-- If IE use the latest rendering engine -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Set the page to the width of the device and set the zoon level -->
    <meta name="viewport" content="width = device-width, initial-scale = 1">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <title>Login Page</title>
  </head>
  <body>
    <div class="container">

    <form action="login.php" method="post" class="form-signin">
      <h2 class="form-signin-heading">Please sign in</h2>
      <p>
        If you do not have an account yet, please subscribe <a href="https://localhost/php_rush.com/inscription.php">here</a>.
      </p>
    <label for="email" class="sr-only">Email: </label> <input type="email" name="email" id="email" class="form-control" />
    <label for="password" class="sr-only">Password :</label> <input type="password" name="password" id="password" class="form-control"/>
  <div class="checkbox">
    <label for="remember_me">
      <input type="checkbox" name="remember_me" value="remember_me" id="remember_me">Remember me
    </label>
  </div>
    <input class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="Sign in" />
</form>

</div> <!-- /container -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </body>
</html>
