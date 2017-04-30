<?php
include_once('connect_db.php');
class User
{
  private $db;
  public $row;
  public $username;
  public $email;
  public $id;
  public $hashed_password;
  public $is_admin;


  function __construct($param_db)
  {
    $this->db = $param_db;
  }

 // TO REGISTER THE USER
  function checkUsername($param_username)
  {
    if (isset($param_username) && strlen($param_username) >=3 && strlen($param_username)<=10)
    {
      if ($this->nameExists($param_username)) // si la requete trouve le meme name, elle "fetch" toute la ligne de la db.
      {
        echo "this username is already taken. Please choose another one.";
      }

      else
      {
        $username = htmlspecialchars($param_username);
        return $username;
       // echo $username.":nom valide\n";
      }
    }

    else
    {
      echo "<div>Invalid username</div>";
    }
  }


  function emailExists($param_email)
  {
    $stmt = $this->db->prepare("SELECT * FROM users where email = ?");
    $stmt->execute(array($param_email));
    if ($this->row = $stmt->fetch()) // si la requete trouve un email, elle "fetch" toute la ligne de la db.
    {
      return true;
    }

    else
    {
      return false;
    }
  }
  function nameExists($param_name)
  {
    //prepared requete qui va chercher si le name existe deja
    $stmt = $this->db->prepare("SELECT * FROM users where username = ?");
    $stmt->execute(array($param_name));
    if ($this->row = $stmt->fetch()) // si la requete trouve le meme name, elle "fetch" toute la ligne de la db.
    {
        // echo $this->row['username'].": this username is already taken. Please choose another one.";
        return true;
    }
    else
    {
      return false;
    }
  }


  function Login($param_email, $param_password)
  {
    if ($this->emailExists($param_email))
    {
    // On récup le password hashed et on le stocke dans une variable.
      $hashed_password = $this->row['password'];

      if (password_verify($param_password, $hashed_password)) // on vérifie que le password entré et le hashed password de la db sont les memes.
      {
      // the user exist and his password is correct, he is now "logged in"
      // on stocke le name dans une variable de session pour s'en souvenir sur toutes les pages du site
        $_SESSION['login']= true;
        $_SESSION['username']= $this->row['username'];

        if (isset($_POST['remember_me'])) // si le user wants to be remembered
        {
        //on cree des cookies en plus. Safe ?? (geckos) cookie username pas safe, we should use a token
          setcookie('login',true ,time()+315360000, null, null, false, true);
          setcookie('username',$_SESSION['username'],time()+315360000, null, null, false, true);
        }
        header("Location: https://localhost/php_rush.com/index.php");
        exit();
      }

      else
      {
        echo "Wrong password";
      }
    }

    else
    {
      echo "Wrong email";
    }
  }


  function checkEmail($param_email)
  {
    if (filter_var($param_email))
    {
      if ($this->emailExists($param_email) == true)
      {
        echo $this->row['email'].': <div>this email already has an account. You can login <a href="https://localhost/php_rush.com/login.php">Here</a>.</div>';
      }

      else
      {
        $email = htmlspecialchars($param_email);
        return $email;
      }
    }

    else
    {
      echo "<div>Invalid email</div>";
    }
  }


  function createPassword($param_password, $param_passwordconf)
  {
    if (isset($param_password) &&  strlen($param_password) >=3 && strlen($param_password)<=10 && $param_password== $param_passwordconf)
    {
    // echo "the passwords are the same";
      $options = ['cost' => 12,];
      $password =password_hash(htmlspecialchars($param_password), PASSWORD_BCRYPT, $options);
      return $password;
    }

  else
  {
    echo "<div>Invalid password or password confirmation</div>";
  }
}


  function register($username,$email,$password)
  {
    $date= date("Y-m-d");
    $stmt = $this->db->prepare("INSERT INTO users (username, password, email,created_at) VALUES (:username, :password, :email,:created_at)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':created_at', $date);
    $stmt->execute();

    echo "<div>You have successfully subscribed to our service.</div>";
  }

  function getInfo($username)
  {
    $stmt = $this->db->prepare("SELECT * FROM users where username = ?");
    $stmt->execute(array($username));
    $this->row = $stmt->fetch();
    $this->username = $this->row['username'];
    $this->email = $this->row['email'];
    $this->id = $this->row['id'];
    $this->hashed_password = $this->row['password'];
    $this->is_admin = $this->row['is_admin'];

  }


  function getUsername()
  {
    return $this->username;
  }
  function getEmail()
  {
    return $this->email;
  }
  function getId()
  {
    return $this->id;
  }
  function getHashedPass()
  {
    return $this->hashed_password;
  }
  function getIsAdmin()
  {
    return $this->is_admin;
  }

  function UpdateUsername($new_username,$id)
  {
    // on fais une requete preparee pour updater la database
    $stmt = $this->db->prepare("UPDATE users SET username = :username WHERE id= :id");
    $stmt->execute(array(':username'=>$new_username, ':id'=>$id));
      // On modifie la variable $username
    $this->username =$new_username;
  }
  function UpdateEmail($new_email,$id)
  {
    $stmt = $this->db->prepare("UPDATE users SET email = :email WHERE id= :id");
    $stmt->execute(array(':email'=>$new_email, ':id'=>$id));
    // On modifie la variable $email
    $this->email = $new_email;
  }
  function UpdatePassword($new_hashedpass,$id)
  {
    $stmt = $this->db->prepare("UPDATE users SET password = :password WHERE id= :id");
    $stmt->execute(array(':password'=>$new_hashedpass,':id'=>$id));
    //on modifie la variable
    $this->hashed_password= $new_hashedpass;
  }

  function DisplayUsers()
  {
      echo "<div>All users are listed below.</div>";
      $stmt = $this->db->query("SELECT id,username,email FROM users ORDER BY id");
      foreach($stmt as $this->row)
      {
        echo "<tr><td>"
        .$this->row['id']
        ."</td><td>"
        .$this->row['username']
        ."</td><td>"
        .$this->row['email']
        ."</td><td><a href='user_delete.php?del=" . $this->row['id'] . "'>delete</a></td>"
        ."<td><a href='user_edit.php?edit=" . $this->row['id'] . "'>edit</a></td></tr>";
    }
  }

  function DeleteUser($param_id)
  {
      $stmt = $this->db->prepare("DELETE FROM users WHERE id= ?");
      $stmt->execute(array($param_id));

  }


  function getUser_username($id)
  {
    $stmt = $this->db->prepare("SELECT * FROM users where id = ?");
    $stmt->execute(array($id));
    $row = $stmt->fetch();
    $user_username=$row['username'];
    return $user_username;
  }

  function getUser_Email($id)
  {
    $stmt = $this->db->prepare("SELECT * FROM users where id = ?");
    $stmt->execute(array($id));
    $row = $stmt->fetch();
    $user_email=$row['email'];
    return $user_email;
  }
  function getUser_HashedPass($id)
  {
    $stmt = $this->db->prepare("SELECT * FROM users where id = ?");
    $stmt->execute(array($id));
    $row = $stmt->fetch();
    $user_hashed_password =$row['password'];
    return $user_hashed_password ;
  }

}

$user= new User($db);

?>
