<?php
//
//  YOUR NAME HERE!
//  YOUR ID HERE!
// 
//  lab6.php
//
// The purpose of this lab is to gain experience normalizing a poorly
// structured database from a single 1NF relation into many well structured
// 3NF relations. You will start with a web page that displays the 1NF table,
// and end with a web page that displays an identical table, this time queried
// from your 3NF tables. Your job is to import the data from a CSV file into 
// the database. Once complete, you will put your SQL abilities to the test as 
// you try to recreate the original table.

  $server   = "db";
  $username = "cmpt310";
  $password = "GE=8vr";
  $schema   = "Lab6";
  $port     = 3306;

  function importBooks($db, $csvFile) {

    // Variable to store the number of rows added to the DB
    $nRows = 0;

    // Your solution goes here
    $line = fgets($csvFile);

    while (!feof($csvFile)){
      //getting the line
      $line = fgets($csvFile);
      //converting it into an array 
      $lineArray = str_getcsv($line);
      //storing all the data in the array into the relevant variables 
      $publisherId = $lineArray[0];
      $publisherName = $lineArray[1];
     // if ($publisherId != "NULL" && $publisherName != "NULL"){
        //echo $publisherId;
        //$nRows = $nRows+1;
    //  }
      $seriesIsbn = $lineArray[2]; 
      $seriesTitle = $db-> real_escape_string($lineArray[3]);
      $seriesPosition = $lineArray[4];
      $isbn =$lineArray[5];
      $title = $db-> real_escape_string($lineArray[6]);
      $publishDate = $lineArray[7];
      $authorId = $lineArray[8];
      $authorName = $lineArray[9];
      $date = $lineArray[10];
      $royalPercent = $lineArray[11];
      $leadAuthor = $lineArray[12];
      if($leadAuthor == "Y" && $leadAuthor != "NULL"){
        $leadAuthor = "true";
      }else if($leadAuthor == "N" && $leadAuthor != "NULL"){
        $leadAuthor = "false";
      }
      $authorPosition = $lineArray[13];
      
      
     if ($publisherId != "NULL" && $publisherName != "NULL"){
      $querryone ="INSERT IGNORE INTO Publisher (ID, Name) VALUES ($publisherId, '$publisherName') ";
      $db -> query($querryone);
  
      $nRows = $nRows+1;
     }
      
      if ($authorId != "NULL" && $authorName != "NULL" && $date != "NULL"){
        $querrytwo = "INSERT IGNORE INTO Author (ID, Name, DateOfBirth) VALUES ($authorId, '$authorName', '$date') ";
        $db -> query($querrytwo);
        $nRows = $nRows+1;
      }
      // ($db) {
      //   ec
      //   $nRows = $nRows+1;
      // }

      if ($isbn != "NULL" && $authorId != "NULL" && $royalPercent != "NULL" && $leadAuthor != "NULL" && $authorPosition != "NULL"){
        $querryfive = "INSERT IGNORE INTO Authorship (Book_ISBN, Author_ID, RoyaltyPercent, LeadAuthor, Position) VALUES ($isbn, $authorId, $royalPercent, $leadAuthor, $authorPosition)";
        $db -> query($querryfive);
        $nRows = $nRows+1;
      }

    }
  
    // RETURN JSON SHOWING SUCCESS / FAILURE AND THE NUMBER OF ROWS / OR CAUSE RESPECTIVELY
    return json_encode(array("status"=>"success", "nRows"=>$nRows), JSON_PRETTY_PRINT);

  }

  function queryBooks($db) {
    // echo "were in";

    $booksTable = "SELECT 
    Book.Publisher_ID,
    Publisher.Name AS PublisherName,
    Volume.Series_Book_ISBN AS SeriesISBN, 
    Book.Title As SeriesTitle, 
    Volume.Position AS SeriesPosition, 
    Authorship.Book_ISBN AS ISBN, 
    Book.Title,
    Book.PublishDate AS PublishDate, 
    Author.ID AS AuthorID, 
    Author.Name AS AuthorName, 
    Author.DateOfBirth,  
    Authorship.RoyaltyPercent, 
    IF(ISNULL(Authorship.LeadAuthor), NULL, IF(Authorship.LeadAuthor = 1, \"Y\", \"N\")) AS LeadAuthor,
    Authorship.Position AS AuthorPostion
  
  
  FROM 
    Author 
    LEFT JOIN Authorship ON Author.ID = Authorship.Author_ID 
    LEFT JOIN Book ON Book.ISBN = Authorship.Book_ISBN 
    LEFT JOIN Volume ON  Volume.Volume_Book_ISBN = Book.ISBN 
    LEFT JOIN Book AS SeriesBook  ON Volume.Series_Book_ISBN = SeriesBook.ISBN 
    LEFT JOIN Publisher ON Publisher.ID = Book.Publisher_ID
  
  ORDER BY Publisher.ID;";
    $result  =$db -> query($booksTable);
    
    $output = [ 
      ["PublisherID", "PublisherName", "SeriesISBN", "SeriesTitle", "SeriesPosition", "ISBN", "Title", "PublishDate", "AuthorID", "AuthorName", "DateOfBirth", "RoyaltyPercent", "LeadAuthor", "AuthorPostion"],
    ];

        if ($result) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $output[] = [$row["Publisher_ID"], $row ["PublisherName"], $row["SeriesISBN"], $row["SeriesTitle"], $row["SeriesPosition"], $row["ISBN"], $row["Title"], $row["PublishDate"], $row["AuthorID"], $row["AuthorName"], $row["DateOfBirth"], $row["RoyaltyPercent"], $row["LeadAuthor"], $row["AuthorPostion"]];
      }
    } else {
      echo "0 results";
    }
    
    


    // Your solution goes here
    
    // YOU NEED TO REPLACE THIS LINE WITH THE RESULTS OF YOUR QUERY
    return json_encode($output, JSON_PRETTY_PRINT);

  }
  
  // YOU DO NOT NEED TO MODIFY THIS FUNCTION
  // YOUR DATABASE SCHEMA SHOULD BE CONSTRUNCTED
  // IN THE FILE initialize.sql
  function resetDB($db) {

    // load SQL statments from file 
    $sql = file_get_contents("../sql/initialize.sql");
    
    // Execute ALL of the SQL statements
    $result = $db->multi_query($sql);
    
    // Iterate through all query results
    // Ignore anything that was successful
    while ( $result && $db->more_results() ) {
      // Free the result if not a boolean
      if( !$db->next_result()) {
        // Free the result or flag an error
        if($next = $db->store_result()) {
          $next->free();
        } else {
          $result=false;
        }
      }
    }
    
    // Return success/failure JSON
    if($result) {
      return json_encode(array("status"=>"success", "result"=>"DB Reset"), JSON_PRETTY_PRINT);
    } else {
      return json_encode(array("status"=>"failure", "result"=>"$db->error"), JSON_PRETTY_PRINT);
    }
  }

?>
