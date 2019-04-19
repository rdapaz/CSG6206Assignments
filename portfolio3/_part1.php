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
			array(	"ID" => 1, 
				  	"Name" => "Anna",
					"Gender" => "Female",
					"Age" => 12
				 ),
			array(	"ID" => 2,
					"Name" => "Bill",
					"Gender" => "Male",
					"Age" => 45
				 ),
			array(	"ID" => 3,
					"Name" => "Chase",
					"Gender" => "Male",
					"Age" => 22 
				 ),
			array(	"ID" => 4,
					"Name" => "Dorothy",
					"Gender" => "Female",
					"Age" => 36 
				 ),
			array(	"ID" => 5,
					"Name" => "Emily",
					"Gender" => "Female",
					"Age" => 11
				 ),
			array(	"ID" => 6,
					"Name" => "Dan",
					"Gender" => "Male",
					"Age" => 16
				 ),
			array(	"ID" => 7,
					"Name" => "Bob",
					"Gender" => "Male",
					"Age" => 12
				 ),
			array(	"ID" => 8,
					"Name" => "Cassey",
					"Gender" => "Female",
					"Age" => 33
				 ),
			array(	"ID" => 9,
					"Name" => "Alan",
					"Gender" => "Male",
					"Age" => 25
				 ),
			array(	"ID" => 10,
					"Name" => "Jen",
					"Gender" => "Female",
					"Age" => 32
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
	
}

/*  Part e. 
		Create a SQLite3 database with one database table
 */

$path = "/home/rdapaz/uni/CSG6206/portfolio3/demo.db";
$db = new PDO('sqlite:' . $path);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

$ret = $db->exec($sql);


/* 
	Part f.
		Store the contents of the array into the database
		table.
 */

$sql = "INSERT INTO demographics
		(Name, Gender, Age)
		VALUES (:name, :gender, :age);";
$smt = $db->prepare($sql);
$smt->bindParam(':name', $name);
$smt->bindParam(':gender', $gender);
$smt->bindParam(':age', $age);

foreach ($data as $p) {
	$name = $p['Name'];
	$gender = $p['Gender'];
	$age = $p['Age'];
	$insert = $smt->execute();
}

$var = parseDemographics($data);
var_dump($var);

?>