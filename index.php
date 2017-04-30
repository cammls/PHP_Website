<?php
session_start();
include_once('connect_db.php');
include_once('User.php');
include_once('nav.html');
if (!isset($_SESSION['login']) && !isset($_COOKIE['login'])) //user is not logged in
{
  header("Location: login.php");
exit();
}
  else //user is logged in
  {
    //include_once('header_nav.html');
      if (isset($_COOKIE['login']))
      {
        echo "Hello ".$_COOKIE['username'];
      }
      else
      {
        echo "Hello ".$_SESSION['username'];
      }
      ?>
      <div class="container">
      <div>
      <a href="https://localhost/php_rush.com/logout.php">Logout</a>
    </div>
    <div>
      <a href="https://localhost/php_rush.com/modify_account.php">Settings</a>
    </div>
    <?php
        $user->getInfo($_SESSION['username']);
        if ($user->getIsAdmin()== true)
        {
          echo '<a href="https://localhost/php_rush.com/admin.php">Admin settings</a>';
        }
      }
     ?>
     </div>
     </body>
   </html>
