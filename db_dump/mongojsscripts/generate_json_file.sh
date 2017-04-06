#!/bin/bash

path=/Users/bijunakarmi/Projects/moldova_ocds/


years=`mongo --quiet localhost:27017/etenders fetch_year.js`

echo '{"links":{ "all":[' > ${path}public/jsons/releases.json
for year in $years
do
    echo \"http://moldova-demo.yipl.com.np/ocds-api/year/$year\", >> ${path}public/jsons/releases.json
    echo "Generating JSON file for $year"
    echo $(date)

    mongo --quiet --eval "var year=$year" localhost:27017/etenders create_json_files.js > ${path}public/jsons/releases-$year.json
    echo "Finished generating JSON file for $year"
done
echo ']}}' >> ${path}public/jsons/releases.json
