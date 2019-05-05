<?php

/*  
    ---------------------------------------------------------
    Portfolio 3 - Part 2
    --------------------
    
    CSG6226 - 2019 Semester 1

    By: Ricardo da Paz
    ---------------------------------------------------------

*/

# Stop errors from being displayed
error_reporting(E_ALL && ~E_NOTICE); 

function generateTable($db, $sql) {
    $retVal = '';
    
    $result = $db->query($sql); 
    if (!$result) {
        die('A problem occurred while reading the database');
    }
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $id = (string)$row['id'];
        $name = $row['Name'];
        $gender = $row['Gender'];
        $age = (string)$row['Age'];
        $retVal .= "<tr>\n";
        $retVal .= "<td>" . $id . "</td>\n";
        $retVal .= "<td>" . $name . "</td>\n";
        $retVal .= "<td>" . $gender . "</td>\n";
        $retVal .= "<td>" . $age . "</td>\n";
        $retVal .= "</tr>\n";
    }
    return $retVal;
}

function usage() {
  echo <<<EOF

Portfolio 3 - part 2: HTML Generator
------------------------------------

Usage: php part2.php -p <path_to_db>


EOF;
}

function preamble() {

/*
  e. (partial)
    Generate a static html page to display the two html tables generated in step (d).
*/


  header('Content-Type:text/plain'); 

  echo <<<EOF
  <!DOCTYPE html>
  <html>
  <head>
  <style>
  table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }

  td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
  }

  </style>
  </head>
  <body>

  <h2>Table 1</h2>

  <table>
  <tr>
  <th>ID</th>
  <th>Name</th>
  <th>Gender</th>
  <th>Age</th>
  </tr>
  EOF;
}

/*
  a.
    Start this task by accepting and validating the SQLite database given as a
    command line argument to the script

    php part2.php -p <path_to_db>
*/

$regex = '%\.db$%';
$dummy = '';

try { 
  $options = getopt("p:");
  $path = $options['p'];
}
catch (Exception $e) {
  echo "[-] Caught exception: " . $e->getMessage() . "\n";
}

if ($path == false) {
    usage();
    echo "[-] Please specify a path to the db with -p <path>\n";
}
elseif (file_exists(realpath($path)) && preg_match($regex, $path, $dummy)) {
  preamble();

/*
  b.
    Create a connection to the database name received in step (a)
*/

  $db = new SQLite3($path);

/*
  c.
    Execute SQL queries to fetc hthe data required to populate Table 2 and Table 3
*/

  $sql = "SELECT ID, Name, Gender, Age FROM demographics
          WHERE Gender = 'Female' ORDER BY Age ASC;";
          
  $query_results = generateTable($db, $sql);
  echo $query_results;
  print "</table>\n";

  echo<<<EOF

  <h2>Table 2</h2>

  <table>
  <tr>
  <th>ID</th>
  <th>Name</th>
  <th>Gender</th>
  <th>Age</th>
  </tr>
  EOF;

  $sql = "SELECT ID, Name, Gender, Age from demographics
          WHERE Gender = 'Male' ORDER BY Age DESC;";

/*
  d.
    Generate the two html tables by poulating the data from the queries in the previous step.
*/

  $query_results = generateTable($db, $sql);
  echo $query_results;
  print "</table>\n";

  echo<<<EOF
  </body>
  </html>
  EOF;
} 

else {
  usage();
  echo '[-] Invalid file/path specified' . "\n"; 
}

?>