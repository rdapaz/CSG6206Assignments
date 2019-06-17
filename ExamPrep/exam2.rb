#!/usr/bin/ruby

require 'sqlite3'

def init(db)
    sql=<<EOF
    CREATE TABLE IF NOT EXISTS tblDetails 
    (
        ID INTEGER PRIMARY KEY, NAME TEXT,
        GENDER TEXT, AGE INT
    );
EOF
    db.execute(sql)
    db.execute("INSERT INTO tblDetails (NAME, GENDER, AGE) VALUES ('Anna', 'Female', 12);")
    db.execute("INSERT INTO tblDetails (NAME, GENDER, AGE) VALUES ('Bill', 'Male', 45);")
    db.execute("INSERT INTO tblDetails (NAME, GENDER, AGE) VALUES ('Chase', 'Male', 22);")
    db.execute("INSERT INTO tblDetails (NAME, GENDER, AGE) VALUES ('Dorothy', 'Female', 36);")
    db.execute("INSERT INTO tblDetails (NAME, GENDER, AGE) VALUES ('Emily', 'Female', 11);")
end

db_path = ARGV[0]
db = SQLite3::Database.new( 'test.sqlite3' )
init(db)

age1, age2, person1, person2 = nil, nil, nil, nil

db.execute("SELECT NAME, MIN(AGE) FROM tblDetails WHERE GENDER = 'Female';") do |row|
    person1 = row[0]
    age1 = row[1]
end 

db.execute("SELECT NAME, MAX(AGE) FROM tblDetails WHERE GENDER = 'Female';") do |row|
    person2 = row[0]
    age2 = row[1]
end 

puts "#{person2} is #{age2-age1} years older than #{person1}"
