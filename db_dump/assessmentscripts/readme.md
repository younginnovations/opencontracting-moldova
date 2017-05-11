* check 'dbconfig.js' to the database name and port
* run 'mongo prepare.js' to prepare the awards and tenders summary collection
* these tmp summary collection will make the summarize script easy to understand and code
* run 'mongo --quiet summarize.js > summary.csv' to prepare the summary of the tables in the portal

or 

* check 'dbconfig.js' to the database name and port
* run 'bash summarize.sh' to prepare and generate csv summary
