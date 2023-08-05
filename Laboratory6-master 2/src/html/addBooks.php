<?php
//
//  DO NOT MODIFY THIS FILE

  // Enable Error Reporting
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  // Any syntax in the included scripts will presented to HTML
  include 'lab6.php';
  include 'db.php';

  if (isset($_POST["submit"]) && isset($_FILES["csvFile"])) {
  // echo "Processing File: ".$_FILES["csvFile"]["name"];

     // Check file size
    if ($_FILES["csvFile"]["size"] > 10000) {
      if (error_get_last()==NULL)
        header('Content-type: application/json');
      exit(json_encode(array("status"=>"failure","reason"=>"File too large"), JSON_PRETTY_PRINT));
    }
  
    // Allow certain file formats
    if($_FILES["csvFile"]["type"]!="text/csv" ) {
      if (error_get_last()==NULL)
        header('Content-type: application/json');

      exit(json_encode(array("status"=>"failure","reason"=>"Incorrect filetype"), JSON_PRETTY_PRINT));
    }
    
    // Open CSV File
    if (!($csvFile = @fopen($_FILES["csvFile"]["tmp_name"],"r")) ) {
      if (error_get_last()==NULL)
        header('Content-type: application/json');
      exit(json_encode(array("status"=>"failure","reason"=>"Unable to open file"), JSON_PRETTY_PRINT));
    }
    
    // Connect to DB & catch exceptions
    try {
      $db = openDB();
    } catch (Exception $e) {
      if (error_get_last()==NULL)
        header('Content-type: application/json');
      exit(json_encode(array("status"=>"failure","reason"=>$e->getMessage()),JSON_PRETTY_PRINT));    
    }  
    
    // Call importBooks and store JSON output
    $output = importBooks($db, $csvFile);

    // Close DB connection
    closeDB($db);

    // Close the CSV file
    fclose($csvFile);

    // Output as JSON if there weren't any errors
    if (error_get_last()==NULL)
      header('Content-type: application/json');
    
    echo $output;
    
  } else {
?>  
<!DOCTYPE html>
<html>
 <head>
   <title>Add Books</title>
 </head>

 <body>

 <form action='addBooks.php' method='post' enctype='multipart/form-data'>
     Select CSV to Import:
     <input type='file' name='csvFile' id='csvFile'>
     <input type='submit' value='Add Books' name='submit'>
 </form>
</body>
</html>
<?php } ?>
