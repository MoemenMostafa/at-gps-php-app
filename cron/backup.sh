#!/bin/bash
# Shell script to backup MySql database
 

full_backup(){

        echo "doing full backup..."
        echo "cleaning the backup folder..."
        rm -rf $DEST/*

        [ ! -d $DEST ] && mkdir -p $DEST || :

        # Only root can access it!
        $CHOWN 0.0 -R $DEST
        $CHMOD 0600 $DEST

        # dump databas
        $MYSQLDUMP --user=$MyUSER --password=$MyPASS --no-timestamp $DEST/full

	# gzip backup files
	echo "gzip backup files"
	tar -cvzf $DEST/full.tar.gz $DEST/full

	# clean S3 bucket
	echo "clean S3 bucket"
	/usr/local/bin/aws s3 rm --recursive s3://$S3Bucket/mysql

	# copy mysql backup directory to S3
	echo "copy mysql backup directory to S3"
	/usr/local/bin/aws s3 cp $DEST/full.tar.gz s3://$S3Bucket/mysql/full/full.tar.gz
}

incremental_backup(){

        if [ ! -d $DEST/full ]
        then
                echo "ERROR: no full backup has been done before. aborting"
                exit -1
        fi

        #we need the incremental number
        if [ ! -f $DEST/last_incremental_number ]; then
            NUMBER=1
        else
            NUMBER=$(($(cat $DEST/last_incremental_number) + 1))
        fi
        date
        
	[ ! -d $DEST/inc$NUMBER ] && mkdir -p $DEST/inc$NUMBER || :

	echo "doing incremental number $NUMBER"
        if [ $NUMBER -eq 1 ]
        then

	        # dump databas
        	$MYSQLDUMP  --no-timestamp --user=$MyUSER --password=$MyPASS --incremental $DEST/inc$NUMBER/inc --incremental-basedir=$DEST/full
	else
		# dump databas
                $MYSQLDUMP --user=$MyUSER --password=$MyPASS --no-timestamp --incremental $DEST/inc$NUMBER/inc --incremental-basedir=$DEST/inc$(($NUMBER - 1))/inc
	fi
	date
	echo $NUMBER > $DEST/last_incremental_number
        echo "incremental $NUMBER done!"

        # gzip backup files
	echo "gzip backup files"
        tar -cvzf $DEST/inc$NUMBER/inc.tar.gz $DEST/inc$NUMBER/*

        # copy mysql backup directory to S3
	echo "copy mysql backup directory to S3"
        /usr/local/bin/aws s3 cp $DEST/inc$NUMBER/inc.tar.gz s3://$S3Bucket/mysql/inc$NUMBER/inc.tar.gz


}



# CONFIG - Only edit the below lines to setup the script
# ===============================
 
MyUSER="atgps"           # USERNAME
MyPASS="gps123"       # PASSWORD
MyHOST="10.114.0.2"      # Hostname
 
S3Bucket="atgps" # S3 Bucket
 
# DO NOT EDIT BELOW THIS LINE UNLESS YOU KNOW WHAT YOU ARE DOING
# ===============================
 
# Linux bin paths, change this if it can not be autodetected via which command
MYSQL="$(which mysql)"
MYSQLDUMP="innobackupex"
CHOWN="$(which chown)"
CHMOD="$(which chmod)"
GZIP="gzip"
aws="$(which aws)"
 
# Backup Dest directory, change this if you have someother location
DEST="/data/backups"

# Get hostname
HOST="$(hostname)"

# Get data in dd-mm-yyyy format
NOW="$(date +"%d-%m-%Y")"

# File to store current backup file
FILE=""



if [ $# -eq 0 ]
then
usage
exit 1
fi

    case $1 in
        "full")
            full_backup
            ;;
        "incremental")
        incremental_backup
            ;;
        "restore")
        restore
            ;;
        "help")
            usage
            break
            ;;
        *) echo "invalid option";;
    esac

