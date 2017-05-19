function dump_etender_companies() {
    db.companies_etenders.remove({})
    var cache = [] 
    db.ocds_release.find({}).forEach(function(release){
        release.awards.forEach(function(award) {
            award.suppliers.forEach(function(supplier) {
                if(cache.indexOf(supplier.name) === -1) {
                    db.companies_etenders.insert({name: supplier.name});
                    cache.push(supplier.name);
                }
            });
        });
    });
    return db.companies_etenders.count();
}

function cleanup_name(str) {
	return str.toLowerCase()
        .trim()
        .replace(/,/g, " ")
        .replace(/\\/g, " ")
        .replace(/"/g, " ")
        .replace("”", " ")        
        .replace("  "," ")
        .replace("”"," ")
        .replace("„"," ")    
        // .replace("intreprinderea mixta","")
        .replace("/[îi]+ntreprinderea mixt[ăa]+/g","")
        .replace("întreprinderea mixtă","")
        .replace("intreprinderea mixta","")        
        .replace("intreprinderea individuala","")
        .replace("intreprinderea individuală","")
        .replace("întreprindere individuală","")        
        .replace("întreprinderea individuală","")
        .replace("întreprinzător individual","")    
        .replace("întreprinător individual","")     
        .replace("întreprinzătorul individual"," ")   
        .replace("întreprinderea municipală"," ")
        .replace("întreprinderea cu capital integral străin","")        
        .replace("întreprinderea de stat","")
        .replace("întreprinderea cu capital străin","")
        .replace("întreprinderea cu capital","")        
        .replace("compania de distribuţie", " ")
        .replace(/^cd /, " ")        
        .replace("firma de cercetare producţie şi comerţ","")       
        .replace("firma comercială de producţie"," ") 
        .replace("firma de producţie şi comerţ"," ")         
        .replace("f.c.p."," ")
        .replace("societatea comercială","")
        .replace("societatea cu răspundere limitată","")
        .replace("societate cu răspundere limitată","")
        .replace("societate cu raspundere limitata","")        
        .replace("societatea pe acţiuni","") 
        .replace("societate pe acţiuni","") 
        .replace("compania internaţională de asigurări","") 
        .replace("compania internaţională de asigurări"," ")                 
        .replace("societatea comercială"," ")             
        .replace("societatea cu răspundere limitată"," ")
        .replace("societatea cu răspundere limitatîă"," ")
        .replace("Reţelele Electrice de Iluminat", " ")
        .replace("r.e.i."," ")    
        .replace("c.i.a. "," ")        
        .replace(/s\.r\.l\./g," ")
        .replace(" srl "," ")
        .replace(" srl"," ")
        .replace("srl "," ")
        .replace("f.c.p.c."," ")        
        .replace(/f\.p\.c\./g," ")
        .replace("fpc "," ")        
        .replace("r.c.c."," ")
        .replace("c.c.s."," ")
        .replace("s.c."," ")
        .replace("sc "," ")
        .replace("s.c "," ")
        .replace("întreprinderea cooperatistă de construcţie"," ")
        .replace("î.c.c."," ")
        .replace("î.c.s."," ")
        .replace("i.c.s.", " ")
        .replace("î.c.i.s."," ")        
        .replace("î.m."," ")
        .replace("i.m."," ")
        .replace("î.s."," ")
        .replace("îs"," ")        
        .replace("î.i."," ")
        .replace("îi "," ")
        .replace(" îi"," ")
        .replace(" ii"," ")        
        .replace("s.r.l"," ")
        .replace("о.m."," ")
        .replace("о.s."," ")
        .replace("о.i."," ")
        .replace("s.a."," ")
        .replace("s.a "," ")
        // .replace("/\s+sa$/g"," ")
        // .replace("/^sa\s+/g"," ")
        .replace(/\s\s+/g, " ")
        .trim();
}

function remove_dups(db_collection) {
    var before_count = db_collection.count();
    db_collection.aggregate([
    // discard selection criteria, You can remove "$match" section if you want
        { $match: { 
            name: { "$ne": '' }  
        }},
        { $group: { 
        _id: { name: "$name"}, // can be grouped on multiple properties 
        dups: { "$addToSet": "$_id" }, 
        count: { "$sum": 1 } 
        }}, 
        { $match: { 
        count: { "$gt": 1 }    // Duplicates considered as count greater than one
        }}
    ],
    {allowDiskUse: true} // For faster processing if set is larger
    )               
    // You can display result until this and check duplicates 
    .forEach(function(doc) {
        doc.dups.shift();      // First element skipped for deleting
        db_collection.remove({_id : {$in: doc.dups }});  // Delete remaining duplicates
    });
    var after_count = db_collection.count();
}
