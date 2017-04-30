<?php
session_start();
function remove_cookie($param_cookie)
{
  setcookie($param_cookie, '', time()-300);

}
if (isset($_COOKIE['login']))
{
  remove_cookie("login");
}
  session_destroy();

header("Location: https://localhost/php_rush.com/login.php");
exit();
 ?>
