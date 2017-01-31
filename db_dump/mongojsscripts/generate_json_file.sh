#!/bin/bash

years=`mongo --quiet localhost:27017/etenders fetch_year.js`
echo '{"links":{ "all":[' > /Users/owner/homesteadSites/moldova-ocds/public/jsons/releases.json
for year in $years
do
    echo \"http://localhost:8000/ocds-api/year/$year\", >> /Users/owner/homesteadSites/moldova-ocds/public/jsons/releases.json
    echo $(date)

    mongo --quiet --eval "var year=$year" localhost:27017/etenders create_json_files.js > /Users/owner/homesteadSites/moldova-ocds/public/jsons/releases-$year.json
done
echo ']}}' >> /Users/owner/homesteadSites/moldova-ocds/public/jsons/releases.json
