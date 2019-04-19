<?php

/* 	Portfolio 3
   	-----------
	
	CSG6226 - 2019 Semester 1

	Ricardo da Paz

	Part a.
		Creation of multidimensional array to store the data
	Part b.
		Store the entries of Table 1 into the array

*/

$data = array(
			array(	"ID" 		=> 1, 
				  	"Name" 		=> "Anna",
					"Gender" 	=> "Female",
					"Age" 		=> 12
				 ),
			array(	"ID" 		=> 2,
					"Name" 		=> "Bill",
					"Gender" 	=> "Male",
					"Age" 		=> 45
				 ),
			array(	"ID" 		=> 3,
					"Name" 		=> "Chase",
					"Gender" 	=> "Male",
					"Age" 		=> 22 
				 ),
			array(	"ID" 		=> 4,
					"Name" 		=> "Dorothy",
					"Gender" 	=> "Female",
					"Age" 		=> 36 
				 ),
			array(	"ID" 		=> 5,
					"Name" 		=> "Emily",
					"Gender" 	=> "Female",
					"Age" 		=> 11
				 ),
			array(	"ID" 		=> 6,
					"Name" 		=> "Dan",
					"Gender" 	=> "Male",
					"Age" 		=> 16
				 ),
			array(	"ID" 		=> 7,
					"Name" 		=> "Bob",
					"Gender" 	=> "Male",
					"Age" 		=> 12
				 ),
			array(	"ID" 		=> 8,
					"Name" 		=> "Cassey",
					"Gender" 	=> "Female",
					"Age" 		=> 33
				 ),
			array(	"ID" 		=> 9,
					"Name" 		=> "Alan",
					"Gender" 	=> "Male",
					"Age" 		=> 25
				 ),
			array(	"ID" 		=> 10,
					"Name" 		=> "Jen",
					"Gender" 	=> "Female",
					"Age" 		=> 32
				 ),
		);

function parseDemographics($data) {

	/* 	Part c. 
			Process the contents of the array to generate
			the demographic data
	*/ 

	$demo = array();
	foreach ($data as $person) {
		if (!array_key_exists($person["Gender"], $demo)) {
			$demo[$person["Gender"]] = array();
		}
		if ($person["Age"] <= 16){
			if (!array_key_exists('16 and below', $demo[$person["Gender"]])) {
				$demo[$person["Gender"]]['16 and below'] = 0;
			}
			$demo[$person["Gender"]]['16 and below']++;
		}
		else if ($person["Age"] > 16){
			if (!array_key_exists('above 16', $demo[$person["Gender"]])) {
				$demo[$person["Gender"]]['above 16'] = 0;
			}
			$demo[$person["Gender"]]['above 16']++;
		}

	}
	return $demo;
}


function generateHistogram($demographic_data) {
	
	header ('Content-Type: image/png');


	# We chose a 16:9 ratio for our histogram and
	# further selected 1000mm length, hence determining
	# the height by: height = (length x 9)/16
	define("WIDTH", 1000);
	define("HEIGHT", (int)(WIDTH*9)/16);
	define("BAR_WIDTH", 150);
	define("MARGIN", 80);
	define("SPACER", 10);
	define('MAX_HEIGHT', 500);
	define('BASE', 10);

	$image = @imagecreatetruecolor(WIDTH, HEIGHT)
	      or die('Cannot Initialize new GD image stream');
	
	$d = $demographic_data;

	$max_val = max(array(
					$d['Male']['above 16'], 
					$d['Male']['16 and below'],
					$d['Female']['above 16'],
					$d['Female']['16 and below']
					) 
			  );

	/* 	
		Create variables for the colours required for the
		histogram.  Note that we captured the colour
		using the eyedropper tool in Paint
	*/

	$grey = imageColorAllocate($image, 150, 150, 150);
	$cyan = imageColorAllocate($image, 110, 188, 193);
	$salmon = imageColorAllocate($image, 218, 120, 112);

	imagefilledrectangle($image, 50, 530, 950, 50, $grey);

	$x1 = MARGIN;
	$y1 = (int) MAX_HEIGHT * (1 - $d['Female']['16 and below']/$max_val);
	$x2 = $x1 + BAR_WIDTH;
	$y2 = BASE;
	imagefilledrectangle($image, $x1, $y1, $x2, $y2, $salmon);
	
	$x1 = $x2 + SPACER;
	$y1 = (int) MAX_HEIGHT * (1 - $d['Female']['above 16']/$max_val);
	$x2 = $x1 + BAR_WIDTH;
	$y2 = BASE;
	imagefilledrectangle($image, $x1, $y1, $x2, $y2, $cyan);

	$x1 = $x2 + MARGIN;
	$y1 = (int) MAX_HEIGHT * (1 - $d['Male']['16 and below']/$max_val);
	$x2 = $x1 + BAR_WIDTH;
	$y2 = BASE;
	imagefilledrectangle($image, $x1, $y1, $x2, $y2, $salmon);
	
	$x1 = $x2 + SPACER;
	$y1 = (int) MAX_HEIGHT * (1 - $d['Male']['above 16']/$max_val);
	$x2 = $x1 + BAR_WIDTH;
	$y2 = BASE;
	imagefilledrectangle($image, $x1, $y1, $x2, $y2, $cyan);

	imagepng($image, '/home/rdapaz/uni/CSG6206/portfolio3/demo.png');
	imagedestroy($image);
}

/*  Part e. 
		Create a SQLite3 database with one database table
 */

$path = "/home/rdapaz/uni/CSG6206/portfolio3/demo.db";
$db = new SQLite3($path);
$db->enableExceptions(true);

/* We will now create the table in our database to store
 the data in our array
 */

$sql =<<<EOF
	CREATE TABLE IF NOT EXISTS demographics
	(
		id integer PRIMARY KEY,
		Name TEXT,
		Gender TEXT,
		Age INT
	);
EOF;

try {
	$ret = $db->exec($sql);
} 
catch (Exception $e) {
	echo 'Caught Exception: ' . $e.getMessage();
}


/* 
	Part f.
		Store the contents of the array into the database
		table.
 */

$sql = "INSERT INTO demographics
		(Name, Gender, Age)
		VALUES (?, ?, ?);";

foreach ($data as $p) {
	try {
		$smt = $db->prepare($sql);
		$smt->bindValue(1, $p['Name'], SQLITE3_TEXT);
		$smt->bindValue(2, $p['Gender'], SQLITE3_TEXT);
		$smt->bindValue(3, $p['Age'], SQLITE3_TEXT);
		$insert = $smt->execute();
	} 
	catch (Exception $e) {
		echo 'Caught Exception: ' . $e.getMessage();
	}
}

$var = parseDemographics($data);
generateHistogram($var);

?>