<?php

  function openDB()
  {
    try
    {

      ob_start(); // Surpress error messages

      $db = new mysqli( $GLOBALS['server'],
                        $GLOBALS['username'],
                        $GLOBALS['password'],
                        $GLOBALS['schema'],
                        $GLOBALS['port']);

      ob_end_clean(); // Cleanup error messages that were captured

      if ($db->connect_errno) {
        $error = "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
        error_clear_last();
        throw new Exception($error);
      }

      return $db;

    }
    catch (mysqli_sql_exception $e)
    {
      ob_end_clean(); // Cleanup error messages that were captured
      $error = "Failed to connect to MySQL: ".$e->getMessage();
      error_clear_last();
      throw new Exception($error);
    }

    return NULL;
  }

  function closeDB($db)
  {
    if ($db !=NULL )
      $db->close();
  }

  if(file_exists('credentials.php'))
      include 'credentials.php';

  if(isset($_GET["server"]))
    $server = $_GET["server"];
  if(isset($_GET["username"]))
    $username = $_GET["username"];
  if(isset($_GET["password"]))
    $password = $_GET["password"];
  if(isset($_GET["db"]))
    $schema = $_GET["db"];
  if(isset($_GET["port"]))
    $schema = $_GET["port"];

?>