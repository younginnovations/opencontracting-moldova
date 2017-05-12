/* 
 To run this script, run the following command in the cli
 # mongo localhost:27017/etenders create_contracts_csv.js
 */
var start = new Date().getTime();
print("starting Execution for Contracts");
db.tmp_contracts_summary.remove({});
db.ocds_release.find().forEach(function (release) {
    release.contracts.forEach(function (contracts) {
        /*Contract Id,Title,Description,Status,Tender Id,Tender Title,Goods,Goods CPV,Contractor Id,contractor,Procuring Agency id,Procuring Agency,Contract Start Date,Contract End Date,Amount*/
        var t = {
            'ocid'                  : release.ocid,
            'id'                    : contracts['id'],
            'title'                 : contracts['title'],
            'description'           : contracts['description'],
            'status'                : contracts['status'],
            'period/startDate'      : contracts['period']['startDate'],
            'period/endDate'        : contracts['period']['endDate'],
            'value/amount'          : contracts['value']['amount'],
            'value/currency'        : contracts['value']['currency'],
            'dateSigned'            : contracts['dateSigned'],
            'procuringEntity/name'  : release['buyer']['name'],
            'procuringEntity/id'    : release['buyer']['identifier']['id']
        };
        var awardID     = contracts['awardID'];
        var myCursor    = db.ocds_release.find({'awards.id': awardID}, {'awards.$': 1});
        var myDocument  = myCursor.hasNext() ? myCursor.next() : null;

        if (myDocument['awards'].length) {
            t['suppliers/id']  = (myDocument['awards'][0]['suppliers']) ? myDocument['awards'][0]['suppliers'][0]['additionalIdentifiers'][0]['id'] : '-';
            t['suppliers/name']    = (myDocument['awards'][0]['suppliers']) ? myDocument['awards'][0]['suppliers'][0]['name'] : '-';
            t['items/description']         = (typeof myDocument['awards'][0]['items'][0] !== 'undefined') ? myDocument['awards'][0]['items'][0]['classification']['description'] : '-';
            t['items/id']      = (typeof myDocument['awards'][0]['items'][0] !== 'undefined') ? myDocument['awards'][0]['items'][0]['classification']['id'] : '-';
        }

        db.tmp_contracts_summary.insert(t);
    });

});
var end = new Date().getTime();
var time = end - start;
print("Execution Time (seconds) ", time / 1000);
print("finished Execution for Contracts.");

//mongoexport -d etenders -c tmp_contracts_summary --type=csv --fields id,title,description,status,tenderID,tenderTitle,goods,goodsCPV,contractorID,contractor,procuringAgencyID,procuringAgency,contractStartDate,contractEndDate,amount --out /Users/owner/homesteadSites/moldova-ocds/public/csv/contracts_csv.csv;
