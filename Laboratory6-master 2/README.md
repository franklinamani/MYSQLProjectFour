# CMPT 310 Laboratory 6

The purpose of this lab is to gain experience normalizing a poorly structured database from a single 1NF relation into many well structured 3NF relations. You will start with a web page that displays the 1NF table, and end with a web page that displays an identical table, this time queried from your 3NF tables.

```plantuml
skinparam nodesep 100
skinparam ranksep 100

left to right direction
skinparam class{
    AttributeIconSize 0
    BackgroundColor none
    ArrowColor black
    BorderColor black
    FontStyle bold
}

skinparam note{
    BorderColor black
    BackgroundColor none
}

hide circle
hide empty methods
hide empty members


entity Volume {
  <u>**Series_Book_ISBN**</u>
  <u>**Volume_Book_ISBN**</u>
  **Position**
}

entity Book {
  <u>**ISBN**</u>
  **Title**
  PublishDate
  **Publisher_ID**
}

entity Publisher {
  <u>**ID**</u>
  **Name**
}

entity Author {
  <u>**ID**</u>
  **Name**
  **DateOfBirth**
}

entity Authorship {
  <u>**Book_ISBN**</u>
  <u>**Author_ID**</u>
  **RoyaltyPercent**
  **LeadAuthor**
  **AuthorPosition**
}

Book "written by" ||-o{    "writes" Authorship
Book "printed by" }o--up-|| "prints" Publisher
Authorship "written by" }o--up-|| "writes" Author
Book "member of" ||---o{ "includes" Volume
Volume "sold as" }o---|| "collection of" Book

```


## Cloning

Start your lab by cloning this repository:

```
$> git clone https://submit.cs.kingsu.ca/PATH/TO/YOUR/REPO.git
```

**Note**: The URL for your repo can be found at https://submit.cs.kingsu.ca.


### Building
```
$> docker-compose up -d
```
**Note**: `docker-compose up` builds, (re)creates, starts, and attaches to containers for a service. The first time it is run, it takes some time to complete. 
**Be aware** you will need at least `1 GB` of disk space to download and run the web and database images of this lab.

### Writing your lab
Any and all changes need to be done in the `src/html/lab6.php` file.

### Running

Open your web browser to:

* http://localhost:8080/books.html
* http://localhost:8080/addBooks.php

### Closing `docker`

```
$> docker-compose down
```

### Submission

```
$> git add src/html/lab6.php
$> git commit -m "Lab 6 Submission"
$> git push
```

### Helpful Hints 

#### SQL
* SQL Syntax: https://dev.mysql.com/doc/refman/8.0/en/sql-statements.html
* SQL CREATE: http://dev.mysql.com/doc/refman/8.0/en/creating-tables.html
* SQL INSERT [IGNORE]: http://dev.mysql.com/doc/refman/8.0/en/insert.html

#### PHP
* str_getcsv() https://www.php.net/manual/en/function.str-getcsv.php
* feof() https://www.php.net/manual/en/function.feof.php
* fgets() https://www.php.net/manual/en/function.fgets.php
* mySQLi :: real_escape_string() https://www.php.net/manual/en/mysqli.real-escape-string.php
* mySQLi :: affected_rows() https://www.php.net/manual/en/mysqli.affected-rows.php

