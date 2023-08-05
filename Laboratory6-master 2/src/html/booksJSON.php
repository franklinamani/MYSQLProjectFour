<?php
//
//  DO NOT MODIFY THIS FILE

  // Enable Error Reporting
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  // Any syntax in the included scripts will presented to HTML
  include 'lab6.php';
  include 'db.php';


  $OriginalBooks = json_decode (<<<EOT
[
["PublisherID","PublisherName","SeriesISBN","SeriesTitle","SeriesPosition","ISBN","Title","PublishDate","AuthorID","AuthorName","DateOfBirth","RoyaltyPercent","LeadAuthor","AuthorPosition"],
[null,null,null,null,null,null,null,null,"1003","Hed Tighe","1980-01-01",null,null,null],
["10001","HarperCollins",null,null,null,"9780060244880","The Chronicles of Narnia","2007-08-14","1001","C. S. Lewis","1898-11-29","20.0","Y","1"],
["10001","HarperCollins",null,null,null,"9780060598242","The Chronicles of Narnia","2004-10-26","1001","C. S. Lewis","1898-11-29","12.0","Y","1"],
["10001","HarperCollins",null,null,null,"9780007525515","The Hobbit & The Lord of the Rings","2007-04-17","1000","J. R. R. Tolkien","1892-01-03","5.0","Y","1"],
["10001","HarperCollins",null,null,null,"9780261102385","The Lord of the Rings","2007-04-17","1000","J. R. R. Tolkien","1892-01-03","1.6","Y","1"],
["10001","HarperCollins","9780060244880","The Chronicles of Narnia","1","9780060234973","The Magician's Nephew","2007-08-14","1001","C. S. Lewis","1898-11-29","15.0","Y","1"],
["10001","HarperCollins","9780060244880","The Chronicles of Narnia","2","9780060234812","The Lion, the Witch and the Wardrobe","2007-08-14","1001","C. S. Lewis","1898-11-29","15.0","Y","1"],
["10001","HarperCollins","9780060244880","The Chronicles of Narnia","3","9780060234881","The Horse and His Boy","2007-08-14","1001","C. S. Lewis","1898-11-29","15.0","Y","1"],
["10001","HarperCollins","9780060244880","The Chronicles of Narnia","4","9780060234836","Prince Caspian","2007-08-14","1001","C. S. Lewis","1898-11-29","15.0","Y","1"],
["10001","HarperCollins","9780060244880","The Chronicles of Narnia","5","9780060234867","The Voyage of the Dawn Treader","2007-08-14","1001","C. S. Lewis","1898-11-29","15.0","Y","1"],
["10001","HarperCollins","9780060244880","The Chronicles of Narnia","6","9780060234959","The Silver Chair","2007-08-14","1001","C. S. Lewis","1898-11-29","15.0","Y","1"],
["10001","HarperCollins","9780060244880","The Chronicles of Narnia","7","9780060234935","The Last Battle","2007-08-14","1001","C. S. Lewis","1898-11-29","15.0","Y","1"],
["10001","HarperCollins","9780007525515","The Hobbit & The Lord of the Rings","1","9780261102217","The Hobbit","2007-04-17","1000","J. R. R. Tolkien","1892-01-03","3.0","Y","1"],
["10001","HarperCollins","9780007525515","The Hobbit & The Lord of the Rings","2","9780261102354","The Fellowship of the Ring","2007-04-17","1000","J. R. R. Tolkien","1892-01-03","1.2","Y","1"],
["10001","HarperCollins","9780007525515","The Hobbit & The Lord of the Rings","3","9780261102361","The Two Towers","2007-04-17","1000","J. R. R. Tolkien","1892-01-03","1.3","Y","1"],
["10001","HarperCollins","9780007525515","The Hobbit & The Lord of the Rings","4","9780261102378","Return of the King","2007-04-17","1000","J. R. R. Tolkien","1892-01-03","1.4","Y","1"],
["10001","HarperCollins","9780261102385","The Lord of the Rings","1","9780261102354","The Fellowship of the Ring","2007-04-17","1000","J. R. R. Tolkien","1892-01-03","1.2","Y","1"],
["10001","HarperCollins","9780261102385","The Lord of the Rings","2","9780261102361","The Two Towers","2007-04-17","1000","J. R. R. Tolkien","1892-01-03","1.3","Y","1"],
["10001","HarperCollins","9780261102385","The Lord of the Rings","3","9780261102378","Return of the King","2007-04-17","1000","J. R. R. Tolkien","1892-01-03","1.4","Y","1"],
["10000","Houghton Mifflin Harcourt",null,null,null,"9780012345678","A New Series","2020-01-01","1002","Erez Osiris","1990-01-01","0.0","Y","1"],
["10000","Houghton Mifflin Harcourt",null,null,null,"9780618968633","The Hobbit","2007-09-21","1000","J. R. R. Tolkien","1892-01-03","1.5","Y","1"],
["10002","Pearson",null,null,null,"9780133970777","Fundamentals of Database Systems (7th Edition)","2015-06-08","1007","Ramez Elmasri","1973-01-01","5.0","N","1"],
["10002","Pearson",null,null,null,"9780133970777","Fundamentals of Database Systems (7th Edition)","2015-06-08","1008","Shamkant B. Navathe","1974-01-01","5.0","Y","2"],
["10002","Pearson",null,null,null,"9780133544619","Modern Database Management (12th Edition)","2015-07-13","1004","Jeffery A. Hoffer","1970-01-01","10.0","Y","1"],
["10002","Pearson",null,null,null,"9780133544619","Modern Database Management (12th Edition)","2015-07-13","1005","V. Ramesh","1971-01-01","2.0","N","2"],
["10002","Pearson",null,null,null,"9780133544619","Modern Database Management (12th Edition)","2015-07-13","1006","Heikki Topi","1972-01-01","2.0","N","3"],
["10003","Scribner",null,null,null,"9781451664829","The Space Trilogy","2011-09-20","1001","C. S. Lewis","1898-11-29","20.0","Y","1"],
["10003","Scribner","9781451664829","The Space Trilogy","1","9780743234900","Out of the Silent Planet","1996-10-01","1001","C. S. Lewis","1898-11-29","5.0","Y","1"],
["10003","Scribner","9781451664829","The Space Trilogy","2","9780743234917","Perelandra","1996-10-01","1001","C. S. Lewis","1898-11-29","5.0","Y","1"],
["10003","Scribner","9781451664829","The Space Trilogy","3","9780743234924","That Hideous Strength","1996-10-01","1001","C. S. Lewis","1898-11-29","5.0","Y","1"]
]
EOT
  );

  // Connect to DB & catch exceptions
  try {
    $db = openDB();
  } catch (Exception $e) {
    if (error_get_last()==NULL)
      header('Content-type: application/json');
    exit(json_encode(array("status"=>"failure","reason"=>$e->getMessage()),JSON_PRETTY_PRINT));    
  }
  
  $output = queryBooks($db);
  
  // Close DB connection
  closeDB($db);

  if (error_get_last()==NULL)
    header('Content-type: application/json');

  echo $output;

?>