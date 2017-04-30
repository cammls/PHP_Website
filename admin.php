<?php
include_once('header_nav.html'); ?>
 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>Admin Page</title>
   </head>
   <body>
     <h1>Admin Page</h1>
     <div>
       <?php
       session_start();
       include_once('connect_db.php');
       include_once('User.php');
       $user->getInfo($_SESSION['username']);

       if ($user->getIsAdmin()== false)
       {
         header("Location: index.php");
         exit();
}

       else {
         echo "<div>Welcome on the admin page, ".$user->getUsername()."</div>";
        }

        ?>
     <a href="https://localhost/php_rush.com/user_admin.php">Manage users</a>
     <a href="https://localhost/php_rush.com/product_admin.php">Manage products</a>
     <a href="https://localhost/php_rush.com/category_admin.php">Manage categories</a>
   </div>
   </body>
 </html>
