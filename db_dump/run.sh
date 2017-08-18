#!/usr/bin/env bash
echo `date`
cd `dirname $0`

set -e;
set -a; . ../.env; set +a;

## REFRESH_DATE should be kept 2012-11-01 for the first import
export DATABASE=$DB_DATABASE
export import_start_date=$REFRESH_DATE
export PUBLIC_PATH=`readlink -e ../public`

cd etender2mongoscripts

python pulldata.py
python dumpdata.py
python pulltenderitems.py
#python dumptenderitems.py
cd ..
mongo localhost:27017/etenders_stage mongojsscripts/map_to_ocds.js
mongo localhost:27017/etenders_stage mongojsscripts/change_contracts_date.js
set +e;
mongo localhost:27017/$DATABASE mongojsscripts/rename.js --eval "var DATABASE='$DATABASE'"
mongo localhost:27017/$DATABASE mongojsscripts/change_contracts_date.js

echo creating csv files
sh ./createCsv.sh

cd mongojsscripts
#
#mongo localhost:27017/etenders change_type_of_ocds_release_date.js
sh ./generate_json_file.sh
cd ..

#cd ../linkage
#
#python blacklist_script.py
#python contractors_script.py
#python courtcases_script.py
#python ocds_script.py

#assesment of data

cd assessmentscripts

mongo localhost:27017/$DATABASE prepare.js
mongo localhost:27017/$DATABASE --quiet summarize.js > $PUBLIC_PATH/csv/assessment.csv

cd ..

cd company/mongoscripts
mongo localhost:27017/$DATABASE run_for_etenders.js
cd ../../

sed -i.bak '/REFRESH_DATE/d' ././../.env
echo "REFRESH_DATE=$(date +%F)" >> ././../.env
echo `date`
