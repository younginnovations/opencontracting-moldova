load("helper.js")

// dumps unique companies names from ocds_release 
dump_etender_companies();

var count = 0;
db.companies_etenders.find({}).forEach(function(company) {
        company['cleanname'] = cleanup_name(company['name']);
        if(company['cleanname'] === company['name'].toLowerCase()) {
                // print(company['cleanname'], company['name']);
                count += 1;
        }
        db.companies_etenders.save(company);
});
