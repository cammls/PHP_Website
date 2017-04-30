<?php

  define("ERROR_LOG_FILE", "errors.log");
function connect_db($host, $username, $passwd, $port, $db)
{

  try {
    $connexion = new PDO("mysql:host=$host;dbname=$db;port=$port", $username, $passwd);
    // echo "Connection to DB successful\n";
    return $connexion;
}
catch (PDOException $e) {
    print "PDO ERROR: ".$e->getMessage()." storage in ".ERROR_LOG_FILE."\n";
    echo "Error connection to DB\n";
    error_log("Error connection to DB",3,ERROR_LOG_FILE);
    return false;
}
}
$db=connect_db('localhost','root','camille','42','pool_php_rush');
 ?>
