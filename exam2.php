<?php

function init($db) {
    $table_vals = array(
                        array('Anna',    'Female',    12),
                        array('Bill',    'Male',      45),
                        array('Chase',   'Male',      22),
                        array('Dorothy', 'Female',    36),
                        array('Emily',   'Female',    11),
                    );

    $sql =  "CREATE TABLE IF NOT EXISTS tblDetails";
    $sql .= "(";
    $sql .= "ID INTEGER PRIMARY KEY, NAME TEXT,";
    $sql .=  "GENDER TEXT, AGE INT";
    $sql .= ");";

    $db->exec($sql);

    foreach ($table_vals as $key){
        $name = $key[0];
        $gender = $key[1];
        $age = $key[2];
        $statement = $db->prepare('INSERT INTO tblDetails (NAME, GENDER, AGE) VALUES (:name, :gender, :age);');
        $statement->bindValue(':name', $name);
        $statement->bindValue(':gender', $gender);
        $statement->bindValue(':age', $age);
        $statement->execute();
    }
    return 0;
}

$db = new SQLite3( 'test.sqlite' );
init($db);

$age1 = NULL; $age2 = NULL; $person1 = NULL; $person2 = NULL;

$results = $db->query("SELECT NAME, MIN(AGE) AS AGE FROM tblDetails WHERE GENDER = 'Female';"); 
while ( $row = $results->fetchArray() ) {
    $person1 = $row["NAME"];
    $age1 = $row["AGE"];
}

$results = $db->query("SELECT NAME, MAX(AGE) AS AGE FROM tblDetails WHERE GENDER = 'Female';"); 
while ( $row = $results->fetchArray() ) {
    $person2 = $row["NAME"];
    $age2 = $row["AGE"];
}

$diff = $age2-$age1;

print "$person2 is $diff years older than $person1" ."\n";
?>