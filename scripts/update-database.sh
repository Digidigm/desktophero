#!/bin/sh
DBNAME=hero
USER=hero
PASSWORD=hero
cd /home/trebor/www/desktophero/database/schema/hero
liquibase --url="jdbc:mysql://localhost:3306/$DBNAME?createDatabaseIfNotExist=true" --username="$USER" --password="$PASSWORD" --changeLogFile=hero.xml $1 $2
