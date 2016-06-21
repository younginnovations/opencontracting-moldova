var start = new Date().getTime();
db.dropDatabase();
db.copyDatabase("etenders_stage","etenders","localhost");
var end = new Date().getTime();
var time = end - start;
print("Execution Time (seconds) ", time/1000);