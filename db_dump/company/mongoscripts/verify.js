var count = 0;
var found = 0;

function findExactMatch(name) {
    var res = db.companies_xlsx.find({"cleanname": name})
    return res.count();
}

function findRegexMatch(name) {
    var res = db.companies_xlsx.find({"cleanname": new RegExp(name)})
    return res.count();
}

var match = 0, regex_match = 0;
db.companies_etenders.find({}).forEach(function(company) {    
    found = 0
    match = findExactMatch(company.cleanname);    
    if(!match) {
    	//if exact match not find, try regex match
        regex_match = findRegexMatch(company.cleanname);
        if(!regex_match) {
            print(company.cleanname)
            count += 1
        }
    }
});

print("Total unmatched names: ", count);