<?php

/*     Portfolio 3
       -----------
    
    CSG6226 - 2019 Semester 1

    Part II

    Ricardo da Paz

    Part a.
        
    Part b.
        Store the entries of Table 1 into the array

*/

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

$options = getopt("p:");
$path = $options['p'];

if ($path == false) {
    echo "[-] Please specify path\n";
}

// $path = "/home/rdapaz/uni/CSG6206/portfolio3/demo.db";
$db = new SQLite3($path);

$sql = "SELECT ID, Name, Gender, Age from demographics
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

$query_results = generateTable($db, $sql);
echo $query_results;
print "</table>\n";

echo<<<EOF
</body>
</html>
EOF
?>