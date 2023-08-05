<?php
  //
  //  DO NOT MODIFY THIS FILE

  // Enable Error Reporting
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  // Any syntax in the included scripts will presented to HTML
  include 'lab6.php';
  include 'db.php';
    
  // Connect to DB & catch exceptions
  try {
    $db = openDB();
  } catch (Exception $e) {
    if (error_get_last()==NULL)
      header('Content-type: application/json');
    exit(json_encode(array("status"=>"failure","reason"=>$e->getMessage()),JSON_PRETTY_PRINT));    
  }  
    
  // Call importBooks and store JSON output
  $output = resetDB($db);

  // Close DB connection
  closeDB($db);

  // Output as JSON if there weren't any errors
  if (error_get_last()==NULL)
    header('Content-type: application/json');
  echo $output;
?>
