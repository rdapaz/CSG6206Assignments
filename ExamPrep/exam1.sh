#!/bin/bash
data=`cat data.txt`
count=1
for line in $data; do
    let count++
    echo ${line:0:1}
    # if [ $((count%2)) -eq 0 ]; then
    #     echo $line
    # fi
done
# echo $count