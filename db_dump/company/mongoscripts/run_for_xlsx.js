load("helper.js")

remove_dups(db.companies_detail);

var count = 0;
db.companies_detail.find({}).forEach(function(company) {
        company['cleanname'] = cleanup_name(company['name']);
        if(company['cleanname'] === company['name'].toLowerCase()) {
                // print(company['cleanname'], company['name']);
                count += 1;
        }
        db.companies_detail.save(company);
});