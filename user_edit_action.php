<?php
include_once('connect_db.php');
include_once('User.php');

$modif=0;
if (isset($_POST['update'])) // if the user clicked on the "update your info" button
{
  $user_username=$user->getUser_username($_POST['id']);
  $user_email=$user->getUser_email($_POST['id']);
  $user_hashed_password=$user->getUser_HashedPass($_POST['id']);
  // echo "apres le if update".$user_username.$user_email.$user_hashed_password;
  //on gère le name

  if (isset($_POST['username']) && strlen($_POST['username']) >=3 && strlen($_POST['username'])<=10)
  {

    if ($_POST['username'] != $user_username) //on checke que le user a voulu modifier son name
    {
      if ($user->nameExists($_POST['username']) == false)
      {
        $user->UpdateUsername($_POST['username'],$_POST['id']);
        $modif= $modif +1;

      }
      else {
        echo "this username is already taken. Please choose another one.";
      }
    }
  }
  else
  {
    echo "<div> The new username must contain 3 characters minimum and 10 characters maximum.</div>";
  }

  //on gere le email
  if (filter_var($_POST['email']))
  {
    if ($_POST['email'] != $user_email) //on checke que le user a voulu modifier son email
    {
      if ($user->emailExists($_POST['email']) == false)
      {
        $user->UpdateEmail($_POST['email'],$_POST['id']);
        $modif= $modif +1;
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

    if (password_verify($_POST['password'], $user_hashed_password)) // on vérifie que le password entré et le hashed password de la db sont les memes.
    {
      if (strlen($_POST['new_password']) >=3 && strlen($_POST['new_password'])<=10 )
      {
        //on crypte le password et on le stocke
        $options = ['cost' => 12,];
        $new_password =password_hash(htmlspecialchars($_POST['new_password']), PASSWORD_BCRYPT, $options);
        // on fais une requete preparee pour updater la database
      //call the method
      $user->UpdatePassword($new_password,$_POST['id']);
      $modif= $modif +1;
      }
      else
      {
        echo "<div>The new password must contain between 3 and 10 characters.</div>";
      }
    }
    else
    {
      echo "Wrong password.";
    }
  }

  if ($modif >0)
  {
    header("Location: user_admin.php");
      exit();
  }
}

 ?>
