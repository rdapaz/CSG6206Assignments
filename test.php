<?php

$alpha = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
echo substr($alpha,20) . "\n";
echo substr($alpha,strpos($alpha, 'E', 0), -1) . "\n";
echo substr($alpha,0, strpos($alpha, 'D', 0)) . "\n";

$a = 1;
$b = 2.1;

function sum($val1, $val2) {
    global $a;
    $mysum = $val1 + $val2 + $a;
    return $mysum;
}

/* Multiline
   Comment
*/
# Single-line comment
// Single-line comment

echo "the sum = " . sum($a, $b) . "\n";

for ($i=0; $i<10; $i++) {
  echo $i+1 . "\n";
}

$animals = array("cat", "dog", "lion", "mouse");

foreach ($animals as $item){
    echo $item . "\n";
}

$filename = "/home/rdapaz/projects/CSG6206/test.txt";
$handle = fopen($filename, 'r');
$contents = fread($handle, filesize($filename));
fclose($handle);1

echo $contents;

?>