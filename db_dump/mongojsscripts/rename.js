var start = new Date().getTime();
var collections = [
    "contracts_collection",
    "announcements_collection",
    "ocds_release",
    "tenders_collection",
    "tender_items_collection"
];
collections.forEach(function (collection) {
    db[collection].drop();
});
db.copyDatabase("etenders_stage",DATABASE,"localhost");
var end = new Date().getTime();
var time = end - start;
print("Execution Time (seconds) ", time/1000);