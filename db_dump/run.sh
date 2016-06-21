cd etender2mongoscripts
python pulldata.py
python dumpdata.py
python pulltenderitems.py
python dumptenderitems.py
cd ..
mongo localhost:27017/etenders_stage mongojsscripts/map_to_ocds.js
mongo localhost:27017/etenders mongojsscripts/rename.js
