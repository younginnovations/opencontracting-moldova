#!/usr/bin/env bash

cd `dirname $0`

export DATABASE=`awk 'BEGIN{FS="="} {if(/DB_DATABASE/) print $2}' ../../.env`

cd mongoscripts
mongo localhost:27017/$DATABASE blacklist.js
cd ..
