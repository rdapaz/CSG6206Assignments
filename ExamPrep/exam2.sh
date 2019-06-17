#!/bin/bash

initialise() {
    sqlite3 StaffDB.db "CREATE TABLE IF NOT EXISTS tblDetails 
                        (ID INTEGER PRIMARY KEY,
                         NAME TEXT,
                         GENDER TEXT,
                         AGE INT);"

    sqlite3 StaffDB.db "INSERT INTO tblDetails (NAME, GENDER, AGE) VALUES ('Anna', 'Female', 12);"
    sqlite3 StaffDB.db "INSERT INTO tblDetails (NAME, GENDER, AGE) VALUES ('Bill', 'Male', 45);"
    sqlite3 StaffDB.db "INSERT INTO tblDetails (NAME, GENDER, AGE) VALUES ('Chase', 'Male', 22);"
    sqlite3 StaffDB.db "INSERT INTO tblDetails (NAME, GENDER, AGE) VALUES ('Dorothy', 'Female', 36);"
    sqlite3 StaffDB.db "INSERT INTO tblDetails (NAME, GENDER, AGE) VALUES ('Emily', 'Female', 11);"
    return 0
}

# initialise;

youngestFemale=`sqlite3 StaffDB.db "SELECT NAME, MIN(AGE) FROM tblDetails WHERE GENDER = 'Female';"`
oldestFemale=`sqlite3 StaffDB.db "SELECT NAME, MAX(AGE) FROM tblDetails WHERE GENDER = 'Female';"`

age1=`echo $youngestFemale | awk -F\| '{print $2}'`
person1=`echo $youngestFemale | awk -F\| '{print $1}'`
age2=`echo $oldestFemale | awk -F\| '{print $2}'`
person2=`echo $oldestFemale | awk -F\| '{print $1}'`

echo "$person2 is $((age2-age1)) years older than $person1"

