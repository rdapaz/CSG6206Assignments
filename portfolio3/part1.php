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

$retVal = (0 == '0') ? 'Zero is "zero"' : "Not!" ;

$arrayName = array('one' => 'Ric', 'two' => 2);

echo $arrayName['one'] . "\n";


// foreach ($variable as $key => $value) {
	// code...
// }

echo $retVal . "\n";

$animal = Array('cat', 'mouse', 'dog');

foreach ($animal as $item) {
	echo $item . "\n";
}


for ($i = 0; $i <= 100; $i++){
	echo $i . "\n";

	if ($i == 20) {
		break;
	}
}


$file = '/home/rdapaz/uni/CSG6206/portfolio3/file.txt';
$handle = fopen($file, 'r');
$text = fread($handle, filesize($file));
fclose($handle);

echo $text;




?>