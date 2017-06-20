load('helper.js');

//add clear name to each blacklist_companies
db.blacklist_collection.find({}).forEach(function(company) {
    company['clear_name'] = cleanup_name(company['organizationName']);
    db.blacklist_collection.save(company);
});
