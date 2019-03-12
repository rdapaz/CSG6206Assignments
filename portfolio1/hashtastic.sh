#!/usr/bin/env bash

# Bash utility listing for CSG6206 Portfolio 1
# Author: Ricardo da Paz (10431652)
# Github: https://github.com/rdapaz/CSG6206.git
#         Note that this is a private repo so please
#         email me pull requests

currentVersion="1.0.0"

# Function defined to return the usage of the script
# in the event of errors
usage() {
  cat <<EOF
Hashtastic
Description: Lists the md5 hashes of the files in the 
             current folder ordered by filename in
             descending order.  Note the explicit
             paths are required.
Usage: hashtastic.sh [folder]
Examples:
  hashtastic.sh /root/Desktop/CSG6206/portfolio1/resources     

EOF
}

# If the number of arguments passed to the script is more than
# 1 or less than 1 we output an error message and exit with 
# with error code 1


if [ $# -gt 1 ] || [ $# -lt 1 ]; then
	usage
	echo "[-] Required 1 argument, supplied $#..."
	exit 1
else

	# if the contents of the first argument do not correspond
	# to a valid path in our system we output an error
	# message and exit with error code 2
	if [ ! -d $1 ]; then
		usage
		echo "[-] Path '$1' not valid!"
		exit 2
	else

		# Up until now $1 could have been anything but if we got
		# to here it is definitely a valid folder so let's store
		# this in a proper variable
	
		folder=$1

		cd $folder

		# Capture and store the outpur from running ls
		# Note that we have deliberately designed the script
		# to not process hidden files (starting with a .)
		# as we have not run ls -a

		files=`ls`

		# This is intended to prevent empty folders from being
		# 'polluted' with an md5hash.db file if the script is 
		# called in error

		if [ ${#files} -gt 0 ]; then

			# invoke sqlite3 passing in the path to the .db file
			# and the command to be executed.  Here we use the 
			# HEREDOC format for multiline strings.  By using the
			# <<- construct, we can place the EOF token indented
			# Note the use of the CREATE TABLE IF NOT EXISTS
			# SQL construct which is available in sqlite3.  
			# This prevents errors from being called if the 
			# Database already exists.  It also obviates the need
			# to DROP the database at the end of the script
			# as this seems like a waste... Note that we DO however
			# delete any previous entries in the md5hashes table
			# as these may no longer be valid if files were updated.

			sqlite3 $folder/md5hash.db <<- EOF
			CREATE TABLE IF NOT EXISTS md5hashes
			(
				id integer PRIMARY KEY,
				filename TEXT,
				md5hash TEXT
			);
			DELETE FROM md5hashes;
			EOF
		fi

		# Now we loop through every 'file' in the path
		# note that file may contain the name of a folder in our
		# path so we test whether the 'file' in question is a 
		# folder or directory with the -d option, continuing
		# on with the next file if this is the case

		for file in ${files[@]}; do

			if [ -d $file ]; then
				continue
			else

				# Here we check whether the md5hash.db file was 
				# left behind from a previous run.  As this db file
				# is only used for the purpose of processing this 
				# script, we don't want to list it here

				if [ ${file:0:10} == 'md5hash.db' ]; then
					continue
				else

					# Here we calculate the md5 hash of a file
					# by runnig the md5sum command against the file
					# We pipe the output to awk as md5sum outputs
					# the file name appended to the hash 
					# (conveniently separated by a space)
					
					md5hash=`md5sum $file | awk {'print $1'}`

					# Store the data into the md5hashes in our
					# md5hash database  Note the need to escape
					# the " quote characters inside our quote. Also
					# \s are required at the end of each line
					# to allow the string to span multiple lines
					# This is an alternative to the HEREDOC
					# method used above.

					sqlite3 $folder/md5hash.db \
						"INSERT INTO md5hashes \
						(filename, md5hash) \
						VALUES (\"$file\", \"$md5hash\");" 
					
				fi
			fi
		done

		# Now we are left with the task of outputing to the screen
		# We do this by running an sqlite3 query against our newly
		# populated table.
		# If we have at least one result, we print a banner
		# advertising the fact that hashes are available and then
		# list all of the hashes.  
		# Alternatively, if no results are available we just
		# alert the user of this event.
		# Note that since we are storing the output of the command
		# into a shell variable we need to use either the ` or the
		# $() construct.   Here we chose the latter.

				
		results=$(sqlite3 $folder/md5hash.db \
			"SELECT DISTINCT filename, md5hash from md5hashes \
			 ORDER BY 1 DESC;")

		if [ ${#results} -gt 0 ]; then
			echo "[+] MD5 hashes for $folder:"
			echo
			for entry in ${results[@]}; do
					# Note that we pipe the output of echoing $entry
					# to awk as this output is pipe delimited
					# We also get awk to use the pipe as the delimiter
					# with the -F \| portion of the command.  Note that 
					# the backslash is required to escape the pipe
					# character as this has a specific meaning in
					# the shell
					echo $entry | awk -F \| {'print $1 ": " $2'}
			done
		else
			echo "[-] No files to process"
		fi


	fi
fi
