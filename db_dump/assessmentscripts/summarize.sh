cd `dirname $0`
DATABASE="etenders"
mongo localhost:27017/$DATABASE prepare.js
mongo localhost:27017/$DATABASE --quiet summarize.js > assessment.csv