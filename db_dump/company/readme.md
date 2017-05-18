## Background

This readme contains instructions to setup company comparison logic to display the company detail information (contained in excel file which is updated on a monthly basis). The names in the excel file don't follow the given structure and don't easily match with the company names mentioned in the etenders site. Both the names are cleaned-up for common words like SRL and other company related common words. Then the cleaned-names are compared with each other to show the company detailed information from the excel file. 

There are still cases where there are no each matches as the spellings are not proper, like  there are missing letters at times. The matching could still be improved with text-mining - which is not yet done.

When there's an update in the etenders site, just run step 4 to get the new company names from etenders and clean up. 

When there's a new excel file, run step 2 and 3 to import the company names and to clean up. 


### 1. setup for running python and js scripts

* Install necessary packages
 * pip install pymongo
 * pip install xlrd
* copy `dbconfig.py.bak` to `dbconfig.py` and update mongo database name as necessary.
* copy `mongoscripts/dbconfig.js.bak` to `mongoscripts/dbconfig.js` and update mongo database name as necessary.

### 2. Steps to download company excel file and dump into mongodb

* Download latest file from `http://date.gov.md/ckan/ro/dataset/11736-date-din-registrul-de-stat-al-unitatilor-de-drept-privind-intreprinderile-inregistrate-in-repu` to `data/company.xlsx`. Please note filename should be `company.xlsx`
* Run `python dump_excel.py` to dump the content of `company.xlsx` to mongodb collection `companies_xlsx`. It truncates collection first and then dumps. It takes around 3 min to dump the 20+ MB excel file.

### 3. Process after excel file dump

* enter `mongoscripts` directory using `cd mongoscripts`
* check `dbconfig.js` for dbname and update dbname as required.
* run `mongo run_for_xlxs.js` to remove duplicate company names and generate cleanname for comparison later.

### 4. Steps to prepare etenders company collection and clean them

* enter `mongoscripts` directory using `cd mongoscripts`
* run `mongo run_for_etenders.js` to create a new collection `companies_etenders` from the collection `ocds_release` containing unique company names only, it also generates clean name for comparison.

### 5. Steps to verify the clean names (this is optional step - for verification only)

* enter `mongoscripts` directory using `cd mongoscripts`
* run `mongo verify.js > non-valid.txt` to list the unmatched names in a separate text file to see the results. 


### 6. Showing company information in the contractor's detailed page

* find the company clean name in `companies_etenders` collection based on the contractor's name mentioned in the `ocds_release` collection
* get the company detailed information in `companies_xlsx` collection based on the clean-name. See `verify.js` on the process.


