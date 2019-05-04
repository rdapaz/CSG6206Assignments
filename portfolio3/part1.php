<?php

/*     
    ---------------------------------------------------------
    Portfolio 3 - Part 1
    ---------------------------------------------------------

    CSG6226 - 2019 Semester 1

    By: Ricardo da Paz

    Part a.
        Creation of multidimensional array to store the data
    Part b.
        Store the entries of Table 1 into the array
    ---------------------------------------------------------

*/

$data = array(
            array(  "ID"        => 1, 
                    "Name"      => "Anna",
                    "Gender"    => "Female",
                    "Age"       => 12
                 ),
            array(  "ID"        => 2,
                    "Name"      => "Bill",
                    "Gender"    => "Male",
                    "Age"       => 45
                 ),
            array(  "ID"        => 3,
                    "Name"      => "Chase",
                    "Gender"    => "Male",
                    "Age"       => 22 
                 ),
            array(  "ID"        => 4,
                    "Name"      => "Dorothy",
                    "Gender"    => "Female",
                    "Age"       => 36 
                 ),
            array(  "ID"        => 5,
                    "Name"      => "Emily",
                    "Gender"    => "Female",
                    "Age"       => 11
                 ),
            array(  "ID"        => 6,
                    "Name"      => "Dan",
                    "Gender"    => "Male",
                    "Age"       => 16
                 ),
            array(  "ID"        => 7,
                    "Name"      => "Bob",
                    "Gender"    => "Male",
                    "Age"       => 12
                 ),
            array(  "ID"        => 8,
                    "Name"      => "Cassey",
                    "Gender"    => "Female",
                    "Age"       => 33
                 ),
            array(  "ID"        => 9,
                    "Name"      => "Alan",
                    "Gender"    => "Male",
                    "Age"       => 25
                 ),
            array(  "ID"        => 10,
                    "Name"      => "Jen",
                    "Gender"    => "Female",
                    "Age"       => 32
                 ),
        );

// ------------------------------------------------------------------------------------------
// TEST CODE
// Get the contents of the JSON file 
$strJsonFileContents = file_get_contents("demo_data.json"); # TODO: Comment out for final run
// Convert to array 
$data = json_decode($strJsonFileContents, true); # TODO: Comment out for final run
// var_dump($data); // print array
// ------------------------------------------------------------------------------------------


function parseDemographics($data) {

    /*     
        ---------------------------------------------
        Part c. 
        Process the contents of the array to generate
        the demographic data
        ---------------------------------------------
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


    /*
        --------------------------------------------------
        We chose a 16:9 ratio for our histogram and
        further selected 1000mm length, hence determining
        the height by: height = (length x 9)/16
        --------------------------------------------------
    */
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

    /* 
        To make this flexible for all data values we need to consider cases where
        the key isn't found (i.e. we do not have a count for that category).  This is 
        done below.
        ------------------------------------------------------------------------------
    */


    $el1 = array_key_exists('Male', $d) && array_key_exists('above 16', $d['Male']) ? 
                    $d['Male']['above 16'] : 0;

    $el2 = array_key_exists('Male', $d) && array_key_exists('16 and below', $d['Male']) ? 
                    $d['Male']['16 and below'] : 0;

    $el3 = array_key_exists('Female', $d) && array_key_exists('above 16', $d['Female']) ? 
                    $d['Female']['above 16'] : 0;

    $el4 = array_key_exists('Female', $d) && array_key_exists('16 and below', $d['Female']) ? 
                    $d['Female']['16 and below'] : 0;

    $max_val = max(array(
                    $el1 + $el2,
                    $el3 + $el4
                    ) 
              );
    /*     
        -----------------------------------------------------------------
        Create variables for the colours required for the
        histogram.  Note that we captured the colour
        using the eyedropper tool in Paint
        -----------------------------------------------------------------
    */

    $font_path = '/usr/share/fonts/truetype/custom/Monaco_Linux.ttf';
    $grey = imageColorAllocate($image, 150, 150, 150);
    $lt_grey = imageColorAllocate($image, 200, 200, 200);
    $dk_grey = imageColorAllocate($image, 32, 32, 32);
    $cyan = imageColorAllocate($image, 110, 188, 193);
    $salmon = imageColorAllocate($image, 218, 120, 112);
    $white = imageColorAllocate($image, 255, 255, 255);

    # Draw grey rectangle
    imagefilledrectangle($image, 50, 50, 950, 530, $grey);

    # Used to fine tune display depending on how many horizontal lines to
    $skip = 1;
    # Draw horizontal grid lines

    /* 
        -----------------------------------------------------------------
        TODO:
        In the event that the data source is changed to the json file
        it is important to change $i++ below to $i += 20 or a suitable
        common divisor of $max_val.  This is to avoid having
        too many horizontal lines
        -----------------------------------------------------------------
    */


    for ($i=0; $i<$max_val; $i+=20) {
        $tlx = 50;
        $tly = BAR_TOP - (int)((BAR_TOP - BAR_BASE) * $i/$max_val);
        $brx = 4 * BAR_WIDTH + 2 * MARGIN + 2 * SPACER;
        $bry = BAR_TOP - (int)((BAR_TOP - BAR_BASE) * $i/$max_val);
        imageline($image, $tlx, $tly, $brx, $bry, $lt_grey);
        imagettftext($image, 10, 0, $tlx+5, $tly-10, $dk_grey, $font_path, $i);
    }


    # Draw the bar for females 16 and below
    $tlx = MARGIN;
    $tly = BAR_TOP - (int)((BAR_TOP - BAR_BASE) * $d['Female']['16 and below']/$max_val);
    echo $tly . "\n";
    $brx = $tlx + BAR_WIDTH;
    $bry = BAR_TOP;
    imagefilledrectangle($image, $tlx, $tly, $brx, $bry, $salmon);
    imagettftext($image, 10, 0, (int)($tlx + 0.5*BAR_WIDTH) , $tly-20, $dk_grey, $font_path, $el4);
    
    # Draw the bar for females above 16
    $tlx = $brx + SPACER;
    $tly = BAR_TOP - (int)((BAR_TOP - BAR_BASE) * $d['Female']['above 16']/$max_val);
    $brx = $tlx + BAR_WIDTH;
    $bry = BAR_TOP;
    imagefilledrectangle($image, $tlx, $tly, $brx, $bry, $cyan);
    imageline($image, $tlx, BAR_BASE, $tlx, BAR_TOP, $lt_grey);
    imagettftext($image, 10, 0, (int)($tlx + 0.5*BAR_WIDTH) , $tly-20, $dk_grey, $font_path, $el3);

    # Draw the bar for males 16 and below
    $tlx = $brx + MARGIN;
    $tly = BAR_TOP - (int)((BAR_TOP - BAR_BASE) * $d['Male']['16 and below']/$max_val);
    $brx = $tlx + BAR_WIDTH;
    $bry = BAR_TOP;
    imagefilledrectangle($image, $tlx, $tly, $brx, $bry, $salmon);
    imagettftext($image, 10, 0, (int)($tlx + 0.5*BAR_WIDTH) , $tly-20, $dk_grey, $font_path, $el2);
    
    # Draw the bar for males above 16
    $tlx = $brx + SPACER;
    $tly = BAR_TOP - (int)((BAR_TOP - BAR_BASE) * $d['Male']['above 16']/$max_val);
    $brx = $tlx + BAR_WIDTH;
    $bry = BAR_TOP;
    imagefilledrectangle($image, $tlx, $tly, $brx, $bry, $cyan);
    imageline($image, $tlx, BAR_BASE, $tlx, BAR_TOP, $lt_grey);
    imagettftext($image, 10, 0, (int)($tlx + 0.5*BAR_WIDTH) , $tly-20, $dk_grey, $font_path, $el1);

    # Draw the white bar at the bottom
    $tlx = 50;
    $tly = 500;
    $brx = 950;
    $bry = HEIGHT;
    imagefilledrectangle($image, $tlx, $tly, $brx, $bry, $white);

    # Draw the white 'insert' at the right
    $tlx = 4 * BAR_WIDTH + 2 * MARGIN + 2 * SPACER + 10;
    $tly = 50;
    $brx = 950;
    $bry = HEIGHT;
    imagefilledrectangle($image, $tlx, $tly, $brx, $bry, $white);

    # Draw the legend

    # Draw the blue box
    $tlx = 4 * BAR_WIDTH + 2 * MARGIN + 2 * SPACER + 40;
    $tly = 300;
    $brx = 4 * BAR_WIDTH + 2 * MARGIN + 2 * SPACER + 60;
    $bry = 320;
    imagefilledrectangle($image, $tlx, $tly, $brx, $bry, $salmon);

    # Draw the salmon box
    $tlx = 4 * BAR_WIDTH + 2 * MARGIN + 2 * SPACER + 40;
    $tly = 340;
    $brx = 4 * BAR_WIDTH + 2 * MARGIN + 2 * SPACER + 60;
    $bry = 360;
    imagefilledrectangle($image, $tlx, $tly, $brx, $bry, $cyan);

    # Draw the text legends on the right

    imagettftext($image, 14, 0, 4 * BAR_WIDTH + 2 * MARGIN + 2 * SPACER + 40, 
                    280, $dk_grey, $font_path, 'Age Group');

    imagettftext($image, 10, 0, 4 * BAR_WIDTH + 2 * MARGIN + 2 * SPACER + 70, 
                    315, $dk_grey, $font_path, '16 and below');

    imagettftext($image, 10, 0, 4 * BAR_WIDTH + 2 * MARGIN + 2 * SPACER + 70, 
                    355, $dk_grey, $font_path, 'above 16');


    # Draw the text legends at the bottom of tge screen

    imagettftext($image, 10, 0, (int)BAR_WIDTH + 50, 480, $dk_grey, $font_path, 'Female');

    imagettftext($image, 10, 0, (int)3*BAR_WIDTH + 150, 480, $dk_grey, $font_path, 'Male');

    imagettftext($image, 12, 0, 422, 550, $dk_grey, $font_path, 'Gender');

    imagettftext($image, 12, 0, 4 * BAR_WIDTH + 2 * MARGIN + 2 * SPACER + 40, 
                    180, $dk_grey, $font_path, 'Count');

    imagepng($image, '/root/Desktop/CSG6206/portfolio3/demo.png');
    imagedestroy($image);

}

/*  
    -------------------------------------------------
    Part e. 
    Create a SQLite3 database with one database table
    -------------------------------------------------
*/

$path = "/root/Desktop/CSG6206/portfolio3/demo.db";
$db = new SQLite3($path);
$db->enableExceptions(true);

/* 
   -----------------------------------------------------
   We will now create the table in our database to store
   the data in our array.  Note that id is automatically
   created
   -----------------------------------------------------
*/

$sql =<<<EOF
    CREATE TABLE IF NOT EXISTS demographics
    (
        id integer PRIMARY KEY,
        Name TEXT,
        Gender TEXT,
        Age INT
    );
    DELETE FROM demographics;
    REINDEX;
EOF;

try {
    $ret = $db->exec($sql);
} 
catch (Exception $e) {
    echo 'Caught Exception: ' . $e->getMessage();
}

/* 
    -------------------------------------------------
    Part f.
    Store the contents of the array into the database
    table.
    -------------------------------------------------
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
        echo 'Caught Exception: ' . $e->getMessage();
        break;
    }
}

$var = parseDemographics($data);
generateHistogram($var);

?>