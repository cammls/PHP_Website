<?php
session_start();
include_once('connect_db.php');
include_once('User.php');
if (!isset($_SESSION['login']) && !isset($_COOKIE['login'])) //user is not logged in
{
  header("Location: https://localhostphp_rush.com/index.php");
  exit();
}
else //user is logged in
{
  $modif=0;

  if (isset($_SESSION['login']))
  {
    $user->getInfo($_SESSION['username']);
  }
  else // user qui a voulu etre remembered
  {
    $user->getInfo($_COOKIE['username']);
  }

  if (isset($_POST['update'])) // if the user clicked on the "update your info" button
  {
    $id= $user->getId();
    //on gère le name
    if (isset($_POST['username']) && strlen($_POST['username']) >=3 && strlen($_POST['username'])<=10)
    {
      $username= $user->getUsername();
      if ($_POST['username'] != $username) //on checke que le user a voulu modifier son name
      {
        if ($user->nameExists($_POST['username']) == false)
        {
          $modif = $modif+1;
          $user->UpdateUsername($_POST['username'],$id);
          // On modifie $_SESSION et $_COOKIE si il y en a
          $_SESSION['username'] = $_POST['username'];
          if (isset($_COOKIE['login']))
          {
            setcookie('username',$_POST['username'],time()+315360000, null, null, false, true);
          }
        }
        else {
          echo "this username is already taken. Please choose another one.";
        }
      }
    }
    else
    {
      echo "<div> Your new username must contain 3 characters minimum and 10 characters maximum.</div>";
    }

    //on gere le email
    if (filter_var($_POST['email']))
    {
      $email= $user->getEmail();
      if ($_POST['email'] != $email) //on checke que le user a voulu modifier son email
      {
        if ($user->emailExists($_POST['email']) == false)
        {
          $modif = $modif+1;
          $user->UpdateEmail($email,$id);
        }
        else
        {
          echo "this email is already linked to another account.";
        }
      }
    }
    else
    {
      echo "<div>Invalid email</div>";
    }

    //on gere le new password
    if (isset($_POST['new_password'])&& !empty($_POST["new_password"]))
    {
      $password = htmlspecialchars($_POST['password']);
      $hashed_password = $user->getHashedPass();
      if (password_verify($password, $hashed_password)) // on vérifie que le password entré et le hashed password de la db sont les memes.
      {
        if (strlen($_POST['new_password']) >=3 && strlen($_POST['new_password'])<=10 )
        {
          //on crypte le password et on le stocke
          $options = ['cost' => 12,];
          $new_password =password_hash(htmlspecialchars($_POST['new_password']), PASSWORD_BCRYPT, $options);
          // on fais une requete preparee pour updater la database
        //call the method
        $user->UpdatePassword($new_password,$id);
          $modif = $modif+1;
        }
        else
        {
          echo "<div>Your new password must contain between 3 and 10 characters.</div>";
        }
      }
      else
      {
        echo "Wrong password.";
      }
    }
    if ($modif >0)
    {
      echo "Your changes have been saved.";
    }
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Settings</title>
  </head>
  <body>
    <h1>Settings</h1>
    <p>
      Modify your account here.<br>
    </p>
<form  action="modify_account.php" method="post">
  <div>
    <label for="username">Username: </label> <input type="text" name="username" value=<?php
    if (isset($_SESSION['login']))
    {
      echo $_SESSION['username'];
    }
    else
    {
      echo $_COOKIE['username'];
    }
    ?> id="username" />
  </div>
  <div>
    <label for="email">Email: </label> <input type="email" name="email" value=<?php echo $user->getEmail(); ?> id="email" />
  </div>
  <div>
    To modify your password:
  </div>
  <div>
    <label for="password"> Your current password :</label> <input type="password" name="password" id="password" />
  </div>
  <div>
    <label for="new_password">New password :</label> <input type="password" name="new_password" id="new_password" />
  </div>
  <div>
    <input type="submit" name="update" value="Update your info" />
  </div>
</form>
</body>
</html>
