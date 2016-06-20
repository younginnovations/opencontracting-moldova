cd etender2mongoscripts
python pulldata.py
python dumpdata.py
python pulltenderitems.py
python dumptenderitems.py
cd ..
mongo localhost:27017/etenders_staging mongojsscripts/map_to_ocds.js

# mongodump -d etenders_staging -o mongodump
# mongorestore -d etenders mongodump/old_db_name