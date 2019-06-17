#!/bin/bash

x=0
save=""
file='test.txt'

cat $file | while read Y; do

    if [[ $x -eq 0 ]]; then
        let x++
        save=$(echo $Y)
        echo $x $Y
    elif [[ "$save" != "$Y" ]]; then
        let x++
        save=$(echo $Y)
        echo $x $Y
    fi
done

