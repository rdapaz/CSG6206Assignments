<?php


$a = 1;
$myArray[] = "Ahmed";
$myArray[] = "Ricardo";


echo "$myArray[1]\n";


function sum($val1, $val2) {
	global $a;
	$mySum = $val2 - $val1;
	return $mySum;
}

$sum = sum(22, 2.1);

echo "the sum = " . $sum . "\n";

$retVal = (0 === '0') ? 'Zero is "zero"' : "Not!" ;

$arrayName = array('one' => 1, 'two' => 2);

echo $arrayName['one'] . "\n";


// foreach ($variable as $key => $value) {
	// code...
// }

echo $retVal . "\n";

$days = 1;

echo "Due in $days ${($days == 1) ? 'days' : 'day'}"; 
?>