#!/bin/bash
content=`curl -L http://10.11.12.126  2> /dev/null | grep "Garage is"`
epoch=`date "+%s"`
if [[ $content =~ 'Closed' ]]; then
    # echo 'Garage is closed'
    status="Closed"
elif [[ $content =~ 'Open' ]]; then
    # echo 'Garage is Open'
    status="Open"
else
    # echo "Undefined"
    status="Undef"
fi

echo $status 
echo $epoch

sqlite3 '/home/rdapaz/Desktop/garage.sqlite3' \
        "CREATE TABLE IF NOT EXISTS garage_status (id INTEGER PRIMARY KEY, status TEXT, epoch LONG);"

sqlite3 '/home/rdapaz/Desktop/garage.sqlite3' \
        "INSERT INTO garage_status (status, epoch) VALUES (\"$status\", \"$epoch\");"

# query = `sqlite3 '/home/rdapaz/Desktop/garage.sqlite3' "SELECT * FROM garage_status WHERE status = 'Closed';"`

# echo $query