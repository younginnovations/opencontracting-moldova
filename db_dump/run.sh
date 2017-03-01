cd etender2mongoscripts
python pulldata.py
python dumpdata.py
python pulltenderitems.py
python dumptenderitems.py
cd ..
mongo localhost:27017/etenders_stage mongojsscripts/map_to_ocds.js
mongo localhost:27017/etenders_stage mongojsscripts/change_contracts_date.js
mongo localhost:27017/etenders mongojsscripts/rename.js
mongo localhost:27017/etenders mongojsscripts/change_contracts_date.js

sh ./createCsv.sh

#cd mongojsscripts
#
#mongo localhost:27017/etenders change_type_of_ocds_release_date.js
#sh ./generate_json_file.sh

#cd ../linkage
#
#python blacklist_script.py
#python contractors_script.py
#python courtcases_script.py
#python ocds_script.py


#sed -i.bak '/REFRESH_DATE/d' /home/moldova-ocds/demo/current/.env
#echo "REFRESH_DATE=$(date +%F)" >> /home/moldova-ocds/demo/current/.env

sed -i.bak '/REFRESH_DATE/d' /Users/bijunakarmi/Projects/moldova_ocds/.env
echo "REFRESH_DATE=$(date +%F)" >> /Users/bijunakarmi/Projects/moldova_ocds/.env
