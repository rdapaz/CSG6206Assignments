#!/bin/bash

if [ $# -gt 1 ] || [ $# -lt 1 ]; then
	echo "[-] Required 1 argument, supplied $#..."
	echo "[-] Please enter a single argument for the folder path"
	exit 1
else
	if [ ! -d $1 ]; then
		echo "[-] Path '$1' not valid!"
		exit 2
	else
		folder=$1

		cd $folder


		sqlite3 $folder/md5hash.db <<- EOF
		CREATE TABLE IF NOT EXISTS md5hashes
		(
			id integer PRIMARY KEY,
			filename TEXT,
			md5hash TEXT
		);
		DELETE FROM md5hashes;
		EOF

		for file in `ls` ; do

			if [ -d $file ]; then
				continue
			else
				if [ ${file:0:10} == 'md5hash.db' ]; then
					continue
				else

					
					md5hash=`md5sum $file | awk {'print $1'}`

					sqlite3 $folder/md5hash.db "INSERT INTO md5hashes \
					(filename, md5hash) \
					VALUES (\"$file\", \"$md5hash\");" 
					
				fi
			fi
		done
				
		results=$(sqlite3 $folder/md5hash.db "SELECT DISTINCT filename, md5hash from md5hashes ORDER BY 1 DESC;")

		if [ ${#results} -gt 0 ]; then
			echo "[+] MD5 hashes for $folder:"
			echo
		else
			echo "[-] No files to process"
		fi

		for entry in ${results[@]}; do
				echo $entry | awk -F \| {'print $1 ": " $2'}
		done

	fi
fi