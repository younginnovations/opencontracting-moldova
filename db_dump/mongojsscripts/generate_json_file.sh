#!/bin/bash

years=`mongo --quiet localhost:27017/$DATABASE fetch_year.js`

echo '{"links":{ "all":[' > $PUBLIC_PATH/jsons/releases.json
for year in $years
do
    echo \"$APP_URL/ocds-api/year/$year\", >> $PUBLIC_PATH/jsons/releases.json
    echo "Generating JSON file for $year"
    echo $(date)

    mongo --quiet --eval "var year=$year, url='$APP_URL/ocds-api/year/';" localhost:27017/$DATABASE create_json_files.js > $PUBLIC_PATH/jsons/releases-$year.json
    echo "Finished generating JSON file for $year"
done
echo ']}}' >> $PUBLIC_PATH/jsons/releases.json
