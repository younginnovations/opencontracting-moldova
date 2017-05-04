// mongo prepare.js

var count = 0
db.tmp_summary_awards.remove({})
// db.ocds_release.find({}).limit(5).forEach(function(release){
db.ocds_release.find({}).forEach(function(release){
    var procuringEntity = release.tender.procuringEntity.identifier.legalName;
    var tenderStartDate = new Date(release.tender.tenderPeriod.startDate);
    release.awards.forEach(function(award) {
        var contractStartDate = new Date(award.contractPeriod.startDate);            
        var good = {
            "tender_id": release.tender.id,
            "award_id": award.id,
            "items_count": award.items.length,
            "suppliers_count": award.suppliers.length,
            "value": award.value.amount,
            "procuring_entity":procuringEntity,
            "tender_start_year": tenderStartDate.getFullYear(),
            "contract_start_year":contractStartDate.getFullYear(),
            "good_code":"",
            "good_description":"",
            "supplier_name":""
        }
        award.items.forEach(function(item) {
            good.good_code = item.classification.id,
            good.good_description = item.classification.description
        });
        award.suppliers.forEach(function(supplier) {
            good.supplier_name = supplier.name
        });
        db.tmp_summary_awards.insert(good);
    })    
});

db.tmp_summary_tenders.remove({})
// db.ocds_release.find({}).limit(5).forEach(function(release){
db.ocds_release.find({}).forEach(function(release){
    var procuringEntity = release.tender.procuringEntity.identifier.legalName;
    var tenderStartDate = new Date(release.tender.tenderPeriod.startDate);
    var awared_length = release.awards.length;
    var tender = {
        "items_count": release.tender.items.length,
        "awards_count": release.awards.length,
        "procuring_entity":procuringEntity,
        "tender_start_year": tenderStartDate.getFullYear()
    }
    db.tmp_summary_tenders.insert(tender);

});

/*

> find awards which has items count > 1
db.getCollection('tmp_summary_awards').find({items_count:{"$gt":1}})
db.getCollection('tmp_summary_awards').find({suppliers_count:{"$gt":1}})

*/