<?php

/*     Portfolio 3
       -----------
    
    CSG6226 - 2019 Semester 1

    Ricardo da Paz

    Part a.
        Creation of multidimensional array to store the data
    Part b.
        Store the entries of Table 1 into the array

*/

$data = array(
            array(  "ID"  		=> 1, 
                    "Name"     	=> "Anna",
                    "Gender"    => "Female",
                    "Age"       => 12
                 ),
            array(  "ID"       	=> 2,
                    "Name"      => "Bill",
                    "Gender"    => "Male",
                    "Age"       => 45
                 ),
            array(  "ID"       	=> 3,
                    "Name"      => "Chase",
                    "Gender"    => "Male",
                    "Age"       => 22 
                 ),
            array(  "ID"        => 4,
                    "Name"      => "Dorothy",
                    "Gender"    => "Female",
                    "Age"       => 36 
                 ),
            array(  "ID"		=> 5,
                    "Name"      => "Emily",
                    "Gender"    => "Female",
                    "Age"       => 11
                 ),
            array(  "ID"      	=> 6,
                    "Name"      => "Dan",
                    "Gender"    => "Male",
                    "Age"       => 16
                 ),
            array(  "ID"      	=> 7,
                    "Name"      => "Bob",
                    "Gender"    => "Male",
                    "Age"       => 12
                 ),
            array(  "ID"      	=> 8,
                    "Name"      => "Cassey",
                    "Gender"    => "Female",
                    "Age"       => 33
                 ),
            array(  "ID"      	=> 9,
                    "Name"      => "Alan",
                    "Gender"    => "Male",
                    "Age"       => 25
                 ),
            array(  "ID"      	=> 10,
                    "Name"      => "Jen",
                    "Gender"    => "Female",
                    "Age"       => 32
                 ),
        );

function parseDemographics($data) {

    /*     Part c. 
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
    
    /*     Part d. 
            Generate a histogram from the summary
            demographics worked out in part (c)
    */ 

    header ('Content-Type: image/png');


    # We chose a 16:9 ratio for our histogram and
    # further selected 1000mm length, hence determining
    # the height by: height = (length x 9)/16
    define("WIDTH", 1000);
    define("HEIGHT", (int)(WIDTH*9)/16);
    define("BAR_WIDTH", 150);
    define("MARGIN", 80);
    define("SPACER", 0);
    define('BAR_TOP', 450);
    define('BAR_BASE', 50);

    $image = @imagecreatetruecolor(WIDTH, HEIGHT)
          or die('Cannot Initialize new GD image stream');
    
    $d = $demographic_data;

    $max_val = max(array(
                    $d['Male']['above 16'] + $d['Male']['16 and below'],
                    $d['Female']['above 16'] + $d['Female']['16 and below']
                    ) 
              );
    /*     
        Create variables for the colours required for the
        histogram.  Note that we captured the colour
        using the eyedropper tool in Paint
    */

    $grey = imageColorAllocate($image, 150, 150, 150);
    $lt_grey = imageColorAllocate($image, 200, 200, 200);
    $dk_grey = imageColorAllocate($image, 32, 32, 32);
    $cyan = imageColorAllocate($image, 110, 188, 193);
    $salmon = imageColorAllocate($image, 218, 120, 112);

    imagefilledrectangle($image, 50, 530, 950, 50, $grey);

    for ($i=0; $i<$max_val; $i++) {
        $tlx = 50;
        $tly = BAR_TOP - (int)((BAR_TOP - BAR_BASE) * $i/$max_val);
        $brx = 4 * BAR_WIDTH + 2 * MARGIN + 2 * SPACER;
        $bry = BAR_TOP - (int)((BAR_TOP - BAR_BASE) * $i/$max_val);
        imageline($image, $tlx, $tly, $brx, $bry, $lt_grey);
    }


    $tlx = MARGIN;
    $tly = BAR_TOP - (int)((BAR_TOP - BAR_BASE) * $d['Female']['16 and below']/$max_val);
    echo $tly . "\n";
    $brx = $tlx + BAR_WIDTH;
    $bry = BAR_TOP;
    imagefilledrectangle($image, $tlx, $tly, $brx, $bry, $salmon);
    
    $tlx = $brx + SPACER;
    $tly = BAR_TOP - (int)((BAR_TOP - BAR_BASE) * $d['Female']['above 16']/$max_val);
    $brx = $tlx + BAR_WIDTH;
    $bry = BAR_TOP;
    imagefilledrectangle($image, $tlx, $tly, $brx, $bry, $cyan);
    imageline($image, $tlx, BAR_BASE, $tlx, BAR_TOP, $lt_grey);

    $tlx = $brx + MARGIN;
    $tly = BAR_TOP - (int)((BAR_TOP - BAR_BASE) * $d['Male']['16 and below']/$max_val);
    $brx = $tlx + BAR_WIDTH;
    $bry = BAR_TOP;
    imagefilledrectangle($image, $tlx, $tly, $brx, $bry, $salmon);
    
    $tlx = $brx + SPACER;
    $tly = BAR_TOP - (int)((BAR_TOP - BAR_BASE) * $d['Male']['above 16']/$max_val);
    $brx = $tlx + BAR_WIDTH;
    $bry = BAR_TOP;
    imagefilledrectangle($image, $tlx, $tly, $brx, $bry, $cyan);
    imageline($image, $tlx, BAR_BASE, $tlx, BAR_TOP, $lt_grey);

    $font_path = '/usr/share/fonts/truetype/ubuntu/Ubuntu-B.ttf';

    imagettftext($image, 10, 0, (int)BAR_WIDTH + 50, 480, $dk_grey, $font_path, 'Female');

    imagettftext($image, 10, 0, (int)3*BAR_WIDTH + 150, 480, $dk_grey, $font_path, 'Male');

    imagettftext($image, 12, 0, 422, 500, $dk_grey, $font_path, 'Gender');

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