<?php

error_reporting(E_ALL && ~E_NOTICE); 


function preamble() {

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

<h2>Stats</h2>

<table>
<tr>
<th>Statistics</th>
<th>Count</th>
</tr>
EOF;
return 0;
}


$filename = "/home/rdapaz/projects/CSG6206/alice_in_wonderland.txt";
$handle = fopen($filename, 'r');
$contents = fread($handle, filesize($filename));
fclose($handle);

$sentences = array();
$words = array();

// echo $contents . "\n";

# Counting Vowels
preg_match_all("/[aeiou]/i", $contents, $matches);
$vowels = count($matches[0]);

# Counting Consonants
preg_match_all("/[bcdfghjklmnpqrstvwxyz]/i", $contents, $matches);
$consonants = count($matches[0]);

# Counting Words
preg_match_all("/\w+/i", $contents, $matches);
$words = count($matches[0]);

# Counting Sentences
preg_match_all("/[\"A-Z].*\./m", $contents, $matches);
$sentences = count($matches[0]);

$table_text = "";
$table_text .= "<tr>\n";
$table_text .= "<td>Number of vowels</td>\n";
$table_text .= "<td>" . $vowels . "</td>\n";
$table_text .= "</tr>\n";

$table_text .= "<tr>\n";
$table_text .= "<td>Number of consonants</td>\n";
$table_text .= "<td>" . $consonants . "</td>\n";
$table_text .= "</tr>\n";

$table_text .= "<tr>\n";
$table_text .= "<td>Number of sentences</td>\n";
$table_text .= "<td>" . $sentences . "</td>\n";
$table_text .= "</tr>\n";

$table_text .= "<tr>\n";
$table_text .= "<td>Number of words</td>\n";
$table_text .= "<td>" . $words . "</td>\n";
$table_text .= "</tr>\n";


preamble();
print $table_text;
print "</table>\n";
print "</body>\n";
print "</html>\n";


?>