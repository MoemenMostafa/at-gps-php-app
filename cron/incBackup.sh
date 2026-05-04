#!/bin/bash
# Shell script to backup MySql database
 
# CONFIG - Only edit the below lines to setup the script
# ===============================
 
MyUSER="atgps"           # USERNAME
MyPASS="gps123"       # PASSWORD
MyHOST="127.0.0.1"      # Hostname
 
S3Bucket="atgps" # S3 Bucket
 
# DO NOT BACKUP these databases
IGNORE="test"
 
# DO NOT EDIT BELOW THIS LINE UNLESS YOU KNOW WHAT YOU ARE DOING
# ===============================
 
# Linux bin paths, change this if it can not be autodetected via which command
MYSQL="$(which mysql)"
MYSQLDUMP="innobackupex"
CHOWN="$(which chown)"
CHMOD="$(which chmod)"
GZIP="gzip"
 
# Backup Dest directory, change this if you have someother location
DEST="/data/backups"
 
# Main directory where backup will be stored
MBD="$DEST/mysql-inc"
 
# Get hostname
HOST="$(hostname)"
 
# Get data in dd-mm-yyyy format
NOW="$(date +"%d-%m-%Y")"
 
# File to store current backup file
FILE=""
 
[ ! -d $MBD ] && mkdir -p $MBD || :
 
# Only root can access it!
$CHOWN 0.0 -R $DEST
$CHMOD 0600 $DEST

FILE="$MBD/$HOST.$NOW.gz"
# dump databas
$MYSQLDUMP --user=$MyUSER --password=$MyPASS --incremental --incremental-basedir= --stream=tar ./ | $GZIP - > $FILE
 
# copy mysql backup directory to S3
aws s3 cp $MBD s3://$S3Bucket/mysql/inc

