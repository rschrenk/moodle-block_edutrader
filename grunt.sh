#!/bin/sh

if [ "$1" = "uponly" ]
then
    /home/rschrenk/transfer.sh up edutrader
    exit
fi

cd amd && grunt amd --force && cd ..
grunt

if [ "$1" = "up" ]
then
    /home/rschrenk/transfer.sh up edutrader
fi
