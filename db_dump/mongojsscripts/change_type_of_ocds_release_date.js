/*
 To run this script, run the following command in the cli
 # mongo localhost:27017/etenders change_type_of_ocds_release_date.js
 */

db.ocds_release.find().forEach(function(doc) {
    doc.date=new Date(doc.date);
    db.ocds_release.save(doc);
});